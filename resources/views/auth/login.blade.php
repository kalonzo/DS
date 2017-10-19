@extends('layouts.front')

@section('content')
    <div class="row container-fluid">
        <div id="login-panel" class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
        @component('components.login')

        @endcomponent
        </div>
    </div>
@endsection
