<?php

function debug($array) {
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function br()
{
  echo '<br>';
}


function valideInput($post,$name,$min,$max)
{
  $error = '';
  if(!empty($post)) {
    if(strlen($post) > $max) {
      $error = 'le '.$name.' est trop long ('.$max.' caractères max)';
    } elseif (strlen($post) < $min) {
          $error = 'le '.$name.' est trop court ('.$min.' caractères min)';
    }
  } else {
    $error = 'veuillez renseigner un ' . $name ;
  }
  return $error;
}


function verifCountError($error)
{
  foreach ($error as $key => $value) {
    if(!empty($value)) {
      return false;
    }
  }
  return true;
}
//fonction faille XSS
//trim enleve les espaceS et strip_tags supprime les balises HTml
function failleXssB($var){
  trim(strip_tags($var));
  return $var;
}
