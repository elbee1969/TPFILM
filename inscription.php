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
 if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
     $errors['email'] = 'Adresse email invalide.';
   }
   elseif(strlen($email) > 50) {
     $errors['email'] = 'Votre adresse e-mail est trop longue.';
   }
   // verifier que email est unique dans la table users
   else {
     $sqlmail = "SELECT email FROM users WHERE email = :email";
             $smtp = $pdo->prepare($sqlmail);
             $smtp->bindValue(':email',$email);
             $smtp->execute();
             $resultmail = $smtp->fetch();

             if($resultmail) {
                $errors['email'] = 'Cette adresse e-mail existe déjà.';
             }
   }
   if($password != $password1) {
	      $errors['password'] = 'Les mots de passes ne sont pas identiques.';
	    }
	    elseif(strlen($password) <= 5) {
	      $errors['password'] = 'Votre mot de passe doit faire plus de 5 caractères.';
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

<h1>Inscription</h1>

<?php if ($success == true) {
  echo "Votre inscription est bien prise en compte"; ?>
  <a class="nav-link" href="index.php">ACCUEIL <span class="sr-only">(current)</span></a>
<?php } else { ?>

  <form action="" method="post">

   <div class="form-group">
     <label for="pseudo">Pseudo:</label>
     <span class="error"><?php if(!empty($errors['pseudo'])) { echo $errors['pseudo']; } ?></span>
     <input type="text" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>">
   </div>
   <div class="form-group">
    <label for="email">E-mail:</label>
    <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    <input type="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
   </div>
   <div class="form-group">
     <label for="password">Password:</label>
     <span class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
     <input type="password" name="password" value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>">
   </div>
   <div class="form-group">
     <label for="password1">Confirm password:</label>
     <input type="password" name="password1" value="<?php if(!empty($_POST['password1'])) { echo $_POST['password1']; } ?>">
   </div>
    <input type="submit" name="submitinscription" value="Je m'inscris" class="btn btn-default" />
  </form>

<?php } ?>




<?php include('incfront/footerfront.php'); ?>
