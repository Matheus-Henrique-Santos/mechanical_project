<?php

namespace App\Livewire\Mechanical;

use App\Models\Message;
use App\Models\Notification;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Messaging extends Component
{
    use WithPagination;

    public $contacts = [];
    public $selectedContact = null;
    public $messageContent = '';
    public $conversations = [];
    public $currentConversation = [];
    public $search = '';
    public $unreadMessages = [];
    public $quoteFilter = '';
    public $quotes = [];
    public $selectedQuote = null;

    // Event listeners
    protected $listeners = [
        'echo:messages,MessageSent' => 'refreshMessages',
        'refreshMessages' => '$refresh',
        'selectContact',
    ];

    public function mount()
    {
        // Load contacts (users that the current user has exchanged messages with)
        $this->loadContacts();

        // Load available quotes for filtering
        $this->loadQuotes();

        // Mark notifications as read
        $this->markNotificationsAsRead();
    }

    public function loadContacts()
    {
        $userId = Auth::id();

        // Get users that the current user has exchanged messages with
        $contactIds = Message::where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->get(['sender_id', 'recipient_id'])
            ->flatMap(function ($message) use ($userId) {
                return [$message->sender_id, $message->recipient_id];
            })
            ->reject(function ($contactId) use ($userId) {
                return $contactId == $userId;
            })
            ->unique()
            ->values();

        // Get user details for these contacts
        $this->contacts = User::whereIn('id', $contactIds)->get();

        // Count unread messages for each contact
        $this->unreadMessages = Message::where('recipient_id', $userId)
            ->where('read', false)
            ->get()
            ->groupBy('sender_id')
            ->map(function ($messages) {
                return $messages->count();
            })
            ->toArray();
    }

    public function loadQuotes()
    {
        $user = Auth::user();

        // Load quotes based on user role
        if ($user->role === 'mechanic') {
            $this->quotes = Quote::where('mechanic_id', $user->id)->get();
        } elseif ($user->role === 'client') {
            $this->quotes = Quote::where('client_id', $user->id)->get();
        } elseif ($user->role === 'store') {
            $this->quotes = Quote::whereHas('items', function ($query) use ($user) {
                $query->where('store_id', $user->id);
            })->get();
        }
    }

    public function markNotificationsAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('type', 'new_message')
            ->update(['read' => true]);
    }

    public function selectContact($contactId)
    {
        $this->selectedContact = User::findOrFail($contactId);
        $this->loadConversation();

        // Mark messages from this contact as read
        Message::where('sender_id', $contactId)
            ->where('recipient_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);

        // Reset unread count for this contact
        if (isset($this->unreadMessages[$contactId])) {
            $this->unreadMessages[$contactId] = 0;
        }
    }

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->loadContacts();
        } else {
            $this->contacts = User::where('name', 'like', '%' . $this->search . '%')
                ->where('id', '!=', Auth::id())
                ->get();
        }
    }

    public function updatedQuoteFilter()
    {
        $this->loadConversation();
    }

    public function loadConversation()
    {
        if (!$this->selectedContact) {
            return;
        }

        $userId = Auth::id();
        $contactId = $this->selectedContact->id;

        // Get messages between the current user and the selected contact
        $query = Message::where(function ($query) use ($userId, $contactId) {
            $query->where('sender_id', $userId)
                ->where('recipient_id', $contactId);
        })
            ->orWhere(function ($query) use ($userId, $contactId) {
                $query->where('sender_id', $contactId)
                    ->where('recipient_id', $userId);
            })
            ->orderBy('created_at', 'asc');

        // Apply quote filter if selected
        if (!empty($this->quoteFilter)) {
            $query->where('quote_id', $this->quoteFilter);
            $this->selectedQuote = Quote::find($this->quoteFilter);
        } else {
            $this->selectedQuote = null;
        }

        $this->currentConversation = $query->get();
    }

    public function sendMessage()
    {
        if (!$this->selectedContact) {
            return;
        }

        $this->validate([
            'messageContent' => 'required|string',
        ]);

        // Create new message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $this->selectedContact->id,
            'quote_id' => $this->quoteFilter ?: null,
            'content' => $this->messageContent,
        ]);

        // Create notification for recipient
        Notification::create([
            'user_id' => $this->selectedContact->id,
            'type' => 'new_message',
            'message' => Auth::user()->name . ' sent you a message',
            'notifiable_type' => 'App\Models\Message',
            'notifiable_id' => $message->id,
        ]);

        // Reset message content
        $this->messageContent = '';

        // Refresh conversation
        $this->loadConversation();
    }

    public function refreshMessages()
    {
        $this->loadContacts();
        $this->loadConversation();
    }

    public function render()
    {
        return view('livewire.mechanical.messaging')->layout('layouts.app');
    }
}
