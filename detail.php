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
<?php
      if (file_exists('brief/posters/'.$movie['id'].'.jpg')) {
        echo '<div><center><img class="imgdetail" src="brief/posters/'.$movie['id'].'.jpg" alt="'.$movie['title'].'">'; ?> </center> </div> <?php
      } else {
        echo '<div><center><img class="imgdetail" src="brief/posters/noimage.jpg" alt="'.$movie['title'].'">'; ?> </center> </div> <?php
      }
?>

 </div>

<div class="col-9">
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
      <span class="titledetail">Popularité:</span> <span> <?php echo $movie['popularity']; ?></span>
 </div></div></div><?php
  }
 }

 include('incfront/footerfront.php');
