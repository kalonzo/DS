@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
    # {{ $greeting }}
@else
    # Bonjour!
@endif

@foreach($lines as $line)
{{ $line }}
@endforeach
    
<table class="dual-column">
    <tbody>
        <tr>
            <td>
                @component('mail::button', ['url' => $confirmUrl, 'color' => 'green'])
                Confirmer
                @endcomponent

                @component('mail::subcopy')
                Pour "Confirmer", si vous rencontrez des problèmes pour cliquer sur le bouton, copiez et collez l'URL ci-dessous
                dans votre navigateur : [{{ $confirmUrl }}]({{ $confirmUrl }})
                @endcomponent
            </td>
            <td>
                @component('mail::button', ['url' => $denyUrl, 'color' => 'red'])
                Refuser
                @endcomponent

                @component('mail::subcopy')
                Pour "Refuser", si vous rencontrez des problèmes pour cliquer sur le bouton, copiez et collez l'URL ci-dessous
                dans votre navigateur : [{{ $denyUrl }}]({{ $denyUrl }})
                @endcomponent
            </td>
        </tr>
    </tbody>
</table>

<br/>
Pour vous rendre sur votre Dinerscope et gérer cette demande de réservation directement dans l'agenda, cliquez sur le bouton ci-dessous

@component('mail::button', ['url' => $mySpaceUrl, 'color' => 'blue'])
Aller sur mon espace client
@endcomponent

@component('mail::subcopy')
Si vous rencontrez des problèmes pour cliquer sur le bouton "Aller sur mon espace client", copiez et collez l'URL ci-dessous
dans votre navigateur : [{{ $mySpaceUrl }}]({{ $mySpaceUrl }})
@endcomponent

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