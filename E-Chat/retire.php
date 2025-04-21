<?php
require('require.php');
$id1=$_GET['id'];
$id2=$_GET['id1'];
$accept=4;
$format="DELETE FROM amis where ((id_membre1='%s' and id_membre2='%s') or (id_membre1='%s' and id_membre2='%s')) and accept!=0";
$format1="DELETE FROM texto WHERE (receive='%s' and send='%s') or (receive='%s' and send='%s')";
$sql=sprintf($format,$id1,$id2,$id2,$id1);
$sql1=sprintf($format1,$id1,$id2,$id2,$id1);
$resultat=mysqli_query($bdd,$sql);
$resultat=mysqli_query($bdd,$sql1);
if ($_GET['nb']==0) {
	header('Location:home.php');
}
if ($_GET['nb']==1) {
	session_start();
	$_SESSION['info']=$_GET['id1'];
	header('Location:info.php');
}


?>
