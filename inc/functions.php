<?php

function debug($array) {
  echo '<pre>';
  print_r($array);
  echo '</pre>';
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
