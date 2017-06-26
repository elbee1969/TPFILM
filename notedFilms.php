<?php
session_start();
  include('inc/functions.php');
  include('inc/pdo.php');
  //debug($_SESSION);
  //die();
  $sessionId = $_SESSION['user']['id'];
  $sql = "SELECT * FROM movies_full as a INNER JOIN note as b ON a.id = b.movie_id AND b.user_id = $sessionId ORDER BY b.created_at DESC";
  $query = $pdo->prepare($sql);
  $query->execute();
  $notedFilms = $query->fetchAll();
include('incfront/headerfront.php');
echo '<table style="text-align:center;">';
echo '<th>Titre</th><th> noté le </th><th>Note/100</th>';
foreach ($notedFilms as $notedFilm) {
  echo '<tr>';
  echo '<td style="text-align:justify;">'.$notedFilm['title'].'</td><td>'.$notedFilm['created_at'].'</td><td>'.$notedFilm['note'].'</td>';
  echo '</tr>';
}
echo '</table>';

 include('incfront/footerfront.php');
