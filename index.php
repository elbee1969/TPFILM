<?php
include('inc/pdo.php');
include ('inc/functions.php');
//gestion du formulaire
$errors = array();
$sucessform = false;
$filtre = array();
$var = '';

//$param ="'genres' LIKE 'action' ";
//SELECT * FROM `movies_full` WHERE `genres` LIKE '%comedy%' AND `genres` LIKE '%action%'

if(!empty($_POST['btnSubmit'])){

  // Faille XSS
  $sql = "SELECT * FROM movies_full WHERE 1 = 1";
  if(!empty($_POST['filtre'])){


        $filtres = $_POST['filtre'];

        $i = 1;
        foreach ($filtres as $filtre) {

          if($i == 1) {
            $sql .= " AND genres LIKE '%".trim($filtre)."%'";
          } else {
            $sql .= " OR genres LIKE '%".trim($filtre)."%'";
          }
          $i++;

        }

  }
if(!empty($_POST['year'])){
  $deb = $_POST['yearS'];
  $fin = $_POST['yearF'];

  if ($fin > $deb){
    $sql .= " AND year BETWEEN '.$deb.' AND '.$fin.'";
  }else{
    $sql .= " AND year = '.$deb.' ";
  }

}

if(!empty($_POST['popularity'])){
  $pop = $_POST['popularity'];
  $sql .= " AND popularity > 80 ";

}

  $sql .= " ORDER BY RAND() LIMIT 10";

  // echo $sql; die();

// selection des film dans la BDD ici limité a 30 films ....
// $param = '';
// $sql = "SELECT * FROM `movies_full` WHERE `genres` LIKE '%comedy%' AND `genres` LIKE '%action%' ORDER BY `genres`  LIMIT 36";
 $query = $pdo->prepare($sql);
 $query->execute();
 $movies = $query->fetchAll();

 //debug($movies);




//die();

}else{

  // selection des film dans la BDD ici limité a 30 films ....
  $sql = "SELECT * FROM movies_full WHERE 1 ORDER BY RAND()  LIMIT 36";
  $query = $pdo->prepare($sql);
  $query->execute();
  $movies = $query->fetchAll();
}


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
//debug($firstDate);
//on récupère la derniere date
$sql = "SELECT MAX(year) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$lastDate = $query->fetchColumn();
//debug($lastDate);
// selection des film dans la BDD par date de creation  ....
$sql = "SELECT * FROM movies_full WHERE 1 ORDER BY year ASC";
$query = $pdo->prepare($sql);
$query->execute();
$dates = $query->fetchAll();
// selection des film par popularité DSC
$sql = "SELECT * FROM movies_full ORDER BY popularity DESC";
$query = $pdo->prepare($sql);
$query->execute();
$popul = $query->fetchAll();
//debug($popul);

//

$liste = array(
'act '  => 'Action',
'av'    => 'Adventure',
'bio'   => 'Biography',
'com'   => 'Comedy',
'cri'   => 'Crime',
'dra'   => 'Drama',
'noir'  => 'Film-Noir',
'fanta' => 'Fantasy',
'hor'   => 'Horror',
'myst'  => 'Mystery',
'mcal'  => 'Musical',
'mus'   => 'Music',
'rom'   => 'Romance',
'sf'    => 'Sci-Fi',
'spo'   => 'Sport',
'thri'  => 'Thriller',
'war'   => 'War',
'west'  => 'Western'
);
include('incfront/headerfront.php');
?>
<div class="header_item">

  <h1><i class="fa fa-film" aria-hidden="true"></i> Bibliothèque</h1>




<?php
$annees1 = $firstDate;
$annees2 = $firstDate;
$years = array();
// echo 'post : ';
// debug($_POST);
// echo 'filtre : ';
// echo $filtre[]['genres'];
?>
<div id="filtre">
<input type="button" name="aff" value="Filtres">
</div>
<div class="hide" id="actionFiltre">

  <form class="" action="index.php" method="post">

    <?php
    foreach ($liste as $value) {?>
      <input type="checkbox" name="filtre[]"  value="<?php echo $value; ?> "><?php echo $value; ?>
      <?php }?>


  <!--creation de la liste d'option pour la date de départ avec retour du selected-->
    <label for="yearS">De </label>
    <select class="" name="yearS">
      <option value="none">???</option>
      <?php
      for($i=$firstDate; $i < $lastDate+1; $i++){
        $years[] = $annees1++;
      }
      foreach ($years as $key => $value) {
        ?>
        <option value="<?php echo $value; ?>"<?php if(!empty($_POST['yearS'])) { if($_POST['yearS'] == $key) { echo ' selected="selected"'; } } ?>><?php echo $value; ?></option>
        <?php }?>
    </select>
<?php

 ?>

 <!--creation de la liste d'option pour la date de fin avec retour du selected-->
  <label for="yearE"> à </label>
  <select class="" name="yearE">
    <option value="none">???</option>
    <?php
    for($i=$firstDate; $i < $lastDate+1; $i++){
      $years[] = $annees2++;
    }
    foreach ($years as $key => $value) {
      ?>
      <option value="<?php echo $value; ?>"<?php if(!empty($_POST['yearE'])) { if($_POST['yearE'] == $value) { echo ' selected="selected"'; } } ?>><?php echo $value; ?></option>
      <?php }?>
  </select>


  <label for="popularity">
    <input type="checkbox" name="popularity" value="popularity">
    Par popularité
  </label>


        <input type="submit" name="btnSubmit" value="Filtrer">
  </form>
</div>
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
  ?>
  </div>
  <center><a class="nodeco" href=""><button type="button" class="btn btn-lg btn-primary">Voir plus de films </button></a></center>
</div>

<?php

include('incfront/footerfront.php');
