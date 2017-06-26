<?php include('../inc/pdo.php') ?>
<?php include('../inc/function.php') ?>
<?php
session_start();

session_destroy();
unset($_SESSION);

header('Location: index.php');
