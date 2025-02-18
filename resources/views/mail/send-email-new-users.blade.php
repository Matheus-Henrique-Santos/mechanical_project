<x-mail::message>
    <p>{{'Olá, ' . $userName}}</p>
    <p>Você foi convidado para acessar a Mecanica, nossa plataforma exclusiva
    <p>Para acessar a plataforma pela primeira vez, clique no botão “Aceitar convite” e crie sua senha.</p>
    <x-mail::button :url="url('/reset-password/' . $token . '?email=' . urlencode($userEmail))">
        ACEITAR CONVITE
    </x-mail::button>
    <p>Se você já tem uma conta, clique no botão "Já tenho conta"</p>
    <x-mail::button :url="url('login')" :color="$colorSec">
        JÁ TENHO CONTA
    </x-mail::button>
    <p>Se você não solicitou este acesso ou autorizou o seu cadastro, por favor entre em contato com o e-mail privacidade@revoenergia.com.br</p>
    <span>Atenciosamente,</span> <br>
    <span>Mecanica</span>

    <x-slot:subcopy>
        @lang(
               "Caso não consiga acessar a opção “Aceitar convite”, utilize o link:",
        ) <span class="break-all">[{{ url('/reset-password/' . $token . '?email=' . urlencode($userEmail)) }}]({{ url('/reset-password/' . $token . '?email=' . urlencode($userEmail)) }})</span>
        <br>
        <br>
        @lang(
               "Caso não consiga acessar a opção “Já tenho conta”, utilize o link:",
        ) <span class="break-all">[{{ url('login') }}]({{ url('login') }})</span>
    </x-slot:subcopy>
</x-mail::message>
