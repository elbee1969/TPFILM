<?php

include('inc/pdo.php');
include('inc/functions.php');

$errors = array();
$success = false;

if(!empty($_POST['submitbtn'])) {
  $email = trim(strip_tags($_POST['email']));
  //echo $email;

  if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
	      $errors['email'] = 'Adresse email invalide.';
	    }
	    elseif(strlen($email) > 50) {
	      $errors['email'] = 'Votre adresse e-mail est trop longue.';
	    }

      else{
        $sqlmail = "SELECT pseudo, email, token FROM users WHERE email = :email";
          $smtp = $pdo->prepare($sqlmail);
          $smtp->bindValue(':email',$email);
          $smtp->execute();
          $user = $smtp->fetch();

          //debug($user);

          if(!$user) {
            $errors['email'] = 'Cette adresse mail est invalide';
          } else {

            $success = true;
          }
      }

}

include('incfront/headerfront.php');



?>

<h1> <i class="fa fa-key" aria-hidden="true"></i> Mot de passe perdu</h1><br>

<?php
if ($success == true) {
  echo '<div class = "success">Un email vous a été envoyé avec un lien de récupération ! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>';
} else {

?>

<center><form action="" method="post">
  <div class="form-group">
    <label for="email">Email</label><br>
    <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    <input type="text" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?> ">
  </div>

  <input type="submit" name="submitbtn" value="Envoyer" class="btn btn-lg btn-primary btn-password">
</form></center>

<?php }

include('incfront/footerfront.php');
