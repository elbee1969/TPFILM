<?php
session_start();
include('inc/functions.php');
include('inc/pdo.php');
include('incfront/headerfront.php');


if(!empty($_GET['search'])) {
	// Sécurité => faille XSS
	$search = trim(strip_tags($_GET['search']));
}

$sql = "SELECT * FROM movies_full WHERE title LIKE '%$search%' || directors LIKE '%$search%' || cast LIKE '%$search%' ORDER BY created DESC";
$query = $pdo->prepare($sql);
// $query->BindValue(':id',$id, PDO::PARAM_STR);    STR & INT
$query->execute();
$movies = $query->fetchAll();

?>

<h1><i class="fa fa-search" aria-hidden="true"></i> Résultats de recherche</h1>

<?php

if (count($movies) === 0) {
  echo '<center><p>Aucun résultat <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> ! merci de refaire une recherche</p></center>';

	?>
<div class="container-fluid">
	<div class="row ">
		<div class="col-4">

		</div>
		<div class="col-4 align-self-center">
		<div class="form">
			<form method="GET" action="search.php">
				<div class="form-group ">
					<span class="error"><?php if(!empty($error['search'])) { echo $error['search']; } ?></span>
					<input class="form-control" name="search" type="text" placeholder ="rechercher ..." value="" id="example-text-input">
				</div>
			</form>
		</div>
	<?php	echo '<center><p><a href="index.php">Retour à l\'accueil</a></p></center>'; ?>
	</div>
</div>
</div>
	<?php


}

elseif (count($movies) > 0) {
  echo '<center><p class="yesresult">Nous avons trouvé '.''.count($movies).' résultats !'.'</p></center>';

?>
			<div class="row header_search"> <?php
		  foreach ($movies as $movie) {
		      echo '<div class="col-6 col-xs-6 col-md-3 col-lg-2 col-xl-1 ">';
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
<br>
<?php

}

include('incfront/footerfront.php');








 ?>
