@component('mail::message')
# Parabéns, {{ $ong->name }}!

Sua ONG foi aprovada pelo administrador do Voluntariar!

Agora você já pode acessar o sistema normalmente com o **e-mail e senha que cadastrou**.

@component('mail::button', ['url' => route('login')])
Acessar o Sistema
@endcomponent

Atenciosamente,  
**Equipe Voluntariar**
@endcomponent