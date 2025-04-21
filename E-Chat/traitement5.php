<?php 
require('require.php');
include ('fonction.php');
$pub=$_GET['pub'];
$user=$_GET['user'];
$react=get_registre($pub,$user,$bdd);
if($react==0){
    $format="INSERT INTO enregistrement(id,id_pub,id_user) VALUES (NULL,'%s','%s')";
    $sql=sprintf($format,$pub,$user);
    $resultat=mysqli_query($bdd,$sql);
}
if ($react==1) {
    $format="DELETE FROM enregistrement WHERE id_pub='%s' and id_user='%s'";
    $sql=sprintf($format,$pub,$user);
    $resultat=mysqli_query($bdd,$sql);
}
if ($_GET['nb']==0) {
    header('Location:home.php');
}
if ($_GET['nb']==1) {
    header('Location:info.php');
}
if ($_GET['nb']==2) {
    header('Location:publication.php');
}
?>