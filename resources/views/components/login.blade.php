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
                    <a class="login-forgot-password" href="javascript:void(0);" onclick="getOnClickModal('Réinitialisation de votre mot de passe', '/password/reset', 
                                null, 'auth-modal', 'modal-md')">
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
                <a class="register-item" href="{{ url('/establishment/register') }}">
                    <div class="corner">
                        pro
                    </div>
                    <img src="/img/icons/add_user.svg" alt="Créer un compte"/>
                    Créer un compte professionnel
                </a>
                <a class="register-item color-inverted" href="javascript:void(0);" onclick="getOnClickModal('', '/register', {type_user: <?php echo App\Models\User::TYPE_USER;?>}, 
                            'register-modal', 'modal-md')">
                    <img src="/img/icons/add_user_dark.svg" alt="Créer un compte"/>
                    Créer un compte Dinerscope
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <a class="login-resend-activation" href="{{ url("/aktiv8me/resend") }}">
                    Recevoir à nouveau un email d'activation
                </a> 
            </div>
        </div>
        <br class="cleaner"/>
    </div>
    @else
    <ul class="logout-section">
        <li>
            <a href="{{ url('/admin') }}">
                <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                <span class="section-item">Espace personnel</span>
            </a>
        </li>
        <li class="hidden">
            <a href="#">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <span class="section-item">Editer profil</span>
            </a>
        </li>
        <?php
        if(Illuminate\Support\Facades\Auth::user()->getType() === App\Models\User::TYPE_USER_PRO){
            ?>
            <li>
                <a href="{{ url('/edit/establishment/'.getCurrentEstablishment()->getUuid()) }}">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    <span class="section-item">Editer établissement</span>
                </a>
            </li>
            <?php
        }
        ?>
        <li>
            <a href="{{ url('/logout') }}">
                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                <span class="section-item">Sortir</span>
            </a>
        </li>
    </ul>
    @endif
</div>