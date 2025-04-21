<?php
require('require.php');
include ('fonction.php');
session_start();
if (!isset($_SESSION['info'])) {
    $_SESSION['info']=$_GET['personne'];
    $id=$_SESSION['info'];
}
$id=$_SESSION['info'];
if (!isset($_SESSION['retour'])) {
    $_SESSION['retour']=$_GET['nb'];
}
$user=get_user($id,$bdd);
$pub=get_pub_perso($id,$bdd);
$user_amis=get_amis($id,$bdd);
$retour=array();
$retour[0]="home.php";
$retour[1]="texto.php";
$reponse=0;
$test=get_amis($_SESSION['personne'],$bdd);
for ($i=0; $i < count($test); $i++) { 
    if ($test[$i]['id']==$user['id']) {
        $reponse=1;
    }
}
unset($_SESSION['retour1']);
unset($_SESSION['pub']);
$test=test_demande($_SESSION['personne'],$user['id'],$bdd);
?>
<!DOCTYPE html>
<html>
<head>
    <title>INFO_USER</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome/css/all.min.css"  />
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css"  />
    <link rel="stylesheet" href="fontawesome/css/regular.css"  />
    <link rel="stylesheet" type="text/css" href="info.css">
</head>
<body>
<div class="sac">
    <div class="user" style="width: 100%;">
        <img class="photo_profil" src="uploads/<?php echo $user['profil'] ?>">
        <div>
            <h1 style="font-family: sans-serif;margin: 5px;font-weight: bold;font-size: 50px;"><?php echo $user['nom'] ?>
                <i class="fa fa-check-circle" style="color: blue;font-size: 20px;margin-bottom: 10px;"></i> 
            </h1>

        </div>
        <?php if($user['id']!=$_SESSION['personne']) {?>
            <?php if ($reponse==0) { ?>
                <?php if ($test[0]==1) { ?>
                <a href="ajout.php?nb=1&&num=<?php echo $user['id'] ?>&&id=<?php echo $_SESSION['personne']?>"><i class="fa fa-user-plus"> Ajouter</i></a>        
                <?php } ?>
                <?php if ($test[0]==0) { ?>
                <a href="ajout.php?nb=1&&num=<?php echo $user['id'] ?>&&id=<?php echo $_SESSION['personne']?>" style="background-color: rgb(30,30,30);color: rgba(255,255,255,0.5);"><i class="fa fa-user-slash"> <?php echo $test[1]; ?></i></a>        
                <?php } ?>
            <?php } ?>
            <?php if ($reponse==1) { ?>
                <a href="retire.php?nb=1&&id1=<?php echo $user['id'] ?>&&id=<?php echo $_SESSION['personne'] ?>"  style="background-color: rgb(30,30,30);color: rgba(255,255,255,0.5);"><i class="fa fa-user-check"> Amis</i></a>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="contenue">
        <nav>
            <a href="" style="  background-color: grey;"><i class="fa fa-book"></i> Publication</a>
        </nav>
    <div class="c1">
        <?php for ($i=count($pub)-1; $i >=0  ; $i--) { ?>
            <?php if($pub[$i]['type']==0) { ?>
                <div class="pub" id="d<?php echo $pub[$i]['id'] ?>">
                    <?php 
                    $send=get_user($pub[$i]['send_pub'],$bdd);
                    ?>
                    <div class="send">
                        <a href="info.php?nb=1&&personne=<?php echo $send['id'] ?>">
                            <?php if ($send['activiter']==1) { ?>
                                <i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 2px;margin-top: 58px;margin-left: 58px;"></i>
                            <?php } ?>
                            <img src="uploads/<?php echo $send['profil'] ?>">
                        <div>
                            <h2><?php echo $send['nom'] ?></h2>
                            <p><i class="fa fa-clock"></i> <?php echo($pub[$i]['dtp']); ?>
                                <?php if ($pub[$i]['confidualiter']==0) { ?>
                                    <i class="fa fa-globe-americas" style="margin-left: 10px;"></i>
                                <?php } ?>
                                <?php if ($pub[$i]['confidualiter']==1) { ?>
                                    <i class="fa fa-users" style="margin-left: 10px;"></i>
                                <?php } ?>
                            </p>
                        </div>
                        </a>
                    </div>
                    <p class="legend"><?php echo $pub[$i]['pub']; ?></p>
                    <?php if($pub[$i]['file']!='') {?>
                    <div class="file">
                        <img src="uploads/<?php echo $pub[$i]['file']; ?>" style="height: 400px;">
                    </div>
                    <?php } ?>
                    <details style="padding-bottom: 10px;">
                        <summary style="display: flex;">
                            <p style="color:rgba(0,0,0,0.8);margin:2px;font-size: 20px;padding-left: 10px;font-family: sans-serif;">+ <?php echo $pub[$i]['react']; ?> react(s)</p>
                        </summary>
                        <?php 
                        $reacteur=get_pub_reacteur($pub[$i]['id'],$bdd);
                        for ($j=0; $j < count($reacteur); $j++) { 
                            $reaction=get_react_perso($pub[$i]['id'],$reacteur[$j]['id'],$bdd);
                        ?>
                            <div style="display: flex;padding-left:10px;font-family: sans-serif;">
                                <a href="info.php?nb=0&&personne=<?php echo $reacteur[$j]['id'] ?>">
                                    <img src="uploads/<?php echo $reacteur[$j]['profil'] ?>" style="height: 45px;width: 45px;border-radius: 75px;">
                                </a>
                                <div>
                                    <p style="margin: 0px;margin-top: 5px;margin-left: 10px;font-weight: bolder;font-size: 20px;"><?php echo($reacteur[$j]['nom']) ?></p>
                                </div>  
                                    <p style="margin: 5px;font-size: 20px;">    
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
                        <?php } ?>
                    </details>
                    <div class="react">
                        <?php if (get_react($pub[$i]['id'],$_SESSION['personne'],$bdd)==0) { ?>
                            <a href="traitement3.php?nb=1&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>&&type=0">
                                <i class="far fa-heart" style="margin-left: 10px;"></i>
                            </a>
                            <a href="traitement3.php?nb=1&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>&&type=2">
                                <i class="far fa-grin-tears" style="margin-left: 10px;"></i>
                            </a>
                        <?php } ?>
                        <?php if (get_react($pub[$i]['id'],$_SESSION['personne'],$bdd)==1) { 
                                $react_temp=get_react_perso($pub[$i]['id'],$_SESSION['personne'],$bdd);
                            ?>
                            <a href="traitement3.php?nb=1&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>&&type=0">
                                <?php if ($react_temp[0]['type_react']==0) { ?>
                                    <i class="fa fa-heart" style="margin-left: 10px;color: rgb(235,23,23);"></i>
                                <?php } ?>
                                <?php if ($react_temp[0]['type_react']==2) { ?>
                                    😂️
                                <?php } ?>
                            </a>
                        <?php } ?>
                        <a href="publication.php?nb=1&&pub=<?php echo($pub[$i]['id']) ?>"><i class="far fa-comment" style="margin-left: 10px;"></i></a>
                        <a href="traitement5.php?nb=1&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($_SESSION['personne']) ?>">
                            <?php if (get_registre($pub[$i]['id'],$_SESSION['personne'],$bdd)==0) { ?>
                                <i class="far fa-bookmark" style="margin-left: 10px;float: right;"></i>
                            <?php } ?>
                            <?php if (get_registre($pub[$i]['id'],$_SESSION['personne'],$bdd)==1) { ?>
                                <i class="fa fa-bookmark" style="margin-left: 10px;float: right;"></i>
                            <?php } ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="mini_pub">
        <?php for ($i=count($pub)-1; $i >=0 ; $i--) { ?>
            <div class="p1">
                <?php if ($pub[$i]['file']!="") { ?>    
                <img src="uploads/<?php echo $pub[$i]['file'] ?>">
                <?php } ?>
                <div style="width: 100%;">
                    <h2 style="margin-top: 0px;">
                        <?php for ($k=0; $k < strlen($pub[$i]['pub']); $k++){ 
                                if ($k<20) {
                                    echo $pub[$i]['pub'][$k];
                                }
                            }
                            if (strlen($pub[$i]['pub'])>20) { 
                                    echo".....";
                             } 
                        ?>        
                    </h2>
                    <p><?php echo $pub[$i]['dtp'] ?></p>
                </div>
                <div style="width: 100%;">
                    <p style="margin-top: 0px;float: right;">+ <?php echo $pub[$i]['react'] ?> react(s)</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>
<div class="photo_couverture" style="background-image: url(uploads/<?php echo $user['couverture'] ?>);">
    <a href="<?php echo $retour[$_SESSION['retour']]; ?>" style="float: right;font-size: 30px;color: white;padding: 10px;"><i class="fa fa-times-circle"></i></a>
</div>
</body>
</html>