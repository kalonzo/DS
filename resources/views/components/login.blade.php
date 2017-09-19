<div class="row">
    <div class="col-xs-12 text-center">
        <h3>Se connecter à mon dinerscope</h3>
    </div>
    <div class="col-xs-12 text-center">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Je souhaite être reconnu automatiquement à chaque connexion, 
                                   sans avoir à re-saisir mon adresse e-mail.
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>
            </div>
        </form>
        
        <a href="{{ url('/register') }}">Créer un compte Dinerscope</a>
    </div>
</div>