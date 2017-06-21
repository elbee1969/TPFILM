<?php
include('inc/pdo.php');
include('inc/functions.php');

$errors = array();

if (!empty($_POST['submitinscription'])) {

  $pseudo     = trim(strip_tags($_POST['pseudo']));
	$email      = trim(strip_tags($_POST['email']));
	$password  = trim(strip_tags($_POST['password']));
	$password1  = trim(strip_tags($_POST['password1']));


 // Gestion des erreurs

 if(empty($pseudo)) {
   $errors['pseudo'] = 'Veuillez indiquer un pseudo.';
 }
 elseif(strlen($pseudo) > 30) {
   $errors['pseudo'] = 'Votre pseudo est trop long.';
 }
 elseif(strlen($pseudo) < 2) {
   $errors['pseudo'] = 'Votre pseudo est trop court.';
 }
 elseif(preg_match('/\d/', $pseudo)) {
   $errors['pseudo'] = 'Votre nom ne doit pas contenir de chiffre.';
 }
 // verifier que pseudo est unique
    else {
     $sqlpseudo = "SELECT pseudo FROM users WHERE pseudo = :pseudo";
           $smtp = $pdo->prepare($sqlpseudo);
           $smtp->bindValue(':pseudo',$pseudo);
           $smtp->execute();
           $pseudoexist = $smtp->fetch();
       if($pseudoexist) {
         $errors['pseudo'] = 'Ce pseudo existe déjà.';
       }

 }



}

include('incfront/headerfront.php'); ?>

<h1>Inscription</h1>

<form action="" method="post">

 <div class="form-group">
   <label for="pseudo">Pseudo:</label>
   <span class="error"><?php if(!empty($errors['pseudo'])) { echo $errors['pseudo']; } ?></span>
   <input type="text" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>">
 </div>
 <div class="form-group">
  <label for="email">E-mail:</label>
  <input type="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
 </div>
 <div class="form-group">
   <label for="password">Password:</label>
   <input type="text" name="password" value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>">
 </div>
 <div class="form-group">
   <label for="password1">Confirm password:</label>
   <input type="text" name="password1" value="<?php if(!empty($_POST['password1'])) { echo $_POST['password1']; } ?>">
 </div>
  <input type="submit" name="submitinscription" value="Je m'inscris" class="btn btn-default" />
</form>


<?php include('incfront/footerfront.php'); ?>
