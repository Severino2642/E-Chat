<?php
require('require.php');
include ('fonction.php');

mysqli_set_charset($bdd,"utf8");  
session_start();
$id=$_GET['id'];
$id1=$_GET['num'];
$accept=0;
$tab=test_demande($id,$id1,$bdd);
if ($tab[0]==1) {
	$format="INSERT INTO amis(id_amis,id_membre1,id_membre2,accept) VALUES (NULL,'%s','%s','%s')";
	$sql=sprintf($format,$id,$id1,$accept);
	$res=mysqli_query($bdd,$sql);
}
else {
	$format="DELETE FROM amis where (id_membre1='%s' and id_membre2='%s') or (id_membre1='%s' and id_membre2='%s')";
	$sql=sprintf($format,$id,$id1,$id1,$id);
	$res=mysqli_query($bdd,$sql);
}
if ($_GET['nb']==0) {
	header('Location:home.php');
}
if ($_GET['nb']==1) {
	session_start();
	$_SESSION['info']=$_GET['num'];
	header('Location:info.php');
}

?>
