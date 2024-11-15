<?php
/* echo '<pre>';
print_r($POST);
echo '<pre>'; */

$erreurs = [];
$nom = '';
$prenom = '';
$email = '';
$objet = '';
$message = '';
$validationMailOk = '';
$validationMailNotOk = '';

function sendMail(string $_nom, string $_prenom, string $_email, string $_objet, string $_message)
{
    if(
        $_nom !== '' &&
        $_prenom !== '' &&
        $_email !== '' &&
        $_objet !== '' &&
        $_message !== ''
    ){
        $to       = 'emailamandine@exemple.com';
        $subject  = $_objet;
        $message  = $_message;
        $headers  = array(
            'Form' => $_nom . " " . $_prenom,
            'Reply-to' => $_email,
        );

        mail($to, $subject, $message, $headers);

        return true;
    }
    else
    {
        return false;
    }
}

if($_POST) {
    if(isset($_POST['nom']) && $_POST['nom'] !== '')
    {
        $nom = $_POST['nom'];
    }
    else
    {
        $erreurs['nom'] = 'le nom doit contenir au moins trois caractères!';
    }

    if(isset($_POST['prenom']) && $_POST['prenom'] !== '')
    {
        $prenom = $_POST['prenom'];
    }
    else
    {
        $erreurs['prenom'] = 'le prenom ne doit pas etre vide !';
    }

    if
    (
        isset($_POST['email']) &&
        $_POST['email'] !== '' &&
        filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    )
    {
        $email = $POST['email'];
    }
    else
    {
        $erreurs['email'] = 'le mail n est pas valide';
    }

    if(isset($_POST['objet']) && $_POST['objet'] !== '')
    {
        $objet = $_POST['objet'];
    }
    else
    {
        $erreurs['objet'] = "objet ne doit pas etre vide";
    }

    if(isset($_POST['message']) && $_POST['message'] !== '')
    {
        $message = $_POST['message'];
    }
    else
    {
        $erreurs['message'] = "message ne doit pas etre vide";
    }

    if (sendMail($nom, $prenom, $email, $objet, $message))
    {
        $validationMailOk = "message envoyé avec succès !"
    }
    else
    {
        $validationMailNotOk = "un probleme est survenu veuillez 
        recommencer votre saisie"
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Contact</title>
</head>
<body>
    <?php

    if(empty(erreurs)){
        if($validationMailOk !==''){
            echo "<div class='valide'>le mail est envoyé</div>";
        }
        
        if($validationMailNotOk !==''){
            echo "<div class='notValide'>l'envoi du mail a echoué !</div>";
        }
    }

    ?>
    <form action="" method="POST">
        <div>
            <?php
                if(isset($erreurs['nom']) && $erreurs['nom'] !=='')
                {
                    echo '<div class="erreur">';
                    echo $erreurs['nom'];
                    echo '</div>';
                }
            ?>
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= $nom ?>" >    
        </div>
        <div>
            <div class="erreur">
                <?php
                    if(isset($erreurs['prenom']) && $erreurs['prenom'] !=='')
                    {
                        echo $erreurs['prenom'];
                    }
                ?>
            </div>    
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= $prenom ?>" >            
        </div>
        <div>
            <?php
                if(isset($erreurs['email']) && $erreurs['email'] !=='')
                {
                    echo '<div class="erreur">';
                    echo $erreurs['email'];
                    echo '</div>';
                }
            ?>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?= $email ?>" >    
        </div>
        <div>
            <div class="erreur">
                <?php
                    if(isset($erreurs['objet']) && $erreurs['objet'] !=='')
                    {
                        echo $erreurs['objet'];
                    }
                ?>
            </div>    
            <label for="objet">Objet</label>
            <input type="text" name="objet" id="objet" value="<?= $objet ?>" >            
        </div>
        <div>
            <div class="erreur">
                <?php
                    if(isset($erreurs['message']) && $erreurs['message'] !=='')
                    {
                        echo $erreurs['message'];
                    }
                ?>
            </div>    
            <label for="message">Message</label>
            <input type="text" name="message" id="message" value="<?= $message ?>" >            
        </div>
        <div class="container_submit">
            <input type="submit" value="Envoyer">
        </div>
    </form>    
</body>
</html>