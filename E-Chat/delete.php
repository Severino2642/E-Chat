<?php
require('require.php'); 
include ('fonction.php');
session_start();
ajout_actif($_SESSION['personne'],0,$bdd);
session_destroy();
header('Location:index.php');

?>