<?php
require('require.php');
$id=$_GET['id'];
$accept=4;

$format="UPDATE amis SET accept='%s' WHERE id_amis='%s'";
$sql=sprintf($format,$accept,$id);
$res=mysqli_query($bdd,$sql);
header('Location:home.php');


?>
