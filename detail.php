<?php
session_start();
  include('inc/functions.php');
  include('inc/pdo.php');

//pour test
// $_GET['id'] = 4238;

  if(!empty($_GET['slug'])) {
      $slug = $_GET['slug'];
      //  requete a la BDD
      $sql = "SELECT * FROM movies_full WHERE slug = :slug";

      $query = $pdo->prepare($sql);
      $query->bindValue(":slug", $slug, PDO::PARAM_STR);
      $query->execute();
      $movies = $query->fetchAll();

      //pour test
      // debug($movies);
      // die();
     } else {
       die('le slug n\'est pas reconnu');
     }
     $sessionId = $_SESSION['user']['id'];
     $movieId = $movies['0']['id'];
     if (isset($_POST['note'])){
     $note = $_POST['note'];
      }
     $sql ="SELECT * FROM note AS n LEFT JOIN users as u ON n.user_id = u.id";
     $query = $pdo->prepare($sql);
     $query->execute();
     $userNote = $query->fetch();

     if (!empty($_POST['btnsubmit'])){
       //echo 'coucou';
       if(!empty($_POST['note']) && is_numeric($_POST['note']) && $_POST['note'] >= 0 && $_POST['note'] <=100){
         $sql= "INSERT INTO note (user_id, movie_id, note, created_at)
         VALUES ($sessionId, $movieId, $note, now())
         ";
         $query = $pdo->prepare($sql);
         $query->execute();

       }else {
         echo 'entrer une note entre 0 et 100';
       }
     }


include('incfront/headerfront.php');

?>
<div class="header_item_detail">

  <h1><i class="fa fa-film" aria-hidden="true"></i> Détails du film</h1>
<div class="row rowdetails">
  <div class="col-3">

<?php foreach ($movies as $movie) {
  if($movie['slug'] == $slug) {
    ?>
      <h2><center><?php echo $movie['title']; ?></center></h2>
<?php
      if (file_exists('brief/posters/'.$movie['id'].'.jpg')) {
        echo '<div><center><img class="imgdetail" src="brief/posters/'.$movie['id'].'.jpg" alt="'.$movie['title'].'">'; ?> </center> </div> <?php
      } else {
        echo '<div><center><img class="imgdetail" src="brief/posters/noimage.jpg" alt="'.$movie['title'].'">'; ?> </center> </div> <?php
      }
?>

 </div>

<div class="col-6"><br><br>
      <span class="titledetail centredetail">Année du film:</span><span> <?php echo $movie['year']; ?></span>
<br><br>
      <span class="titledetail">Catégorie:</span> <span> <?php echo $movie['genres']; ?></span>
      <br><br>
      <span class="titledetail">Résumé:</span> <span> <?php echo $movie['plot']; ?></span>
      <br><br>
      <span class="titledetail">Réalisateur:</span> <span> <?php echo $movie['directors']; ?></span>
      <br><br>
      <span class="titledetail">Acteurs:</span> <span> <?php echo $movie['cast']; ?></span>
      <br><br>
      <span class="titledetail">Scénaristes:</span> <span> <?php echo $movie['writers']; ?></span>
      <br><br>
      <span class="titledetail">Durée du film:</span> <span> <?php echo $movie['runtime']; ?></span>
      <br><br>
      <span class="titledetail">Classification:</span> <span> <?php echo $movie['mpaa']; ?></span>
      <br><br>
      <span class="titledetail">Evaluation:</span> <span> <?php echo $movie['rating']; ?></span>
      <br><br>
      <span class="lastdetail titledetail">Popularité:</span> <span> <?php echo $movie['popularity']; ?></span>
 </div>

<div class="col-3">
<?php
if (isLogged()){
  if (isset($userNote) && $userNote != 0){
    echo 'note ';
    debug($userNote);
  }else {
 ?>
  <h2><center>Notez ce film</center></h2>
  <form class="" action="" method="post">
    <input type="text" name="note" value="<?php if (!empty($_POST['note'])){
      echo $_POST['note'];} ?>">
    <input type="submit" name="btnsubmit" value="Noter">
  </form>

  <?php
  }
} else {
   ?>
   <h2><center>Vous devez être connecté pour noter ce film</center></h2>
   <?php } ?>

</div>



 <br><br><br></div></div> <?php

  }
 }
 include('incfront/footerfront.php');
