<?php
include('inc/pdo.php');
include ('inc/functions.php');

include('incfront/headerfront.php');
?>
<p>index</p>




<?php

// on recupère le nbre d'enreg de la bdd
$sql = "SELECT count(*) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$count = $query->fetchColumn();
debug($count);
// on récupère le premier id
$sql = "SELECT MIN(id) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$first = $query->fetchColumn();
debug($first);
//on récupère le dernier id
$sql = "SELECT MAX(id) FROM `movies_full` ";
$query = $pdo->prepare($sql);
$query->execute();
$last = $query->fetchColumn();
debug($last);

$sql = "SELECT * FROM movies_full WHERE 1 ORDER BY RAND()  LIMIT 30";
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();

foreach ($movies as $movie) {
    echo '<div class="col">';
    if (file_exists('brief/posters/'.$movie['id'].'.jpg')) {
      echo '<a href="detail.php?id='.$movie['id'].'"><img src="brief/posters/'.$movie['id'].'.jpg" alt="'.$movie['title'].'"></a>';
    } else {
      echo "Il n'y a pas d'affiche.";
    }

    echo '<p>'.$movie['title'].'<p/>';
    echo'</div>';
}
?>
<a href="index.php">Autre film</a>
<?php

include('incfront/footerfront.php');
