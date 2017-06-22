<?php
include('inc/pdo.php');
include ('inc/functions.php');

// requête BDD pour connaitre le nombre de films
$sql = "SELECT COUNT(id) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$nombreDeFilms = $query->fetch();

$nombreDeFilms2 = implode($nombreDeFilms);

//requête BDD pour connaître le nombre d'utilisateurs
$sql = "SELECT COUNT(id) FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$nombreUtil = $query->fetch();

$nombreUtil2 = implode($nombreUtil);

// nombre d'utilisateurs inscrits par semaine depuis les 5 dernières semaines
$today = strtotime('now') * 1000;
$week = 604800000; //une semaine en millisecondes
$aWeekAgo = $today - $week;


$sql = "SELECT created_at FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$created = $query->fetchAll();



include('incback/headerback.php');
?>

<p>Le nombre de films en base de données est de: <?php echo $nombreDeFilms2; ?> </p>

<p>Le nombre d'utilisateurs en base de données est de: <?php echo $nombreUtil2; ?></p>









<?php
include('incback/footerback.php');
