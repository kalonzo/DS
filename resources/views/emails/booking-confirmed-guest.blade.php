@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
    # {{ $greeting }}
@else
    # Bonjour
@endif
Vous êtes cordialement invité(e) chez
<br/>

@component('mail::panel')
<p style="text-align: center;">
    {{ $establishment->getName() }}
    <br/>
    {{ $establishment->address()->first()->getDisplayable() }}
    <br/><br/>
    Le {{ $booking_date }} à {{ $booking_time }}

    @component('mail::button', ['url' => url($establishment->getUrl()), 'color' => 'blue'])
    Voir la page du restaurant
    @endcomponent
</p>
@endcomponent
    
@if(!empty($guest_message))
{{ $guest_message }}
<br/><br/>
@endif
<p style="text-align: right;">
    {{ $username }}
</p>

@component('mail::subcopy')
Si vous rencontrez des problèmes pour cliquer sur le bouton "Voir la page du restaurant", copiez et collez l'URL ci-dessous
dans votre navigateur : [{{ url($establishment->getUrl()) }}]({{ url($establishment->getUrl()) }})
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