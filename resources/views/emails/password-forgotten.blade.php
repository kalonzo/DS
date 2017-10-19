<div style="width: 100%; font-family: Avenir,Helvetica,sans-serif; color: #74787e; font-size: 16px; line-height: 1.5em;">
    Bonjour !
    <br/><br/>
    Vous avez demandé à réinitialiser le mot de passe de votre compte ou vous l’avez oublié.
    <br/><br/>
    Pour cette raison, cliquez sur le lien ci-dessous :
    <br/><br/><br/><br><br>
    <div style="text-align: center; width: 100%;">
        <a href="{{ $reset_link }}" style="padding: 15px 10px; background-color: #0f6694; color: white; border-radius: 8px;">
            Réinitialiser votre mot de passe
        </a>
    </div>
    <br/><br/><br><br>
    Le lien de fonctionne pas ? Copiez l’adresse suivante dans votre navigateur :
    <br/>    
    <a href="{{ $reset_link }}">{{ $reset_link }}</a>
    <br/><br/>
    Si vous n'avez pas demandé la réinitialisation de votre mot de passe, ignorez simplement cet email.
    <br/><br/>
    Cette requête a été déposée le : <?php echo formatDate(new DateTime());?>
    <br/><br/>
    Cordialement 
    <br/>
    L’Equipe Dinerscope
</div>