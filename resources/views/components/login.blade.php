<div class="container-fluid">
    @if (!Auth::check())
    <div class="row login-section">
        <div class="col-xs-12 text-center">
            <h3>Se connecter à mon dinerscope</h3>
        </div>
        <form class="col-xs-12" method="POST" action="{{ route('login') }}" id="login-form">
            {{ csrf_field() }}
            <div class="row no-margin">
                <div class="input-group col-xs-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Adresse e-mail" required autofocus>
                </div>
                <br class="cleaner"/>
                <div class="input-group col-xs-12">
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Mot de passe">
                    <a class="login-forgot-password" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a> 
                </div>
                <div class="form-group col-xs-12">
                    <div class="checkbox text-left login-remember-me">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Je souhaite être reconnu automatiquement à chaque connexion, 
                                   sans avoir à re-saisir mon adresse e-mail.
                        </label>
                    </div>
                </div>
                <div class="input-group col-xs-12">
                    <button type="button" class="login-connection-button form-data-button">
                        Me connecter
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="row login-register-section">
        <div class="col-xs-12 text-center">
            <h3>Pas encore inscrit ?</h3>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a class="register-item" href="javascript:void(0);" onclick="getOnClickModal('', '/register', {type_user: <?php echo App\Models\User::TYPE_USER;?>}, 
                            'register-modal', 'modal-md')">
                    Créer un compte Dinerscope
                </a>
                <a class="register-item" href="{{ url('/establishment/register') }}">
                    Créer un compte professionnel
                </a>
            </div>
        </div>
        <br class="cleaner"/>
    </div>
    @else
    <div class="row logout-section">
        <p class="col-xs-12">
            <?php
//            $user = Auth::user();
//            echo "Bonjour ".$user->getFirstname().' '.$user->getLastname();
            ?>
        </p>
        <div class="input-group col-xs-12">
            <a type="button" class="btn btn-default login-logout" href="{{ url('/logout') }}">
                Me déconnecter
            </a>
        </div>
    </div>
    @endif
</div>