<?php
include('inc/pdo.php');
include('inc/functions.php');

$errors = array();
$success = false;

if (!empty($_POST['submitinscription'])) {

  $pseudo     = trim(strip_tags($_POST['pseudo']));
	$email      = trim(strip_tags($_POST['email']));
	$password  = trim(strip_tags($_POST['password']));
	$password1  = trim(strip_tags($_POST['password1']));


 // Gestion des erreurs

 if(empty($pseudo)) {
   $errors['pseudo'] = '<p class="error">Veuillez indiquer un pseudo.</p>';
 }
 elseif(strlen($pseudo) > 30) {
   $errors['pseudo'] = '<p class="error">Votre pseudo est trop long.</p>';
 }
 elseif(strlen($pseudo) < 2) {
   $errors['pseudo'] = '<p class="error">Votre pseudo est trop court.</p>';
 }
 elseif(preg_match('/\d/', $pseudo)) {
   $errors['pseudo'] = '<p class="error">Votre nom ne doit pas contenir de chiffre.</p>';
 }
 // verifier que pseudo est unique
    else {
     $sqlpseudo = "SELECT pseudo FROM users WHERE pseudo = :pseudo";
           $smtp = $pdo->prepare($sqlpseudo);
           $smtp->bindValue(':pseudo',$pseudo);
           $smtp->execute();
           $pseudoexist = $smtp->fetch();
       if($pseudoexist) {
         $errors['pseudo'] = '<p class="error">Ce pseudo existe déjà.</p>';
       }

 }
 if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
     $errors['email'] = '<p class="error">Adresse email invalide.</p>';
   }
   elseif(strlen($email) > 50) {
     $errors['email'] = '<p class="error">Votre adresse e-mail est trop longue.</p>';
   }
   // verifier que email est unique dans la table users
   else {
     $sqlmail = "SELECT email FROM users WHERE email = :email";
             $smtp = $pdo->prepare($sqlmail);
             $smtp->bindValue(':email',$email);
             $smtp->execute();
             $resultmail = $smtp->fetch();

             if($resultmail) {
                $errors['email'] = '<p class="error">Cette adresse e-mail existe déjà.</p>';
             }
   }
   if($password != $password1) {
	      $errors['password'] = '<p class="error">Les mots de passes ne sont pas identiques.</p>';
	    }
	    elseif(strlen($password) <= 5) {
	      $errors['password'] = '<p class="error">Votre mot de passe doit faire plus de 5 caractères.</p>';
	    }
      if(count($errors) == 0) {

   						$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
   						$token = generateRandomString(11);
              $role = 'abonne';


   	    	// creation compte => insert dans BDD
   	    	$inscription = "INSERT INTO users VALUES('',:token,:role,NOW(),:password,:email,:pseudo)";
   	    	$smtp = $pdo->prepare($inscription);
   	    		$smtp->bindValue(':token',$token, PDO::PARAM_STR);
            $smtp->bindValue(':role',$role, PDO::PARAM_STR);
   	    		$smtp->bindValue(':password',$hashedPassword, PDO::PARAM_STR);
   	    		$smtp->bindValue(':email',$email, PDO::PARAM_STR);
   	    		$smtp->bindValue(':pseudo',$pseudo, PDO::PARAM_STR);


   	    	if($smtp->execute()) {
   					$success = true;
   				}

   	    }

}

include('incfront/headerfront.php'); ?>

<div class="header_item form">
<h1>Inscription</h1>




<center>
<?php if ($success == true) {
  echo ' <p><center>Votre inscription est bien prise en compte <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></center></p>'; ?>
  <a class="nav-link" href="index.php">Retour à l'accueil <span class="sr-only">(current)</span></a>
<?php } else { ?>

  <form action="" method="post">

   <div class="form-group">
     <label for="pseudo">Pseudo :</label><br>
     <span class="error"><?php if(!empty($errors['pseudo'])) { echo $errors['pseudo']; } ?></span>
     <input type="text" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>">
   </div>
   <div class="form-group">
    <label for="email">E-mail :</label><br>
    <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    <input type="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
   </div>
   <div class="form-group">
     <label for="password">Mot de passe :</label><br>
     <span class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
     <input type="password" name="password" value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>">
   </div>
   <div class="form-group">
     <label for="password1">Confirmation mot de passe :</label><br>
     <input type="password" name="password1" value="<?php if(!empty($_POST['password1'])) { echo $_POST['password1']; } ?>">
   </div>
    <input type="submit" name="submitinscription" value="Je m'inscris" class="btn btn-lg btn-primary" />
  </form>
</center>
<?php } ?>
</div>

<?php include('incfront/footerfront.php'); ?>
