<?php
require('require.php');
include ('fonction.php');
session_start();
if (!isset($_SESSION['pub'])) {
    $_SESSION['pub']=$_GET['pub'];
    $id=$_SESSION['pub'];
}
$id=$_SESSION['pub'];
if (!isset($_SESSION['retour1'])) {
    $_SESSION['retour1']=$_GET['nb'];
}
$format="SELECT * FROM publication where id='%s'";
$sql=sprintf($format,$_SESSION['pub']);
$resultat=mysqli_query($bdd,$sql);
$pub=mysqli_fetch_assoc($resultat);
$coms=get_coms($id,$bdd);
$retour=array();
$retour[0]="home.php";
$retour[1]="info.php";
$retour[2]="texto.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome/css/all.min.css"  />
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css"  />
    <link rel="stylesheet" href="fontawesome/css/regular.css"  />
    <link rel="stylesheet" href="publication.css">
    <title>Document</title>
</head>
<body>
<div class="body" style="height: 750px;overflow-y: auto;">
<a href="<?php echo $retour[$_SESSION['retour1']]; ?>" style="float: right;font-size: 30px;color: black;padding: 10px;"><i class="fa fa-times-circle"></i></a>
<div class="pub" id="d<?php echo $pub['id'] ?>">
        <?php 
        $send=get_user($pub['send_pub'],$bdd);
        ?>
        <div class="send">
            <a href="info.php?nb=1&&personne=<?php echo $send['id'] ?>">
                <?php if ($send['activiter']==1) { ?>
                    <i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 2px;margin-top: 58px;margin-left: 58px;"></i>
                <?php } ?>
                <img src="uploads/<?php echo $send['profil'] ?>">
            <div>
                <h2><?php echo $send['nom'] ?></h2>
                <p><i class="fa fa-clock"></i> <?php echo($pub['dtp']); ?>
                    <?php if ($pub['confidualiter']==0) { ?>
                        <i class="fa fa-globe-americas" style="margin-left: 10px;"></i>
                    <?php } ?>
                    <?php if ($pub['confidualiter']==1) { ?>
                        <i class="fa fa-users" style="margin-left: 10px;"></i>
                    <?php } ?>
                </p>
            </div>
            </a>
        </div>
        <p class="legend"><?php echo $pub['pub']; ?></p>
        <?php if($pub['file']!='') {?>
        <div class="file">
            <img src="uploads/<?php echo $pub['file']; ?>" style="height: 400px;">
        </div>
        <?php } ?>
        <details style="padding-bottom: 10px;">
            <summary style="display: flex;">
                <p style="color:rgba(0,0,0,0.8);margin:2px;font-size: 20px;padding-left: 10px;font-family: sans-serif;">+ <?php echo $pub['react']; ?> react(s)</p>
            </summary>
            <?php 
            $reacteur=get_pub_reacteur($pub['id'],$bdd);
            for ($j=0; $j < count($reacteur); $j++) { 
                $reaction=get_react_perso($pub['id'],$reacteur[$j]['id'],$bdd);
            ?>
                <div style="display: flex;padding-left:10px;font-family: sans-serif;">
                    <a href="info.php?nb=0&&personne=<?php echo $reacteur[$j]['id'] ?>">
                        <img src="uploads/<?php echo $reacteur[$j]['profil'] ?>" style="height: 45px;width: 45px;border-radius: 75px;">
                    </a>
                    <div>
                        <p style="margin: 0px;margin-top: 5px;margin-left: 10px;font-weight: bolder;font-size: 20px;"><?php echo($reacteur[$j]['nom']) ?></p>
                        <p style="margin: 0px;font-size: 20px;">    
                        <?php for ($k=0; $k <count($reaction) ; $k++) { ?>
                            <?php if ($reaction[$k]['type_react']==0) { ?>
                                <i class="fa fa-heart" style="font-size: 15px;margin-left: 2px;background-color: rgb(235,40,40);color: white;padding: 5px;border-radius: 50px;margin-top: 0px;"></i>
                            <?php } ?>
                            <?php if ($reaction[$k]['type_react']==1) { ?>
                                <i class="fa fa-thumbs-up" style="font-size: 15px;margin-left: 2px;background-color: blue;color: white;padding: 5px;border-radius: 100px;margin-top: 0px;"></i>             
                            <?php } ?>
                            <?php if ($reaction[$k]['type_react']==2) { ?>
                                😂️
                            <?php } ?>
                        <?php } ?>
                        </p>
                    </div>  
                </div>
            <?php } ?>
        </details>
        <div class="react">
            <?php if (get_react($pub['id'],$_SESSION['personne'],$bdd)==0) { ?>
                <a href="traitement3.php?nb=2&&pub=<?php echo $pub['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>&&type=0">
                    <i class="far fa-heart" style="margin-left: 10px;"></i>
                </a>
                <a href="traitement3.php?nb=2&&pub=<?php echo $pub['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>&&type=2">
                    <i class="far fa-grin-tears" style="margin-left: 10px;"></i>
                </a>
            <?php } ?>
            <?php if (get_react($pub['id'],$_SESSION['personne'],$bdd)==1) { 
                    $react_temp=get_react_perso($pub['id'],$_SESSION['personne'],$bdd);
                ?>
                <a href="traitement3.php?nb=2&&pub=<?php echo $pub['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>&&type=0">
                    <?php if ($react_temp[0]['type_react']==0) { ?>
                        <i class="fa fa-heart" style="margin-left: 10px;color: rgb(235,23,23);"></i>
                    <?php } ?>
                    <?php if ($react_temp[0]['type_react']==2) { ?>
                        😂️
                    <?php } ?>
                </a>
            <?php } ?>
            <a href=""><i class="far fa-comment" style="margin-left: 10px;"></i></a>
            <a href="traitement5.php?nb=2&&pub=<?php echo $pub['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>">
                <?php if (get_registre($pub['id'],$_SESSION['personne'],$bdd)==0) { ?>
                    <i class="far fa-bookmark" style="margin-left: 10px;float: right;"></i>
                <?php } ?>
                <?php if (get_registre($pub['id'],$_SESSION['personne'],$bdd)==1) { ?>
                    <i class="fa fa-bookmark" style="margin-left: 10px;float: right;"></i>
                <?php } ?>
            </a>
        </div>
        <div class="coms">
            <h2>Commentaire :</h2>
            <?php for ($i=0; $i <count($coms) ; $i++) { 
                $user=get_user($coms[$i]['send'],$bdd);
            ?> 
                <div class="co">
                    <?php if ($user['activiter']==1) { ?>
                        <i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 2px;margin-top: 40px;margin-left: 30px;"></i>
                    <?php } ?>
                    <img src="uploads/<?php echo $user['profil'] ?>" style="width:50px;">
                    <div>
                        <p><?php echo $user['nom'] ?></p>
                        <p style="font-size: 20px;color: rgb(30,30,30);"><?php echo $coms[$i]['coms'] ?></p>
                    </div>
                </div>
            <?php } ?>
            <form action="commentaire.php" method="get">
                <input type="hidden" name="pub" value="<?php echo $id ?>">
                <input type="hidden" name="id" value="<?php echo $_SESSION['personne'] ?>">
                <textarea name="coms" placeholder="Ecrire un commentaire"></textarea>
                <button type="submit"><i class="fa fa-paper-plane"></i></button>
            </form>
        </div>
</div>
</div>
<script type="text/javascript">
    let zone = document.querySelector('.body');
        zone.scrollTop=zone.scrollHeight;
</script>
</body>
</html>