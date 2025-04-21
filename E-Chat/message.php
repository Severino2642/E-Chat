<?php
require('require.php');
$send=$_GET['send'];
$receive=$_GET['receive'];
$mp=$_GET['mp'];
$type=0;
$gp=0;
if (isset($_GET['groupe'])) {
	$gp=$_GET['groupe'];
	$receive=0;
}
if (isset($_GET['type'])) {
		$type=$_GET['type'];
	}

if (isset($_POST['send']) && isset($_POST['receive'])) {
	
	$send=$_POST['send'];
	$receive=$_POST['receive'];
	$mp=$_POST['mp'];
	if (isset($_POST['groupe'])) {
		$gp=$_POST['groupe'];
		$receive=0;
	}
	if ($_FILES['fichier']['name']!='') {
		$mp=$_FILES['fichier']['name'];
		$type=-1;
		if (move_uploaded_file($_FILES['fichier']['tmp_name'],"uploads/".$_FILES['fichier']['name'])) {
		}	
	}
}
$format="INSERT INTO texto(id,mp,send,receive,type,groupe) VALUES (NULL,'%s','%s','%s','%s','%s')";
$sql=sprintf($format,$mp,$send,$receive,$type,$gp);
$res=mysqli_query($bdd,$sql);

if (isset($_GET['retour'])) {
	header('Location:home.php');
}
if (!isset($_GET['retour'])) {
	header('Location:texto.php');
}
?>