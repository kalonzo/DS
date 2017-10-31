@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('prefooter')
        @component('mail::pre-footer')
            @component('vendor.notifications.pre-footer')
            @endcomponent
        @endcomponent
    @endslot
    @slot('footer')
        @component('mail::footer')
            @component('vendor.notifications.footer')
            @endcomponent
        @endcomponent
    @endslot
@endcomponent
