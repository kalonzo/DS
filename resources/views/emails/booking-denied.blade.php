@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
    # {{ $greeting }}
@else
    # Bonjour
@endif

@foreach($lines as $line)
{{ $line }}
@if(!$loop->last)
<br/><br/>
@endif
@endforeach

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