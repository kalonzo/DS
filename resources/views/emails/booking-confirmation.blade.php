@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
    # {{ $greeting }}
@else
    # Bonjour!
@endif

{!! $intro !!}

Votre demande a bien été transmise à l'établissement.
<br/><br/>
Un email de confirmation vous sera communiqué sous 24h.
<br/><br/>
Nous vous remercions de votre confiance.
<br/><br/>
Vous pouvez annuler votre réservation à tout moment en cliquant sur le bouton ci-dessous.
    
@component('mail::button', ['url' => $cancelUrl, 'color' => 'red'])
Annuler ma demande de réservation
@endcomponent

@component('mail::subcopy')
Si vous rencontrez des problèmes pour cliquer sur le bouton "Annuler ma demande de réservation", copiez et collez l'URL ci-dessous
dans votre navigateur : [{{ $cancelUrl }}]({{ $cancelUrl }})
@endcomponent

@isset($activateUrl)
<br/>
Vous pouvez activer votre compte en cliquant sur le bouton ci-dessous.

@component('mail::button', ['url' => $activateUrl, 'color' => 'blue'])
Activer mon compte maintenant
@endcomponent

@component('mail::subcopy')
Si vous rencontrez des problèmes pour cliquer sur le bouton "Activer mon compte maintenant", copiez et collez l'URL ci-dessous
dans votre navigateur : [{{ $activateUrl }}]({{ $activateUrl }})
@endcomponent
@endisset

<br/>
{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Cordialement,
<br>
L'équipe Dinerscope
@endif

@endcomponent