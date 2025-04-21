<?php

require('require.php');

$time="NOW()";
$idtime="SELECT %s as T";
$sqltime=sprintf($idtime,$time);
$resultatime=mysqli_query($bdd,$sqltime);
$donneestime=mysqli_fetch_assoc($resultatime);
$realtime=$donneestime['T'];

mysqli_set_charset($bdd,"utf8");  
session_start();
$prs=$_SESSION['personne'];
$pub=$_POST['publi'];
$conf=$_POST['affichage'];
$format="INSERT INTO PUBLICATIONS(ID_PUBLICATION,ID_MEMBREP,DTP,PUBLI,AFFTYPE) VALUES (NULL,'%s','%s','%s','%s')";
$sql=sprintf($format,$prs,$realtime,$pub,$conf);
$res=mysqli_query($bdd,$sql);

echo $sql;
header('Location:profil.php');

?>
