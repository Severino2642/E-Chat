<?php
require('require.php');

session_start();
if (!isset($_GET['nb'])) {
    $time="NOW()";
    $idtime="SELECT %s as T";
    $sqltime=sprintf($idtime,$time);
    $resultatime=mysqli_query($bdd,$sqltime);
    $donneestime=mysqli_fetch_assoc($resultatime);
    $realtime=$donneestime['T'];
    $nom=$_POST['nom'];
    $file=$_FILES['fichier']['name'];
        if (move_uploaded_file($_FILES['fichier']['tmp_name'],"uploads/".$_FILES['fichier']['name'])) {
        }
    $format="INSERT INTO groupe(id,admin,nom,photo,dtc) VALUES (NULL,'%s','%s','%s','%s')";
    $sql=sprintf($format,$_SESSION['personne'],$nom,$file,$realtime);
    $res=mysqli_query($bdd,$sql);
    $format="SELECT * FROM groupe where admin='%s' and dtc='%s'";
    $sql=sprintf($format,$_SESSION['personne'],$realtime);
    $res=mysqli_query($bdd,$sql);
    $groupe=mysqli_fetch_assoc($res);
    $format="INSERT INTO membre_groupe(id,id_groupe,id_membre) VALUES (NULL,'%s','%s')";
    $sql=sprintf($format,$groupe['id'],$groupe['admin']);
    $res=mysqli_query($bdd,$sql);
}
if ($_GET['nb']==1) {
    $format="INSERT INTO membre_groupe(id,id_groupe,id_membre) VALUES (NULL,'%s','%s')";
    $sql=sprintf($format,$_GET['gp'],$_GET['id']);
    $res=mysqli_query($bdd,$sql);
}
if ($_GET['nb']==2) {
    $format="DELETE FROM membre_groupe where id_membre='%s' and id_groupe='%s'";
    $sql=sprintf($format,$_GET['perso'],$_GET['gp']);
    $res=mysqli_query($bdd,$sql);
}
if ($_GET['nb']==3) {
    $format="DELETE FROM membre_groupe where id_membre='%s' and id_groupe='%s'";
    $sql=sprintf($format,$_GET['perso'],$_GET['gp']);
    $res=mysqli_query($bdd,$sql);
    unset($_SESSION['num1']);
}
header('Location:texto.php');

?>
