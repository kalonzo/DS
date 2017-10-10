Bonjour <?php echo $user->getFirstname()." ".$user->getLastname();?>,
<br/><br/>
Votre demande d'inscription a bien été prise en compte.
Pour finaliser votre demande, il ne vous reste plus qu'à <a href="<?php echo $link;?>" target="_blank">
cliquer sur ce lien</a> pour valider la création de votre compte.
<br/><br/>
Si le lien ne fonctionne pas, veuillez copier l'adresse suivante dans la barre d'adresse de votre navigateur :
<br/>
<a href="<?php echo $link;?>" target="_blank"><?php echo $link;?></a>
<br/><br/>
Vous pourrez ensuite vous connecter sur notre site.
<br/><br/>
<span>Nous vous remercions de votre confiance.</span>