<?php
require('require.php');


$time="NOW()";
$idtime="SELECT %s as T";
$sqltime=sprintf($idtime,$time);
$resultatime=mysqli_query($bdd,$sqltime);
$donneestime=mysqli_fetch_assoc($resultatime);
$realtime=$donneestime['T'];
session_start();
unset($_SESSION['num']);
$prs=$_SESSION['personne'];
$pub=$_POST['publi'];
$conf=$_POST['affichage'];
$type=$_POST['type'];
$expiration=0;
if ($type==1) {
    $time1="UNIX_TIMESTAMP()";
    $idtime1="SELECT %s as T";
    $sqltime1=sprintf($idtime1,$time1);
    $resultatime1=mysqli_query($bdd,$sqltime1);
    $donneestime1=mysqli_fetch_assoc($resultatime1);
    $exp=$donneestime1['T'];
    $expiration=$exp+86400;
}
$react=0;
	$file=$_FILES['fichier']['name'];
	if (move_uploaded_file($_FILES['fichier']['tmp_name'],"uploads/".$_FILES['fichier']['name'])) {
	}
$format="INSERT INTO publication(id,dtp,react,send_pub,confidualiter,pub,file,type,expiration) VALUES (NULL,'%s','%s','%s','%s','%s','%s','%s','%s')";
$sql=sprintf($format,$realtime,$react,$prs,$conf,$pub,$file,$type,$expiration);
$res=mysqli_query($bdd,$sql);
header('Location:home.php');

?>
