<?php
session_start();
include('inc/pdo.php');
include('inc/functions.php');

$errors = array();
if (!empty($_COOKIE['usercook']) && !isset($_SESSION['user'])){
  $success = true;
}else{

  $success = false;
}
include('inc/session.php');

if (!empty($_POST['submitconnexion'])) {

  $pseudo = trim(strip_tags($_POST['pseudo']));
  $password = trim(strip_tags($_POST['password']));


  if(empty($pseudo)) {
	    $errors['pseudo'] = '<br><p class="error">Veuillez indiquer un pseudo.</p>';
	}
	if(empty($password)) {
	    $errors['password'] = '<br><p class="error">Veuillez indiquer un mot de passe.</p>';
	}

  if(count($errors) == 0) {

  // verifier si utilisateur existe et si mot de passe correspond.
  $sqluser = "SELECT * FROM users WHERE pseudo = :pseudo OR email = :pseudo";
        $smtp = $pdo->prepare($sqluser);
        $smtp->bindValue(':pseudo',$pseudo);
        $smtp->execute();
        $user = $smtp->fetch();

        if (!$user) {

          $errors['pseudo'] = '<br><p class="error">Pseudo ou email invalide.</p>';
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

// debug($_COOKIE);
// debug($_SESSION);




include('incfront/headerfront.php'); ?>

<h1><i class="fa fa-user" aria-hidden="true"></i> Connexion</h1>

<?php if ($success == true) {
  echo '<center><div class="success">Vous êtes connecté ! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div></center>' ;

  ?>
  <center><a class="nav-link" href="index.php">Retour à l'accueil <span class="sr-only">(current)</span></a></center>
<?php } else { ?>
<center><form action="connexion.php" method="post">

  <div class="form-group">
    <label for="pseudo">Pseudo ou email</label><br>
    <span class="error"><?php if(!empty($errors['pseudo'])) { echo $errors['pseudo']; } ?></span>
    <input type="text" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>">
  </div>

  <div class="form-group">
    <label for="password">Password</label><br>
    <span class="error"><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>
    <input type="text" name="password" value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>">
  </div>

  <input type="checkbox" name="remember"> Se souvenir de moi
  <br>
  <input type="submit" name="submitconnexion" value="connexion" class="btn btn-lg btn-primary btn-connexion">
</form>
<a href="passwordforget.php"><p class="mdpperdu">Mot de passe perdu</p></a></center>

<?php }

  include('incfront/footerfront.php');
