<?php
require('require.php');
session_start();
$nom=$_POST['nom'];
if ($_FILES['profil']['name']!='') {
	if (move_uploaded_file($_FILES['profil']['tmp_name'],"uploads/".$_FILES['profil']['name'])) {
		$format="UPDATE user SET profil='%s' WHERE id='%s'";
		$sql=sprintf($format,$_FILES['profil']['name'],$_SESSION['personne']);
		$res=mysqli_query($bdd,$sql);
	}
}
if ($_FILES['couverture']['name']!='') {
	if (move_uploaded_file($_FILES['couverture']['tmp_name'],"uploads/".$_FILES['couverture']['name'])) {
		$format="UPDATE user SET couverture='%s' WHERE id='%s'";
		$sql=sprintf($format,$_FILES['couverture']['name'],$_SESSION['personne']);
		$res=mysqli_query($bdd,$sql);			
	}
}
if ($nom!='') {
	$format="UPDATE user SET nom='%s' WHERE id='%s'";
	$sql=sprintf($format,$nom,$_SESSION['personne']);
	$res=mysqli_query($bdd,$sql);	
}
header('Location:home.php');

?>