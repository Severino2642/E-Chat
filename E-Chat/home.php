<?php 
require('require.php');
include ('datareact.php');
include ('fonction.php');
session_start();
$mail=$_SESSION['mail']; 
$mdp=$_SESSION['mdp']; 
$format="SELECT * FROM user WHERE email='%s'AND mdp='%s'";
$sql=sprintf($format,$mail,$mdp);
$resultat=mysqli_query($bdd,$sql);
$donnees=mysqli_fetch_assoc($resultat);
if($donnees['email']==null){
    $_SESSION['phrase']="profil inexistant";
    header('Location:index.php');
}

$_SESSION['personne']=$donnees['id'];
ajout_actif($_SESSION['personne'],1,$bdd);
mysqli_free_result($resultat); 
$user=get_user($_SESSION['personne'],$bdd);
$pub=get_pub($_SESSION['personne'],$bdd);
$amis=get_amis($_SESSION['personne'],$bdd);
$demande=get_demande($_SESSION['personne'],$bdd);
$suggestion=get_suggestion($_SESSION['personne'],$bdd);
$enregistrement=get_enregistrement($_SESSION['personne'],$bdd);
$story=get_story($_SESSION['personne'],$bdd);
if (isset($_GET['num'])) {
 	$_SESSION['num']=$_GET['num'];
 }
if (isset($_GET['partage'])) {
 	$_SESSION['partage']=$_GET['partage'];
 }
if (isset($_GET['story'])) {
 	$_SESSION['story']=$_GET['story'];
 	$_SESSION['again']=$_GET['retour'];
 }
$again=array();
$again[0]="home.php";
$again[1]="texto.php";
unset($_SESSION['info']);
unset($_SESSION['retour']);
unset($_SESSION['retour1']);
unset($_SESSION['pub']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>test</title>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome/css/all.min.css"  />
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css"  />
    <link rel="stylesheet" href="fontawesome/css/regular.css"  />
    <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
<div class="menu">
	<p>
	<i class="fa fa-circle" id="p1" style="font-size: 15px;"></i>
	<i class="fa fa-circle" id="p2" style="font-size: 15px;"></i>
	<i class="fa fa-circle" id="p3" style="font-size: 15px;"></i>
	</p>
	<nav>
		<ul>
			<li><a href="home.php?num=0"><p><i class="fa fa-home"></i> Actualliter</p></a></li>
			<li><a href="home.php?num=1"><p><i class="fa fa-user-friends"></i> Amis</p></a></li>
			<li><a href="texto.php"><p><i class="far fa-comments"></i> Message</p></a></li>
			<li><a href="home.php?num=2"><p><i class="fa fa-edit"></i> S'exprimer</p></a></li>
		</ul>
	</nav>
	<div class="navigation">
		<h2 style="color:white;" >Menu :</h2>
		<a href="home.php?num=3"><p><i class="far fa-bookmark"></i> Enregistrement</p></a>
		
		<details>
			<summary><p><i class="fa fa-cog"></i> Parametre</p></summary>
			<form action="modif.php" method="post" enctype="multipart/form-data">
				<p>Modifier votre nom : <input type="text" name="nom"></p>
				<p>Modifier votre pdp : <input type="file" name="profil"></p>
				<p>Modifier votre photo de couverture : <input type="file" name="couverture"></p>
				<button type="submit">Modifier</button>
			</form>
		</details>
		<a href="delete.php"><p><i class="fa fa-door-open"></i> Se deconnecter</p></a>
	</div>
</div>
<?php if (isset($_SESSION['num']) && $_SESSION['num']==6) { 
$perso=get_user($story[$_SESSION['story']]['send_pub'],$bdd);
if ($perso['id']!=$user['id']) {
	ajout_vues($story[$_SESSION['story']]['id'],$user['id'],0,$bdd);
}
$vues=get_vues($story[$_SESSION['story']]['id'],0,$bdd);
$x=0;
for ($i=0; $i < count($amis); $i++) { 
	if ($perso['id']==$amis[$i]['id']) {
		$x=1;
	}
}
?>
<div class="stories">
	<div class="sto">
		<div style="display: flex;border-top-style: solid;border-color: white;border-width: 2px;padding-top: 10px;">
			<a href="info.php?nb=0&&personne=<?php echo $perso['id'] ?>" style="width: 20%;margin: 0px;padding: 0px;">
			<?php if ($perso['activiter']==1) { ?>
				<i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 2px;margin-top: 48px;margin-left: 48px;"></i>
			<?php } ?>
			<img src="uploads/<?php echo $perso['profil'] ?>" style="height: 55px;width:55px;">
			</a>
			<div style="margin-left: 10px;text-align: left;width: 100%;">
				<h2 style="margin: 0px;font-family: sans-serif;color: white;"><?php echo $perso['nom'] ?></h2>
				<p style="color: white;margin: 5px;"><?php echo $story[$_SESSION['story']]['dtp'] ?></p>
			</div>
			<div style="width: 100%;">
				<a href="<?php echo $again[$_SESSION['again']] ?>?num=0" style="float: right;font-size: 50px;color: white;"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="slide" style="position: absolute;width: 675px;font-size: 25px;margin-top: 145px;">
			<?php if (1<=$_SESSION['story']) { ?>
				<a href="home.php?story=<?php echo($_SESSION['story']-1) ?>&&retour=<?php echo $_SESSION['again'] ?>" style="float: left;color: white;margin: 0px;padding: 20px;"><i class="fa fa-angle-left"></i></a>
			<?php } ?>
			<?php 
				if (isset($_SESSION['nbreact_user'])) {
					$react_temporaire=get_react_perso($story[$_SESSION['story']]['id'],$_SESSION['personne'],$bdd);
					if ($_SESSION['nbreact_user']<count($react_temporaire)) { 
						$_SESSION['nbreact_user']=count($react_temporaire);
			?>
				<?php if ($react_temporaire[count($react_temporaire)-1]['type_react']==0) { ?>
					<i class="fa fa-heart" id="react1" style="margin-left: 2px;background-color: rgb(235,40,40);color: white;padding: 5px;border-radius: 50px;margin-top: 0px;"></i>
				<?php } ?>
				<?php if ($react_temporaire[count($react_temporaire)-1]['type_react']==1) { ?>
					<i class="fa fa-thumbs-up" id="react2" style="margin-left: 2px;background-color: blue;color: white;padding: 5px;border-radius: 100px;margin-top: 0px;"></i>				
				<?php } ?>
				<?php if ($react_temporaire[count($react_temporaire)-1]['type_react']==2) { ?>
					<b id="react3" style="margin-left: 2px;margin: 0px;text-decoration: none;">😂️</b>
				<?php } ?>
			<?php } }?>
			<?php if (count($story)-1>$_SESSION['story']) { ?>
				<a href="home.php?story=<?php echo($_SESSION['story']+1) ?>&&retour=<?php echo $_SESSION['again'] ?>" style="float: right;color: white;margin: 0px;padding: 20px;"><i class="fa fa-angle-right"></i></a>
			<?php } ?>
		</div>
		<h2 class="txt"><?php echo $story[$_SESSION['story']]['pub'] ?></h2>
		<img src="uploads/<?php echo $story[$_SESSION['story']]['file'] ?>">
		<?php if($perso['id']==$user['id']){ ?>
			<details>
				<summary><p class="su"><i class="far fa-eye" style="margin-right: 5px;"></i><?php echo " "; echo count($vues); ?></p></summary>
				<div class="vues">
					<?php for ($i=0; $i < count($vues); $i++) { 
						$react=get_react_perso($story[$_SESSION['story']]['id'],$vues[$i]['id'],$bdd);
					?>		
						<div style="display: flex;">
							<a href="info.php?nb=0&&personne=<?php echo $vues[$i]['id'] ?>">
								<img src="uploads/<?php echo $vues[$i]['profil'] ?>" style="height: 55px;border-radius: 75px;">
							</a>
							<div>
								<p style="margin: 0px;margin-top: 5px;margin-left: 10px;font-weight: bolder;font-size: 20px;"><?php echo($vues[$i]['nom']) ?></p>
								<p style="margin: 0px;max-width:100%;">	
								<?php for ($j=0; $j <count($react) ; $j++) { 
										if ($j<16) {
								?>
									<?php if ($react[$j]['type_react']==0) { ?>
										<i class="fa fa-heart" style="font-size: 20px;margin-left: 2px;background-color: rgb(235,40,40);color: white;padding: 5px;border-radius: 50px;margin-top: 0px;"></i>
									<?php } ?>
									<?php if ($react[$j]['type_react']==1) { ?>
										<i class="fa fa-thumbs-up" style="font-size: 20px;margin-left: 2px;background-color: blue;color: white;padding: 5px;border-radius: 100px;margin-top: 0px;"></i>				
									<?php } ?>
									<?php if ($react[$j]['type_react']==2) { ?>
										<a href="" style="margin-left: 2px;margin: 0px;font-size: 25px;text-decoration: none;">😂️</a>
									<?php } ?>
								<?php } }?>
								</p>
							</div>	
						</div>
					<?php } ?>
				</div>
			</details>
		<?php } ?>
		<?php if($perso['id']!=$user['id'] && $x==1){ ?>
			<form action="message.php" method="get">
				<input type="hidden" name="retour" value="0">
				<input type="hidden" name="send" value="<?php echo $user['id'] ?>">
				<input type="hidden" name="receive" value="<?php echo $perso['id'] ?>">
				<input type="hidden" name="type" value="<?php echo $story[$_SESSION['story']]['id'] ?>">
				<input type="text" name="mp" placeholder="Repondre..." autocomplete="off">
				<button><i class="far fa-paper-plane"></i></button>
				<a href="traitement3.php?nb=0&&pub=<?php echo $story[$_SESSION['story']]['id']; ?>&&user=<?php echo($user['id']) ?>&&type=0&&fonc=0" style="margin-top: 0px;font-size:25px; ">
					<i class="fa fa-heart" style="margin-left: 10px;background-color: rgb(235,40,40);color: white;padding: 5px;padding-top: 8px;padding-left: 8px;padding-right: 8px;border-radius: 50px;margin-top: 0px;"></i>
				</a>
				<a href="traitement3.php?nb=0&&pub=<?php echo $story[$_SESSION['story']]['id']; ?>&&user=<?php echo($user['id']) ?>&&type=1&&fonc=0" style="margin-top: 0px;font-size:25px; ">
					<i class="fa fa-thumbs-up" style="margin-left: 10px;background-color: blue;color: white;padding: 5px;padding-top: 8px;padding-left: 8px;padding-right: 8px;border-radius: 50px;margin-top: 0px;"></i>
				</a>
				<a href="traitement3.php?nb=0&&pub=<?php echo $story[$_SESSION['story']]['id']; ?>&&user=<?php echo($user['id']) ?>&&type=2&&fonc=0" style="margin-top: 0px;font-size:33.5px;text-decoration: none;margin-left: 10px; ">
					😂️
				</a>
			</form>
		<?php }?>

	</div>
</div>
<?php } ?>
<?php if (isset($_SESSION['num']) && $_SESSION['num']==5) { ?>
	<div class="rep1" style="position: fixed;">
		<h1 style="color: rgba(255,255,255,0.8);margin-left: 10px;" >Partager vers :</h1>
		<?php for ($i=0; $i < count($amis) ; $i++) { ?> 
			<div class="r1">
				<a href="info.php?nb=0&&personne=<?php echo $amis[$i]['id'] ?>">
				<img src="uploads/<?php echo $amis[$i]['profil'] ?>" style="height: 50px;border-radius: 75px;width:50px;">
				<h2 style="color: white;margin: 5px;"><?php echo $amis[$i]['nom'] ?></h2>
				</a>
				<div style="width:100%">
					<a href="message.php?retour=0&&send=<?php echo $user['id'] ?>&&receive=<?php echo $amis[$i]['id'] ?>&&type=<?php echo $_SESSION['partage'] ?>" class="retire"><i class="fa fa-share-alt"></i></a>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<?php if (isset($_SESSION['num']) && $_SESSION['num']==1) { ?>
	<div class="rep1" style="position: fixed;">
		<h1 style="color: rgba(255,255,255,0.8);margin-left: 10px;" >Amis (<?php echo count($amis) ?>) : </h1>
		<?php for ($i=0; $i < count($amis) ; $i++) { ?> 
			<div class="r1">
				<a href="info.php?nb=0&&personne=<?php echo $amis[$i]['id'] ?>">
				<img src="uploads/<?php echo $amis[$i]['profil'] ?>" style="height: 50px;border-radius: 75px;width:50px;">
				<h2 style="color: white;margin: 5px;"><?php echo $amis[$i]['nom'] ?></h2>
				</a>
				<div style="width: 100%">
					<a href="retire.php?nb=0&&id=<?php echo $user['id'] ?>&&id1=<?php echo $amis[$i]['id'] ?>" class="retire"><i class="fa fa-user-times"></i></a>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<?php if (isset($_SESSION['num']) && $_SESSION['num']==2) { ?>
	<div class="rep1" style="position: fixed;">
		<div class="r2">
	        <form action="publi.php" method="post" enctype="multipart/form-data">
	        <h2>Que voulez vous dire ?</h2>
	        <textarea name="publi" style="width:95%;height:150px" required></textarea>
	        <p>Importer une image :</p>
	        <input accept="image/*" type="file" name="fichier">
	        <p>Selectionner confidentialiter :
	        <select name="affichage" style="border-radius:20px" required>
	            <option value=""></option>
	            <option value="0">Public</option>
	            <option value="1">Amis</option>
	        </select>
	    	</p>
	    	<p>Type de la publication :
	        <select name="type" style="border-radius:20px" required>
	            <option value=""></option>
	            <option value="0">Publication</option>
	            <option value="1">Story</option>
	        </select>
	    	</p>
	        <div style="display: flex;justify-content: center;">
	        	<button type="submit" style="margin-top: 15px;"><p style="margin: 2px;font-size: 25px;"><i class="far fa-share-square"></i>Publier</p></button> 
	        </div>
	        </form>
    	</div>
	</div>
<?php } ?>
<?php if (isset($_SESSION['num']) && $_SESSION['num']==3) { ?>
	<div class="rep1">
		<h1 style="color: rgba(255,255,255,0.8);margin-left: 10px;" >Vos enregistrement (<?php echo count($enregistrement) ?>) : </h1>
		<?php for ($i=count($enregistrement)-1; $i >=0  ; $i--) { 
			$sendeur=get_user($enregistrement[$i]['send_pub'],$bdd);
		?> 
			<div class="r1">
				<a href="publication.php?nb=0&&pub=<?php echo($enregistrement[$i]['id']) ?>">
				<?php if(isset($enregistrement[$i]['file'])) { ?>
					<img src="uploads/<?php echo $enregistrement[$i]['file'] ?>" style="height: 100px;border-radius: 5px;">
				<?php } ?>
				<div>
					<h2 style="color: white;margin: 10px;"><?php echo $sendeur['nom'] ?></h2>
					<p style="color: rgba(255,255,255,0.8);margin: 5px;"><?php echo $enregistrement[$i]['pub']; ?></p>
				</div>
				</a>
				<div style="width: 300px;">
					<p style="color: rgba(255,255,255,0.8);margin: 5px;float: right;clear: both;">+ <?php echo $enregistrement[$i]['react']; ?> react(s)</p>
					<a  href="traitement5.php?nb=0&&pub=<?php echo $enregistrement[$i]['id']; ?>&&user=<?php echo($user['id']) ?>" class="retire" style="float: right;clear: both;font-size: 35px;padding: 20px;margin-left: 0%;margin-top: 0px;"><i class="fa fa-trash-alt"></i></a>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<?php if (isset($_SESSION['num']) && $_SESSION['num']==4) { ?>
	<div class="rep2">
		<h1 style="color: rgba(255,255,255,0.8);margin-left: 10px;" >Demande d'amis (<?php echo count($demande[0]) ?>) : </h1>
		<?php for ($i=0; $i < count($demande[0]) ; $i++) { ?> 
			<div class="r1">
				<a href="info.php?nb=0&&personne=<?php echo $demande[0][$i]['id'] ?>">
				<img src="uploads/<?php echo $demande[0][$i]['profil'] ?>" style="height: 55px;border-radius: 75px;width:55px;">
				<h2 style="color: white;margin: 5px;"><?php echo $demande[0][$i]['nom'] ?></h2>
				</a>
				<div style="width: 300px;">
					<a href="accepter.php?id=<?php echo($demande[1][$i]) ?>" class="retire1">Accepter</a>
				</div>				
			</div>
		<?php } ?>
		<h2 style="color: rgba(255,255,255,0.8);margin-left: 10px;">Suggestions (<?php echo count($suggestion)?>) :</h2>
		<?php for ($i=0; $i < count($suggestion) ; $i++) { 
			$test=test_demande($user['id'],$suggestion[$i]['id'],$bdd);
		?> 
			<div class="r1">
				<a href="info.php?nb=0&&personne=<?php echo $suggestion[$i]['id'] ?>">
				<img src="uploads/<?php echo $suggestion[$i]['profil'] ?>" style="height: 55px;border-radius: 75px;width:55px;">
				<h2 style="color: white;margin: 5px;"><?php echo $suggestion[$i]['nom'] ?></h2>
				</a>
				<div style="width: 300px">
					<?php if ($test[0]==1) { ?>
					<a href="ajout.php?nb=0&&id=<?php echo $user['id'] ?>&&num=<?php echo($suggestion[$i]['id']) ?>" class="retire1"><i class="fa fa-user-plus"></i>Ajouter</a>						
					<?php } ?>
					<?php if ($test[0]==0) { ?>
					<a href="ajout.php?nb=0&&id=<?php echo $user['id'] ?>&&num=<?php echo($suggestion[$i]['id']) ?>" class="retire1"><i class="fa fa-user-slash"></i>  <?php echo($test[1]) ?></a>						
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<div class="sac">
	<div class="user">
		<a href="info.php?nb=0&&personne=<?php echo $user['id'] ?>" style="display: flex;text-decoration: none;">
		<img src="uploads/<?php echo $user['profil'] ?>">
		<i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 3.5px;"></i>
		<div>
			<h2><?php echo($user['nom']); ?></h2>
			<p><?php echo($user['email']); ?></p>
		</div>
		</a>
		<div style="width: 100%;text-align: right;">
		<a href="home.php?num=4"><i class="fa fa-user-plus" style="font-size: 40px;margin-top: 10px;"></i></a>
		</div>
	</div>
	<div class="story">
		<div class="make_story">
			<a href="home.php?num=2" style="text-decoration: none;text-align: center;">
				<img src="uploads/<?php echo $user['profil'] ?>" style="border:none;height: 150px;border-top-right-radius: 10px;border-top-left-radius: 10px;">
				<i class="fa fa-plus-circle" style="display: block;font-size: 35px;"></i>
				<p style="color: white;font-family: sans-serif;margin: 2px;">Ajouter une story</p>
			</a>
		</div>
		<?php for ($i=0; $i <count($story) ; $i++) { ?>
			<?php 
				$stories=get_user($story[$i]['send_pub'],$bdd);
				$time="UNIX_TIMESTAMP()";
				$idtime="SELECT %s as T";
				$sqltime=sprintf($idtime,$time);
				$resultatime=mysqli_query($bdd,$sqltime);
				$donneestime=mysqli_fetch_assoc($resultatime);
				$realtime=$donneestime['T'];
				if ($realtime>=$story[$i]['expiration']) {
					$format1="DELETE FROM publication WHERE id='%s'";
					$format2="DELETE FROM react WHERE id_pub='%s'";
					$sql1=sprintf($format1,$story[$i]['id']);
					$sql2=sprintf($format2,$story[$i]['id']);
					$resultat=mysqli_query($bdd,$sql1);
					$resultat=mysqli_query($bdd,$sql2); 
				}
			?>
			<!--<a href="home.php?num=6&&story=<?php echo $i ?>&&vues=<?php echo $user['id'] ?>&&retour=0"><img class="story_user" src="uploads/<?php echo $stories['profil'] ?>" style="height: 65px;border-radius: 75px;margin-left: 10px;width: 65px;"></a>-->
			
			<div class="mini_sto">
				<a href="home.php?num=6&&story=<?php echo $i ?>&&vues=<?php echo $user['id'] ?>&&retour=0">
				<div style="display: flex;padding-top: 5px;">
					<img src="uploads/<?php echo $stories['profil'] ?>" style="height: 45px;width:45px;border-radius: 100px;position: absolute;z-index: 1;margin: 0px;border-style: solid;border-color: rgb(26, 117, 255);border-width: 5px;">

				</div>
				<h2 class="mini_txt"><?php echo $story[$i]['pub'] ?></h2>
				<img style="margin-top: 25px;" src="uploads/<?php echo $story[$i]['file'] ?>">
				</a>
			</div>


		<?php } ?>
	</div>
	<div class="contenue">
		<?php for ($i=count($pub)-1; $i >=0  ; $i--) { ?>
			<?php if($pub[$i]['type']==0) { ?>
			<div class="pub" id="d<?php echo $pub[$i]['id'] ?>">
				<?php 
				$send=get_user($pub[$i]['send_pub'],$bdd);
				?>
				<div class="send">
					<a 
						<?php if (isset_story($send['id'],$bdd)==0 || $send['id']==$_SESSION['personne']) { ?>
							href="info.php?nb=0&&personne=<?php echo $send['id'] ?>"
						<?php } ?>
						<?php if (isset_story($send['id'],$bdd)==1 && $send['id']!=$_SESSION['personne']) { 
								$story_naz=get_story_perso($send['id'],$bdd);
								$idnaz; 
									for ($m=0; $m < count($story) ; $m++) { 
										if ($story_naz[0]['id']==$story[$m]['id']) { 
										$idnaz=$m;
										break;
										}	
									}

						?>
								href="home.php?num=6&&story=<?php echo $idnaz ?>&&vues=<?php echo $user['id'] ?>&&retour=0"			
						<?php } ?>
					>
						<?php if ($send['activiter']==1) { ?>
							<i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 2px;margin-top: 60px;margin-left: 58px;z-index: 0;"></i>
						<?php } ?>
						<img src="uploads/<?php echo $send['profil'] ?>"
						<?php if ($send['id']!=$_SESSION['personne']) {?>
							<?php if (isset_story($send['id'],$bdd)==1 && test_vues($story_naz,$_SESSION['personne'],0,$bdd)==0) { ?>
								style="border-style: solid;	border-color: rgb(26, 117, 255);border-width: 5px;"
							<?php }?>
							<?php if (isset_story($send['id'],$bdd)==1 && test_vues($story_naz,$_SESSION['personne'],0,$bdd)==1) { ?>
								style="border-style: solid;	border-color: rgb(60, 60,60);border-width: 5px;"
							<?php }?>
						<?php } ?>
						>
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
						<p style="color:rgba(255,255,255,0.8);margin:5px;font-size: 20px;padding-left: 10px;font-family: sans-serif;">+ <?php echo $pub[$i]['react']; ?> react(s)</p>
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
								<p style="margin: 0px;margin-top: 5px;margin-left: 10px;font-weight: bolder;font-size: 20px;color: white;"><?php echo($reacteur[$j]['nom']) ?></p>
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
					<?php if (get_react($pub[$i]['id'],$user['id'],$bdd)==0) { ?>
						<a href="traitement3.php?nb=0&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($user['id']) ?>&&type=0">
							<i class="far fa-heart" style="margin-left: 10px;"></i>
						</a>
						<a href="traitement3.php?nb=0&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($user['id']) ?>&&type=2">
							<i class="far fa-grin-tears" style="margin-left: 10px;"></i>
						</a>
					<?php } ?>
					<?php if (get_react($pub[$i]['id'],$user['id'],$bdd)==1) { 
						$react_temp=get_react_perso($pub[$i]['id'],$user['id'],$bdd);
					?>
					<a href="traitement3.php?nb=0&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($user['id']) ?>&&type=0">
						<?php if ($react_temp[0]['type_react']==0) { ?>
							<i class="fa fa-heart" style="margin-left: 10px;color: rgb(235,23,23);"></i>
						<?php } ?>
						<?php if ($react_temp[0]['type_react']==2) { ?>
							😂️
						<?php } ?>
					</a>
					<?php } ?>
					<a href="publication.php?nb=0&&pub=<?php echo($pub[$i]['id']) ?>"><i class="far fa-comment" style="margin-left: 10px;"></i></a>
					<a href="home.php?partage=<?php echo $pub[$i]['id'] ?>&&num=5"><i class="far fa-paper-plane" style="margin-left: 20px;"></i></a>
					<a href="traitement5.php?nb=0&&pub=<?php echo $pub[$i]['id']; ?>&&user=<?php echo($user['id']) ?>">
						<?php if (get_registre($pub[$i]['id'],$user['id'],$bdd)==0) { ?>
							<i class="far fa-bookmark" style="margin-left: 10px;float: right;"></i>
						<?php } ?>
						<?php if (get_registre($pub[$i]['id'],$user['id'],$bdd)==1) { ?>
							<i class="fa fa-bookmark" style="margin-left: 10px;color: rgba(255,255,255,1);float: right;"></i>
						<?php } ?>
					</a>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	</div>
</div>
</body>
</html>