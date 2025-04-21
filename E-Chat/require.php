<?php


if($bdd=mysqli_connect('localhost','root','','diva')){
    //echo 'Connexion reussie';
}
else{
    echo 'Erreur';
}
mysqli_set_charset($bdd,"utf8");

?>
