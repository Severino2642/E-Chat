<?php
require('require.php');
session_start();
if($_POST['mdp']!=$_POST['mdp1']){
    $_SESSION['phrase']="Mots de passes ne correspondent pas ";
     header('Location:oubli.php');
}

$mail=$_POST['mail'];
$mdp=$_POST['mdp'];

$verif="SELECT * FROM user WHERE email='%s'";
$sqlverif=sprintf($verif,$mail);
$resultatverif=mysqli_query($bdd,$sqlverif);
$donneesverif=mysqli_fetch_assoc($resultatverif);
if($donneesverif['email']==null){
    $_SESSION['phrase']="Email et/ou Date de naissance non existantant";
    header('Location:oubli.php');
}

$format="UPDATE user SET mdp='%s' WHERE email='%s'";
$sql=sprintf($format,$mdp,$mail);
$res=mysqli_query($bdd,$sql);
unset($_SESSION['phrase']);
header('Location:index.php');

?>