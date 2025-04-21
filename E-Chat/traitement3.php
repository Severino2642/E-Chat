<?php 
require('require.php');
include ('fonction.php');
if (isset($_GET['fonc'])) {
    $pub=$_GET['pub'];
    $user=$_GET['user'];
    $format="SELECT * FROM publication where id='%s'";
    $sql=sprintf($format,$pub);
    $resultat=mysqli_query($bdd,$sql);
    $publication=mysqli_fetch_assoc($resultat);
    $type=$_GET['type'];
        $format="INSERT react(id,id_pub,type_react,id_user) VALUES (NULL,'%s','%s','%s')";
        $sql=sprintf($format,$pub,$type,$user);
        $resultat=mysqli_query($bdd,$sql);
header('Location:home.php');
}
if (!isset($_GET['fonc'])) {
    $pub=$_GET['pub'];
    $user=$_GET['user'];
    $react=get_react($pub,$user,$bdd);
    $format="SELECT * FROM publication where id='%s'";
    $sql=sprintf($format,$pub);
    $resultat=mysqli_query($bdd,$sql);
    $publication=mysqli_fetch_assoc($resultat);
    $type=$_GET['type'];
    if($react==0){
        $publication['react']=$publication['react']+1;
        $format="UPDATE publication SET react='%s' WHERE id='%s'";
        $sql=sprintf($format,$publication['react'],$pub);
        $res=mysqli_query($bdd,$sql);
        $format="INSERT react(id,id_pub,type_react,id_user) VALUES (NULL,'%s','%s','%s')";
        $sql=sprintf($format,$pub,$type,$user);
        $resultat=mysqli_query($bdd,$sql);
    }
    if ($react==1) {
        $format="DELETE FROM react WHERE id_pub='%s' and id_user='%s'";
        $sql=sprintf($format,$pub,$user);
        $resultat=mysqli_query($bdd,$sql);
        $publication['react']=$publication['react']-1;
        $format="UPDATE publication SET react='%s' WHERE id='%s'";
        $sql=sprintf($format,$publication['react'],$pub);
        $res=mysqli_query($bdd,$sql);
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
}
?>