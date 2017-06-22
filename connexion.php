<?php
session_start();
include('inc/pdo.php');
include('inc/functions.php');

include('inc/session.php');
$errors = array();
$success = false;

if (!empty($_POST['submitconnexion'])) {

  $pseudo = trim(strip_tags($_POST['pseudo']));
  $password = trim(strip_tags($_POST['password']));


  if(empty($pseudo)) {
	    $errors['pseudo'] = 'Veuillez indiquer un pseudo.';
	}
	if(empty($password)) {
	    $errors['password'] = 'Veuillez indiquer un password.';
	}

  if(count($errors) == 0) {

  // verifier si utilisateur existe et si mot de passe correspond.
  $sqluser = "SELECT * FROM users WHERE pseudo = :pseudo OR email = :pseudo";
        $smtp = $pdo->prepare($sqluser);
        $smtp->bindValue(':pseudo',$pseudo);
        $smtp->execute();
        $user = $smtp->fetch();

        if (!$user) {

          $errors['pseudo'] = 'Pseudo or email invalide';
        } else {
          // echo "succés";


          if (password_verify($password,$user['password'])) {
            $success = true;

            // si la case souviens toi de moi est cocher
            if (!empty($_POST['remember'])) {
              // création d'un cookie
              setcookie('usercook', $user['id']. '---' . sha1($user['pseudo'].$user['password'].$_SERVER['REMOTE_ADDR']), time() + 3600 * 24 * 5, '/');

            }

            $_SESSION['user'] = array(
              'id'     => $user['id'],
              'pseudo' => $user['pseudo'],
              'role'   => $user['role'],
              'ip'     => $_SERVER['REMOTE_ADDR'],
            );

          } else {
            $errors['password'] = 'Password invalide';
          }
        }

}
}






include('incfront/headerfront.php'); ?>

<h1>Connexion</h1>

<?php if ($success == true) {
  echo '<div class="success">Connecté</div>' ; ?>
  <a class="nav-link" href="index.php">ACCUEIL <span class="sr-only">(current)</span></a>
<?php } else { ?>
<form action="connexion.php" method="post">

  <div class="form-group">
    <label for="pseudo">Pseudo ou E-mail</label>
    <span class="error"><?php if(!empty($errors['pseudo'])) { echo $errors['pseudo']; } ?></span>
    <input type="text" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>">
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <span class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
    <input type="text" name="password" value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>">
  </div>

  <input type="checkbox" name="remember"> Se souvenir de moi
  <br>
  <input type="submit" name="submitconnexion" value="connexion">
</form>
<a href="passwordforget.php">Mot de passe perdu</a>

<?php }

  include('incfront/footerfront.php');
