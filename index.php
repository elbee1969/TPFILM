<?php
include('inc/pdo.php');
include ('inc/functions.php');
include('incfront/headerfront.php');
?>
<h1><i class="fa fa-film" aria-hidden="true"></i> Bibliothèque</h1>




<?php

// on recupère le nbre d'enreg de la bdd
$sql = "SELECT count(*) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$count = $query->fetchColumn();
//debug($count);
// on récupère le premier id
$sql = "SELECT MIN(id) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$first = $query->fetchColumn();
//debug($first);
//on récupère le dernier id
$sql = "SELECT MAX(id) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$last = $query->fetchColumn();
//debug($last);

//recuperation des dates de production (la première et la dernière)
// on récupère la premiere date
$sql = "SELECT MIN(year) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$firstDate = $query->fetchColumn();
debug($firstDate);
//on récupère la derniere date
$sql = "SELECT MAX(year) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$lastDate = $query->fetchColumn();
debug($lastDate);


// selection des film dans la BDD ici limité a 30 films ....
$sql = "SELECT * FROM movies_full WHERE 1 ORDER BY RAND()  LIMIT 36";
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();
//
?>
<div class="row"> <?php
foreach ($movies as $movie) {
    echo '<div class="col-1">';
    if (file_exists('brief/posters/'.$movie['id'].'.jpg')) {
      echo '<a href="detail.php?slug='.$movie['slug'].'"><img class="image" src="brief/posters/'.$movie['id'].'.jpg" alt="'.$movie['title'].'"></a>';
    } else {
      echo '<a href="detail.php?slug='.$movie['slug'].'"><img class="image" src="brief/posters/noimage.jpg" alt="'.$movie['title'].'"></a>';
    }

    echo '<p>'.$movie['title'].'<p/>';
    echo'</div>';
}

$liste = array(
    'info'        => 'Informations',
    'commande'    => 'Commande',
    'inscription' => 'inscription',
      'act '=> 'Action',
      'av' => 'Adventure',
      'bio' => 'Biography',
      'com' => 'Comedy',
      'cri' => 'Crime',
      'dra' => 'Drama',
      'noir' => 'Film-Noir',
      'fanta' => 'Fantasy',
      'hor' => 'Horror',
      'myst' => 'Mystery',
      'mcal' => 'Musical',
      'mus' => 'Music',
      'rom' => 'Romance',
      'sf' => 'Sci-Fi',
      'spo' => 'Sport',
      'thri' => 'Thriller',
      'war' => 'War',
      'west' => 'Western'
);
?>
<form class="" action="index.php" method="post">

    <label for="genres">Catégorie</label>
    <select class="" name="genres">
      <option value="none">???</option>
      <?php
        foreach ($liste as $key => $value) {?>
        <option value="<?php echo $key; ?>"<?php if(!empty($_POST['genres'])) { if($_POST['genres'] == $key) { echo ' selected="selected"'; } } ?>><?php echo $value; ?></option>
        <?php }?>
    </select>

    <label for="year"></label>
    <select class="" name="year">
      <option value="none">???</option>
<?php

 ?>
    </select>
    <input type="submit" name="btnSubmit" value="Filtrer">
  </form>
</div>

<a href="index.php">Autre film</a>
<?php

include('incfront/footerfront.php');
