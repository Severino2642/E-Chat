<?php

session_start();

$_SESSION['mail']=$_POST['mail'];
$_SESSION['mdp']=$_POST['mdp'];
$_SESSION['nbreact_user']=0;
header('Location:home.php');

?>