<?php
require('require.php');  
session_start();
$nom=$_POST['nom'];
$mail=$_POST['mail'];
$dtn=$_POST['dtn'];
$mdp=$_POST['mdp'];
$mdp1=$_POST['mdp1'];
$genre=$_POST['genre'];
$profil="null.png";
$couverture="null.jpg";
if ($mdp1!=$mdp) {
	$_SESSION['phrase']="Le mot de passe ne correspondent pas";
}
$verif="SELECT * FROM user WHERE email='%s'";
$sqlverif=sprintf($verif,$mail);
$resultatverif=mysqli_query($bdd,$sqlverif);
$donneesverif=mysqli_fetch_assoc($resultatverif);
if($donneesverif['id']!=null){
    $_SESSION['phrase']="Adresse Email deja utiliser";
    header('Location:index.php');
}
if ($mdp1==$mdp && $donneesverif['id']==null) {
	if ($_FILES['profil']['name']!='' || $_FILES['couverture']!='') {
		if ($_FILES['profil']['name']!='') {
			$profil=$_FILES['profil']['name'];
			if (move_uploaded_file($_FILES['profil']['tmp_name'],"uploads/".$_FILES['profil']['name'])) {
				}
		}
		if ($_FILES['couverture']['name']!='') {
			$couverture=$_FILES['couverture']['name'];
			if (move_uploaded_file($_FILES['couverture']['tmp_name'],"uploads/".$_FILES['couverture']['name'])) {
				}
		}
	}

	$_SESSION['phrase']="Vous etes desormais inscrit !!";
	$format="INSERT INTO user(id,nom,dtn,email,mdp,profil,couverture,genre,activiter) VALUES ( NULL,'%s','%s','%s','%s','%s','%s','%s',0)";
	$sql=sprintf($format,$nom,$dtn,$mail,$mdp,$profil,$couverture,$genre);
	$res=mysqli_query($bdd,$sql);	
}
header('Location:index.php');
?>