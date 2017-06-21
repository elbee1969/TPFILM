<?php
  include('inc/functions.php');
  include('inc/pdo.php');

//pour test
// $_GET['id'] = 4238;

  if(!empty($_GET['id'])) {
      $id = $_GET['id'];
      //  requete a la BDD
      $sql = "SELECT * FROM movies_full WHERE id = :id";

      $query = $pdo->prepare($sql);
      $query->bindValue(":id", $id, PDO::PARAM_INT);
      $query->execute();
      $movies = $query->fetchAll();

      //pour test
      // debug($movies);

     } else {
       die('l\id n\'est pas reconnu');
     }


include('incfront/headerfront.php');

?>

<h1>Détail du film</h1>

<?php foreach ($movies as $movie) {
  if($movie['id'] == $id) {
    ?>
    <div class="movie">
      <h2><?php echo $movie['title']; ?></h2>
      <?php echo '<div><img src="brief/posters/'. $movie['id'] . '.jpg"' ?> alt=""> </div>
      <div class="titledetail">Année du film:</div> <div> <?php echo $movie['year']; ?></div>
      <div class="titledetail">Catégorie:</div> <div> <?php echo $movie['genres']; ?></div>
      <div class="titledetail">Résumé:</div> <div> <?php echo $movie['plot']; ?></div>
      <div class="titledetail">Réalisateur:</div> <div> <?php echo $movie['directors']; ?></div>
      <div class="titledetail">Acteurs:</div> <div> <?php echo $movie['cast']; ?></div>
      <div class="titledetail">Scénaristes:</div> <div> <?php echo $movie['writers']; ?></div>
      <div class="titledetail">Durée du film:</div> <div> <?php echo $movie['runtime']; ?></div>
      <div class="titledetail">Classification:</div> <div> <?php echo $movie['mpaa']; ?></div>
      <div class="titledetail">Evaluation:</div> <div> <?php echo $movie['rating']; ?></div>
      <div class="titledetail">Popularité:</div> <div> <?php echo $movie['popularity']; ?></div>
    </div> <?php
  }
 }

 include('incfront/footerfront.php');
