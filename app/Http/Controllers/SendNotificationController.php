<?php

namespace App\Http\Controllers;

use App\Notifications\SendEmailNewUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;

class SendNotificationController extends Controller
{
//    private const SEND_EMAIL = 'email@email.com';

    public static function sendEmailNewUser($idUser, $name, $email)
    {

        Notification::route('mail', $email)->notify(new SendEmailNewUsers($name));
    }
}
