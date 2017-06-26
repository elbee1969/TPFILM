<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>  </title>
    <link rel="stylesheet" href="./assetfront/cssfront/normalize.css">
    <link rel="stylesheet" href="./assetfront/cssfront/bootstrap.css">
    <link rel="stylesheet" href="./assetfront/cssfront/font-awesome.css">
    <link rel="stylesheet" href="./assetfront/cssfront/font-awesome.min.css">
    <link  rel="stylesheet" href="./assetfront/cssfront/stylesfront.css">
    <link  rel="stylesheet" href="./assetfront/cssfront/stylesfrontdetail.css">
    <link  rel="stylesheet" href="./assetfront/cssfront/stylesfrontinscription.css">
    <link  rel="stylesheet" href="./assetfront/cssfront/stylesfrontconnexion.css">
    <link  rel="stylesheet" href="./assetfront/cssfront/stylesfrontlostpassword.css">
  </head>
  <body>

    <header>
      <nav class=" navbar-toggleable-md navbar navbar-inverse bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">ACCUEIL <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">SALUT LES GARS</a>
            </li>
          </ul>
          <span class="navbar-text">
            <?php
            if(isLogged()){ ?>
                <a class="connexinscri" href="deconnexion.php">Bonjour <?php echo $_SESSION['user']['pseudo'] ?>, Déconnexion <i class="fa fa-unlock" aria-hidden="true"> </i> </a>
            <?php }else{
            ?>
              <a class="connexinscri" href="inscription.php">Inscription</a> | <a class="connexinscri con" href="connexion.php">Connexion</i></a>

            <?php } ?>
          </span>
          <form method="GET" action="search.php">
            <div class="form-group ">
              <span class="error"><?php if(!empty($error['search'])) { echo $error['search']; } ?></span>
              <input class="form-control" name="search" type="text" placeholder ="Rechercher un film ..." value="" id="example-text-input">

            </div>
          </form>
        </div>
      </nav>
    </header>
      <body>
        <html>
