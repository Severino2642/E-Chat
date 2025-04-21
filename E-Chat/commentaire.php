<?php
require('require.php');
$pub=$_GET['pub'];
$send=$_GET['id'];
$coms=$_GET['coms'];
$format="INSERT INTO commentaire(id,id_pub,coms,send) VALUES (NULL,'%s','%s','%s')";
$sql=sprintf($format,$pub,$coms,$send);
$res=mysqli_query($bdd,$sql);
header('Location:publication.php');
?>