<?php
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

     } else {
       die('le slug n\'est pas reconnu');
     }


include('incfront/headerfront.php');

?>
<div class="header_item">

  <h1>Détail du film</h1>
<div class="row">
  <div class="col-3">




<?php foreach ($movies as $movie) {
  if($movie['slug'] == $slug) {
    ?>

      <h2><center><?php echo $movie['title']; ?></center></h2>
      <?php echo '<div><center><img class="imgdetail" src="brief/posters/'. $movie['id'] . '.jpg"' ?> alt=""></center> </div>

 </div>

<div class="col-9">

      <span class="titledetail">Année du film:</span><span> <?php echo $movie['year']; ?></span>
<br>
      <span class="titledetail">Catégorie:</span> <span> <?php echo $movie['genres']; ?></span>
    <br>  
      <span class="titledetail">Résumé:</span> <div> <?php echo $movie['plot']; ?></div>
      <div class="titledetail">Réalisateur:</div> <div> <?php echo $movie['directors']; ?></div>
      <div class="titledetail">Acteurs:</div> <div> <?php echo $movie['cast']; ?></div>
      <div class="titledetail">Scénaristes:</div> <div> <?php echo $movie['writers']; ?></div>
      <div class="titledetail">Durée du film:</div> <div> <?php echo $movie['runtime']; ?></div>
      <div class="titledetail">Classification:</div> <div> <?php echo $movie['mpaa']; ?></div>
      <div class="titledetail">Evaluation:</div> <div> <?php echo $movie['rating']; ?></div>
      <div class="titledetail">Popularité:</div> <div> <?php echo $movie['popularity']; ?></div>
 </div></div>   </div><?php
  }
 }

 include('incfront/footerfront.php');
