@extends('layouts.front')

@section('content')
<div class="row container-fluid">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
        <h1>
            {{ trans('aktiv8me.forms.resend.resend') }}
        </h1>
        <p>
            {{ trans('aktiv8me.forms.resend.info', ['max' => config('aktiv8me.max_tokens') - 1]) }}
        </p>
        <br/><br/><br/>
        <form class="form-horizontal" method="POST" action="{{ route('register.resend') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="email" class="col-md-4 control-label">
                    {{ trans('aktiv8me.forms.common.email') }}
                </label>
                <div class="col-md-6">
                    <?php
                    $emailValue = old('email');
                    if(isset($email)){
                        $emailValue = $email;
                    }
                    ?>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $emailValue }}" required autofocus>
                </div>
            </div>
            <br/><br/>
            <div class="form-group">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-primary form-data-button pull-right">
                        {{ trans('aktiv8me.forms.resend.submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
