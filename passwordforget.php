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

<h1>Mot de passe perdu</h1>

<?php
if ($success == true) {
  echo '<div class = "success">envoi de mail avec la récupération du mot de passe</div>';
} else {

?>

<form action="" method="post">
  <div class="form-group">
    <label for="email">Email</label>
    <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    <input type="text" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?> ">
  </div>

  <input type="submit" name="submitbtn" value="Envoi">
</form>

<?php }

include('incfront/footerfront.php');
