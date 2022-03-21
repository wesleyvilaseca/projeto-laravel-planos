@component('mail::message')
# Novo contato
Nome: {{ $data['name'] }} <br>
Assunto: {{ $data['subject'] }} <br>
Email : {{ $data['email'] }} <br>

Mensagem: {{ $data['message'] }}
{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
