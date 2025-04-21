<?php 
require('require.php');
include ('datareact.php');
include ('fonction.php');
session_start();
$user=get_user($_SESSION['personne'],$bdd);
$amis=get_amis($_SESSION['personne'],$bdd); 
$groupe=get_groupe($_SESSION['personne'],$bdd); 
if (isset($_GET['id'])) {
	$_SESSION['id']=$_GET['id'];
	unset($_SESSION['num1']);
	$_SESSION['type_texto']=$_GET['type'];
}
$like="`1`1`1";
unset($_SESSION['num']);
unset($_SESSION['partage']);
unset($_SESSION['info']);
unset($_SESSION['retour']);
unset($_SESSION['retour1']);
unset($_SESSION['pub']);
$story=get_story($_SESSION['personne'],$bdd);
if (isset($_GET['send_texto']) && $_GET['send_texto']!='') {
	$vues=get_vues($_GET['send_texto'],1,$bdd);
	if (count($vues)<1) {	
	ajout_vues($_GET['send_texto'],$user['id'],1,$bdd);
	}
}
if (isset($_GET['num'])) {
	$_SESSION['num1']=$_GET['num'];
}
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
    <link rel="stylesheet" type="text/css" href="texto.css">
</head>
<body>
<div class="menu" >
	<div class="user">
		<img src="uploads/<?php echo $user['profil'] ?>">
		<i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 3.5px;"></i>
		<h2>GlooChat</h2>
		<a href="home.php"><i class="fa fa-external-link-alt"></i></a>
	</div>
	<div class="search">
	<form action="traitement2.php" method="get">
		<button type="submit"><i class="fa fa-search" style="font-size: 15px;"></i></button>
		<p><input type="text" name="mot" placeholder="rechercher vos amis"></p>
	</form>	
	</div>
	<details class="cre_gp" >
		<summary style="display: flex;">+<i class="fa fa-users"></i> Creer un groupe</summary>
		<form action="traitement6.php" method="post" enctype="multipart/form-data" >
			<p style="color: white;">Nom : <input type="text" name="nom" required="" placeholder="inserer le nom du groupe"></p>
			<p style="color: white;margin: 5px;">Ajouter une photo : 
				<label style="padding-top: 10px;">
					<input accept="image/*" type="file" name="fichier" required="" style="display: none;">
						<i class="fa fa-image"></i>
				</label>
			</p>
			<button type="submit">Creer</button>
		</form>
	</details>
	<div class="amis">
		<?php for($i=0; $i<count($groupe) ;$i++) { 
			$recent=get_texto($user['id'],$groupe[$i]['id'],-2,$bdd);
			if (count($recent)>0) {
				$send_texto=get_user($recent[count($recent)-1]['send'],$bdd);
			}
		?>
		<a href="texto.php?id=<?php echo $groupe[$i]['id'] ?>&&send_texto=<?php if(count($recent)>0) {echo $recent[count($recent)-1]['id']; }?>&&type=1" style="text-decoration: none;">
			<div class="perso" <?php if (isset($_SESSION['id']) && $_SESSION['id']==$groupe[$i]['id']) { ?>
					style=" background-color: rgb(82, 82, 82);"
				<?php } ?>>
					<img src="uploads/<?php echo $groupe[$i]['photo']?>">
					<div>
						<p style="text-decoration: none;color: white;font-size:18px ;"><?php echo $groupe[$i]['nom'] ?></p>
						<?php
						 if (count($recent)>0) {?>
							<?php if ($user['id']==$recent[count($recent)-1]['send']) { ?>
							<?php if($recent[count($recent)-1]['type']==0) {?>
								<p style="text-decoration: none;color: rgba(255, 255, 255, 0.281);">
									<?php if($recent[count($recent)-1]['mp']!=$like){
										for ($j=0; $j <25; $j++) { 
											if (isset($recent[count($recent)-1]['mp'][$j])) {
												echo $recent[count($recent)-1]['mp'][$j];
											}
										}
									} ?>
									<?php if ($recent[count($recent)-1]['mp']==$like) { ?>
											<i class="fa fa-thumbs-up" style="font-size: 25px;color: lightblue;"></i>
									<?php } ?>
								</p>
							<?php }?>
								<?php if($recent[count($recent)-1]['type']==-1) {?>
									<p style="text-decoration: none;color: rgba(255, 255, 255, 0.281);">vous avez envoyer une photo</p>
								<?php } ?>
								<?php if($recent[count($recent)-1]['type']>0) {
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$recent[count($recent)-1]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
								?>
									<?php if ($pub['type']==0) { ?>	
										<p style="text-decoration: none;color: rgba(255, 255, 255, 0.281);">vous avez partager une publication</p>
									<?php } ?>
								<?php } ?>
						<?php } ?>
						<?php if ($user['id']!=$recent[count($recent)-1]['send']) { 
							$vues=get_vues($recent[count($recent)-1]['id'],1,$bdd);
						?>
							<?php if($recent[count($recent)-1]['type']==0 ){?>
								<p style="text-decoration: none;
											<?php if( count($vues)<1 ) { ?>
											color: rgba(255, 255, 255, 1);
											<?php } ?>
											<?php if( count($vues)>=1 ) { ?>
											color: rgba(255, 255, 255, 0.5);
											<?php } ?>
								">
									<?php if($recent[count($recent)-1]['mp']!=$like){
										for ($j=0; $j <25; $j++) { 
											if (isset($recent[count($recent)-1]['mp'][$j])) {
												echo $recent[count($recent)-1]['mp'][$j];
											}
										}
									} ?>
									<?php if ($recent[count($recent)-1]['mp']==$like) { ?>
											<i class="fa fa-thumbs-up" style="font-size: 25px;color: lightblue;"></i>
									<?php } ?>
								<?php }?>
								<?php if($recent[count($recent)-1]['type']==-1) {?>
									<p style="text-decoration: none;
											<?php if( count($vues)<1 ) { ?>
											color: rgba(255, 255, 255, 1);
											<?php } ?>
											<?php if( count($vues)>=1 ) { ?>
											color: rgba(255, 255, 255, 0.5);
											<?php } ?>
									"><?php echo $send_texto['nom'] ?> a envoyer une photo</p>
								<?php } ?>
								<?php if($recent[count($recent)-1]['type']>0) {
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$recent[count($recent)-1]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
								?>
								<?php if (isset($pub['id'])) { ?>
									
									<?php if ($pub['type']==0) { ?>	
									<p style="text-decoration: none;
											<?php if( count($vues)<1 ) { ?>
											color: rgba(255, 255, 255, 1);
											<?php } ?>
											<?php if( count($vues)>=1 ) { ?>
											color: rgba(255, 255, 255, 0.5);
											<?php } ?>
									"><?php echo $send_texto['nom'] ?> a partager une publication</p>
									<?php } ?>
								<?php } ?>
								<?php } ?>
							</p>
						<?php } ?>
					<?php } ?>
					<?php if (count($recent)==0) { ?>
						<p style="text-decoration: none;color: rgba(255, 255, 255, 1);">Bienvenue a vous deux sur messenger</p>
					<?php }?>
					</div>
						<?php if (count($recent)>0) { ?>
							<?php if ($user['id']!=$recent[count($recent)-1]['send']) { ?>
								<i class="fa fa-check-circle" id="notif"></i>
							<?php } ?>
						<?php }?>
				</div>
			</a>
		<?php }?>

		<?php for($i=0; $i<count($amis) ;$i++) { 
			$recent=get_texto($user['id'],$amis[$i]['id'],0,$bdd);
		?>
		<a href="texto.php?id=<?php echo $amis[$i]['id'] ?>&&send_texto=<?php if(count($recent)>0) {echo $recent[count($recent)-1]['id']; }?>&&type=0" style="text-decoration: none;">
			<div class="perso" <?php if (isset($_SESSION['id']) && $_SESSION['id']==$amis[$i]['id']) { ?>
					style=" background-color: rgb(82, 82, 82);"
				<?php } ?>>
					<?php if ($amis[$i]['activiter']==1) { ?>
						<i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 2px;margin-top: 40px;margin-left: 40px;"></i>
					<?php } ?>
					<img src="uploads/<?php echo $amis[$i]['profil']?>">
					<div>
						<p style="text-decoration: none;color: white;font-size:18px ;"><?php echo $amis[$i]['nom'] ?></p>
						<?php
						 if (count($recent)>0) {?>
							<?php if ($user['id']==$recent[count($recent)-1]['send']) { ?>
							<?php if($recent[count($recent)-1]['type']==0) {?>
								<p style="text-decoration: none;color: rgba(255, 255, 255, 0.281);">
									<?php if($recent[count($recent)-1]['mp']!=$like){
										for ($j=0; $j <25; $j++) { 
											if (isset($recent[count($recent)-1]['mp'][$j])) {
												echo $recent[count($recent)-1]['mp'][$j];
											}
										}
									} ?>
									<?php if ($recent[count($recent)-1]['mp']==$like) { ?>
											<i class="fa fa-thumbs-up" style="font-size: 25px;color: lightblue;"></i>
									<?php } ?>
								</p>
							<?php }?>
								<?php if($recent[count($recent)-1]['type']==-1) {?>
									<p style="text-decoration: none;color: rgba(255, 255, 255, 0.281);">vous avez envoyer une photo</p>
								<?php } ?>
								<?php if($recent[count($recent)-1]['type']>0) {
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$recent[count($recent)-1]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
								?>
									<?php if ($pub['type']==0) { ?>	
										<p style="text-decoration: none;color: rgba(255, 255, 255, 0.281);">vous avez partager une publication</p>
									<?php } ?>
									<?php if ($pub['type']==1) { ?>	
										<p style="text-decoration: none;color: rgba(255, 255, 255, 0.281);">vous avez repondu a la story de <?php echo $amis[$i]['nom'] ?></p>
									<?php } ?>
								<?php } ?>
						<?php } ?>
						<?php if ($user['id']!=$recent[count($recent)-1]['send']) { 
							$vues=get_vues($recent[count($recent)-1]['id'],1,$bdd);
						?>
							<?php if($recent[count($recent)-1]['type']==0 ){?>
								<p style="text-decoration: none;
											<?php if( count($vues)<1 ) { ?>
											color: rgba(255, 255, 255, 1);
											<?php } ?>
											<?php if( count($vues)>=1 ) { ?>
											color: rgba(255, 255, 255, 0.5);
											<?php } ?>
								">
									<?php if($recent[count($recent)-1]['mp']!=$like){
										for ($j=0; $j <25; $j++) { 
											if (isset($recent[count($recent)-1]['mp'][$j])) {
												echo $recent[count($recent)-1]['mp'][$j];
											}
										}
									} ?>
									<?php if ($recent[count($recent)-1]['mp']==$like) { ?>
											<i class="fa fa-thumbs-up" style="font-size: 25px;color: lightblue;"></i>
									<?php } ?>
								<?php }?>
								<?php if($recent[count($recent)-1]['type']==-1) {?>
									<p style="text-decoration: none;
											<?php if( count($vues)<1 ) { ?>
											color: rgba(255, 255, 255, 1);
											<?php } ?>
											<?php if( count($vues)>=1 ) { ?>
											color: rgba(255, 255, 255, 0.5);
											<?php } ?>
									"><?php echo $amis[$i]['nom'] ?> a envoyer une photo</p>
								<?php } ?>
								<?php if($recent[count($recent)-1]['type']>0) {
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$recent[count($recent)-1]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
								?>
								<?php if (isset($pub['id'])) { ?>
									
									<?php if ($pub['type']==0) { ?>	
									<p style="text-decoration: none;
											<?php if( count($vues)<1 ) { ?>
											color: rgba(255, 255, 255, 1);
											<?php } ?>
											<?php if( count($vues)>=1 ) { ?>
											color: rgba(255, 255, 255, 0.5);
											<?php } ?>
									"><?php echo $amis[$i]['nom'] ?> a partager une publication</p>
									<?php } ?>
									<?php if ($pub['type']==1) { ?>	
									<p style="text-decoration: none;color: rgba(255, 255, 255, 1);"><?php echo $amis[$i]['nom'] ?> a repondu a votre story</p>
									<?php } ?>
								<?php } ?>
								<?php } ?>
							</p>
						<?php } ?>
					<?php } ?>
					<?php if (count($recent)==0) { ?>
						<p style="text-decoration: none;color: rgba(255, 255, 255, 1);">Bienvenue a vous deux sur gloochat</p>
					<?php }?>
					</div>
						<?php if (count($recent)>0) { ?>
							<?php if ($user['id']!=$recent[count($recent)-1]['send'] && count($vues)<1) { ?>
								<i class="fa fa-check-circle" id="notif"></i>
							<?php } ?>
						<?php }?>
				</div>
			</a>
		<?php }?>
	</div>
</div>
<div class="texto">
	<?php if (!isset($_SESSION['id'])) {?>
		<div class="none" >
			<p style="padding-top: 200px;" ><i class="fa fa-comments" style="color: lightblue;font-size: 150px;"></i></p>
			<h1>Discuter avec vos amis sur gloochat</h1>
		</div>
	<?php } ?>
	<?php if(isset($_SESSION['id']) && $_SESSION['type_texto']==0) {?>
		<?php
			$texto=get_texto($user['id'],$_SESSION['id'],0,$bdd);
			$user1=get_user($_SESSION['id'],$bdd);
		?>
			<div class="title">
				<a href="info.php?nb=1&&personne=<?php echo $user1['id'] ?>" style="display: flex;text-decoration: none;">
				<?php if ($user1['activiter']==1) { ?>
					<i class="fa fa-circle" style="font-size: 12px;position: absolute;color: green;border-radius: 10px;border-style: solid;border-color: white;border-width: 2px;margin-top: 58px;margin-left: 58px;"></i>
				<?php } ?>
				<img src="uploads/<?php echo($user1['profil']) ?>">
				<h2><?php echo $user1['nom'] ?></h2>
				</a>
			</div>
			<div class="t1">
				<div class="t2">
					<p style="color: rgba(255,255,255,0.6);text-align: center;">Bienvenue a vous deux sur gloochat</p>
					<?php for ($i=0;$i<count($texto);$i++) {?>
						<?php if ($texto[$i]['send']!=$user['id']) { ?>
							<div class="text">
								<img src="uploads/<?php echo($user1['profil']) ?>">
								<?php if ($texto[$i]['type']==0 || $texto[$i]['type']==-2) { ?>
									<?php if($texto[$i]['mp']!=$like){ ?>
									<p style="background-color: rgb(60, 60, 60);color: white;"><?php echo($texto[$i]['mp']); ?></p>
									<?php } ?>
									<?php if ($texto[$i]['mp']==$like) { ?>
										<p><i class="fa fa-thumbs-up" style="font-size: 50px;color: lightblue;"></i></p>
									<?php } ?>
								<?php } ?>

								<?php if ($texto[$i]['type']==-1) { ?>
									<p><img src="uploads/<?php echo($texto[$i]['mp']) ?>" style="height: 250px;border-radius: 5px;max-width: 80%;"></p>
								<?php } ?>
								<?php if ($texto[$i]['type']>0) { 
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$texto[$i]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
									if (isset($pub['id'])) {
										
									$send_pub=get_user($pub['send_pub'],$bdd);
									}
								?>
								<?php if(isset($pub['type'])) { ?>
									<?php if($pub['type']==0 && isset($pub['type'])) { ?>
										<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">
											<div class="link_pub1">
												<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">https://www.diva.com/<?php echo (rand(100000000,989959999))?>/<br>/pub_id<?php echo $pub['id'] ?>///<?php echo (rand(100000000,989959999))?>.gg</a>
												<?php if(isset($pub['file'])) { ?>	
													<img src="uploads/<?php echo $pub['file'] ?>" style="border-radius: 0px;">
												<?php } ?>
												<h2><?php echo $pub['pub'] ?></h2>
												<p style="transform: rotateY(0deg);">... En
												voir plus</p>
												<p style="transform: rotateY(0deg);"><?php echo $send_pub['nom'] ?></p>
											</div>
										</a>
									<?php } ?>
									<?php if($pub['type']==1) {
									$indice; 
										for ($j=0; $j < count($story); $j++) { 
											if ($story[$j]['id']==$pub['id']) {
												$indice=$j;
											}
										}
									?>
										<div class="rep_story">
											<p style="color: white;font-weight: normal;margin: 0px;">Reponse a la story <i class="fa fa-share"></i></p>
											<a href="home.php?num=6&&story=<?php echo $indice ?>&&vues=<?php echo $user['id'] ?>&&retour=1">
											<img src="uploads/<?php echo $pub['file'] ?>" style="margin-left: 10px;transform: rotateY(0deg);">
											</a>
											<p style="background-color: rgb(60, 60, 60);color: white;margin: 0px;"><?php echo($texto[$i]['mp']); ?></p>
										</div>
									<?php } ?>
									<?php } ?>
									<?php if( !isset($pub['type'])) { ?>
										<div style="margin-left: 10px;">
										<p style="color: white;font-weight: normal;margin: 0px;">Reponse a la story <i class="fa fa-share"></i></p>
										<p style="background-color: rgb(60, 60, 60);color: white;margin: 0px;"><?php echo($texto[$i]['mp']); ?></p>
										</div>
									<?php } ?>
								<?php } ?>	
							</div>
						<?php } ?>
								<?php if ($texto[$i]['send']==$user['id']) { ?>
							<div class="text1">
								<?php if ($texto[$i]['type']==0 || $texto[$i]['type']==-2) { ?>
									<?php if($texto[$i]['mp']!=$like){ ?>
									<p style="background-color: rgb(21, 182, 182);color: white;"><?php echo($texto[$i]['mp']); ?></p>
									<?php } ?>
									<?php if ($texto[$i]['mp']==$like) { ?>
										<p><i class="fa fa-thumbs-up" style="font-size: 50px;color: lightblue;"></i></p>
									<?php } ?>
								<?php } ?>

								<?php if ($texto[$i]['type']==-1) { ?>
									<p><img src="uploads/<?php echo($texto[$i]['mp']) ?>" style="height: 250px;border-radius: 5px;max-width: 80%;"></p>
								<?php } ?>
								<?php if ($texto[$i]['type']>0) { 
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$texto[$i]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
									if (isset($pub['id'])) {
										
									$send_pub=get_user($pub['send_pub'],$bdd);
									}
								?>
								<?php if(isset($pub['type'])) { ?>
									<?php if($pub['type']==0 && isset($pub['type'])) { ?>
										<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">
											<div class="link_pub">
												<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">https://www.diva.com/<?php echo (rand(100000000,989959999))?>/<br>/pub_id<?php echo $pub['id'] ?>///<?php echo (rand(100000000,989959999))?>.gg</a>
												<?php if(isset($pub['file'])) { ?>
													<img src="uploads/<?php echo $pub['file'] ?>">
												<?php } ?>
												<h2><?php echo $pub['pub'] ?></h2>
												<p style="transform: rotateY(0deg);">... En voir plus</p>
												<p style="transform: rotateY(0deg);"><?php echo $send_pub['nom'] ?></p>
											</div>
										</a>
									<?php }?>
										<?php if($pub['type']==1) { 
										$indice; 
										for ($j=0; $j < count($story); $j++) { 
											if ($story[$j]['id']==$pub['id']) {
												$indice=$j;
											}
										}
									?>
										<div class="rep_story">
											<p style="color: white;font-weight: normal;">Reponse a la story <i class="fa fa-share"></i></p>
											<a href="home.php?num=6&&story=<?php echo $indice ?>&&vues=<?php echo $user['id'] ?>&&retour=1">
											<img src="uploads/<?php echo $pub['file'] ?>" style="margin-left: 10px;">
											</a>
											<p style="background-color: rgb(21, 182, 182);color: white;"><?php echo($texto[$i]['mp']); ?></p>
										</div>
									<?php } ?>
									<?php } ?>
									<?php if(!isset($pub['type'])) { ?>
										<div style="margin-left: 10px;">
										<p style="color: white;font-weight: normal;">Reponse a la story <i class="fa fa-share"></i></p>
										<p style="background-color: rgb(21, 182, 182);color: white;"><?php echo($texto[$i]['mp']); ?></p>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
							<?php 
								$vues=get_vues($texto[count($texto)-1]['id'],1,$bdd);
								if ($i==count($texto)-1 && count($vues)>=1) { ?>	
								<img src="uploads/<?php echo($user1['profil']) ?>" style="height: 25px;width: 25px;border-radius: 50px;display: block;float: right;margin-right: 55px;margin-top: 5px;">
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		<div class="formulaire">
			<form action="message.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="send" value="<?php echo $user['id'] ?>">
				<input type="hidden" name="receive" value="<?php echo $_SESSION['id'] ?>">
				<label style="padding-top: 10px;">
					<input accept="image/*" type="file" name="fichier" style="display: none;">
						<i class="fa fa-image" style="cursor: pointer;"></i>
				</label>
				<input name="mp" placeholder="Ecrire ici" autocomplete="off">
				<button type="submit" ><i class="far fa-paper-plane"></i></button>
			</form>
			<a href="message.php?send=<?php echo $user['id'] ?>&receive=<?php echo $_SESSION['id'] ?>&mp=<?php echo $like ?>"><i class="fa fa-thumbs-up" style="margin-top: 5px;margin-left: 15px;font-size: 35px;"></i></a>
		</div>
	<?php }?>
	<?php if (isset($_SESSION['num1']) && $_SESSION['num1']==0) { 
	$gp=get_one_groupe($_SESSION['id'],$bdd);
	$tous_membre=get_membre_groupe($_SESSION['id'],$bdd);
	?>
		<div class="rep1">
			<a href="texto.php?num=1" style="color: black;font-size: 30px;text-align: right;margin: 10px;"><i class="fa fa-times-circle"></i></a>
			<div style="text-align: center;padding: 10px;">
				<img src="uploads/<?php echo($gp['photo']) ?>" style="height: 220px;width: 220px;border-radius: 500px;border-color: grey;border-style: solid;border-width: 5px;">
				<h1 style="font-size: 40px;font-weight: bold;margin-top: 5px;" ><?php echo($gp['nom']) ?></h1>
			<p style="font-size: 20px;text-decoration: underline;color:grey; "><samp style="margin-right: 80px;font-weight: bolder;"><i class="fa fa-clock"></i> <?php echo($gp['dtc']) ?></samp> <samp><i class="fa fa-users"></i> <?php echo(count($tous_membre)) ?> membre(s)</samp></p>
			<a href="traitement6.php?perso=<?php echo($_SESSION['personne']) ?>&&gp=<?php echo($gp['id'])?>&&nb=3" style="color: rgb(204, 0, 0);font-size: 25px;text-decoration: none;font-style: oblique;font-weight: bolder;"><i class="fa fa-door-open"></i> Quitter le groupe</a>
			</div>
			<div style="padding: 10px;">
				<details>
					<summary><i class="fa fa-users" style="margin-right: 10px;"></i> Voir les membres du groupe</summary>
					<?php for ($i=0; $i < count($tous_membre) ; $i++) { ?>
						<div class="r1">
							<a href="info.php?nb=1&&personne=<?php echo $tous_membre[$i]['id'] ?>">
							<img src="uploads/<?php echo $tous_membre[$i]['profil'] ?>" style="height: 50px;border-radius: 75px;width:50px;">
							<div>
								<h2 style="color: black;margin: 5px;min-width: 300px;max-width: 600px"><?php echo $tous_membre[$i]['nom'] ?></h2>
								<?php if ($tous_membre[$i]['id']==$gp['admin']) { ?>
								<p style="color: white;margin: 2px;">Administrateur</p>	
								<?php } ?>
								<?php if ($tous_membre[$i]['id']!=$gp['admin']) { ?>
								<p style="color: white;margin: 2px;">Membre</p>	
								<?php } ?>
							</div>
							</a>
							<?php if ($tous_membre[$i]['id']!=$gp['admin'] && $_SESSION['personne']==$gp['admin']) { ?>
								<div style="width:100%">
									<a href="traitement6.php?gp=<?php echo $_SESSION['id'] ?>&&perso=<?php echo $tous_membre[$i]['id'] ?>&&nb=2" class="retire"><i class="fa fa-user-minus"></i></a>
								</div>
							<?php } ?>
						</div> 
					<?php } ?>
				</details>
				<details>
					<summary><i class="fa fa-user-plus" style="margin-right: 10px;"></i> Ajouter des membre</summary>
					<?php for ($i=0; $i < count($amis) ; $i++) { ?>
						<?php if (test_membre_groupe($_SESSION['id'],$amis[$i]['id'],$bdd)==0) { ?>
				
						<div class="r1">
							<a href="info.php?nb=1&&personne=<?php echo $amis[$i]['id'] ?>">
							<img src="uploads/<?php echo $amis[$i]['profil'] ?>" style="height: 50px;border-radius: 75px;width:50px;">
							<h2 style="color: black;margin: 5px;min-width: 200px;max-width: 600px"><?php echo $amis[$i]['nom'] ?></h2>
							</a>
							<div style="width: 100%">
								<a href="traitement6.php?gp=<?php echo $_SESSION['id'] ?>&&id=<?php echo $amis[$i]['id'] ?>&&nb=1" class="retire"><i class="fa fa-user-plus"></i></a>
							</div>
						</div>
						<?php } ?> 
					<?php } ?>
				</details>
			</div>
		</div>
	<?php } ?>
	<?php if(isset($_SESSION['id']) && $_SESSION['type_texto']==1) {?>
		<?php
			$texto=get_texto($user['id'],$_SESSION['id'],-2,$bdd);
			$gp=get_one_groupe($_SESSION['id'],$bdd);
		?>
			<div class="title">
				<img src="uploads/<?php echo($gp['photo']) ?>">
				<h2><?php echo $gp['nom'] ?></h2>
				<div style="width: 100%;">
					<a href="texto.php?num=0" style="color: white;float: right;font-size: 50px;"><i class="fa fa-users-cog"></i></a>
				</div>
			</div>
			<div class="t1">
				<div class="t2">
					<p style="color: rgba(255,255,255,0.6);text-align: center;">Bienvenue a vous tous sur gloochat</p>
					<?php for ($i=0;$i<count($texto);$i++) {
						$user1=get_user($texto[$i]['send'],$bdd);
					?>
						<?php if ($texto[$i]['send']!=$user['id']) { ?>
							<div class="text">
								<img src="uploads/<?php echo($user1['profil']) ?>">
								<?php if ($texto[$i]['type']==0 || $texto[$i]['type']==-2) { ?>
									<?php if($texto[$i]['mp']!=$like){ ?>
									<p style="background-color: rgb(60, 60, 60);color: white;"><?php echo($texto[$i]['mp']); ?></p>
									<?php } ?>
									<?php if ($texto[$i]['mp']==$like) { ?>
										<p><i class="fa fa-thumbs-up" style="font-size: 50px;color: lightblue;"></i></p>
									<?php } ?>
								<?php } ?>

								<?php if ($texto[$i]['type']==-1) { ?>
									<p><img src="uploads/<?php echo($texto[$i]['mp']) ?>" style="height: 250px;border-radius: 5px;max-width: 80%;"></p>
								<?php } ?>
								<?php if ($texto[$i]['type']>0) { 
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$texto[$i]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
									if (isset($pub['id'])) {
										
									$send_pub=get_user($pub['send_pub'],$bdd);
									}
								?>
								<?php if(isset($pub['type'])) { ?>
									<?php if($pub['type']==0 && isset($pub['type'])) { ?>
										<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">
											<div class="link_pub1">
												<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">https://www.diva.com/<?php echo (rand(100000000,989959999))?>/<br>/pub_id<?php echo $pub['id'] ?>///<?php echo (rand(100000000,989959999))?>.gg</a>
												<img src="uploads/<?php echo $pub['file'] ?>" style="border-radius: 0px;">
												<h2><?php echo $pub['pub'] ?></h2>
												<p style="transform: rotateY(0deg);">... En
												voir plus</p>
												<p style="transform: rotateY(0deg);"><?php echo $send_pub['nom'] ?></p>
											</div>
										</a>
									<?php } ?>
									<?php } ?>
								<?php } ?>	
							</div>
						<?php } ?>
								<?php if ($texto[$i]['send']==$user['id']) { ?>
							<div class="text1">
								<?php if ($texto[$i]['type']==0 || $texto[$i]['type']==-2) { ?>
									<?php if($texto[$i]['mp']!=$like){ ?>
									<p style="background-color: rgb(21, 182, 182);color: white;"><?php echo($texto[$i]['mp']); ?></p>
									<?php } ?>
									<?php if ($texto[$i]['mp']==$like) { ?>
										<p><i class="fa fa-thumbs-up" style="font-size: 50px;color: lightblue;"></i></p>
									<?php } ?>
								<?php } ?>

								<?php if ($texto[$i]['type']==-1) { ?>
									<p><img src="uploads/<?php echo($texto[$i]['mp']) ?>" style="height: 250px;border-radius: 5px;max-width: 80%;"></p>
								<?php } ?>
								<?php if ($texto[$i]['type']>0) { 
									$format="SELECT * FROM publication where id='%s'";
									$sql=sprintf($format,$texto[$i]['type']);
									$result=mysqli_query($bdd,$sql);
									$pub=mysqli_fetch_assoc($result);
									if (isset($pub['id'])) {
										
									$send_pub=get_user($pub['send_pub'],$bdd);
									}
								?>
								<?php if(isset($pub['type'])) { ?>
									<?php if($pub['type']==0 && isset($pub['type'])) { ?>
										<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">
											<div class="link_pub">
												<a href="publication.php?nb=2&&pub=<?php echo($pub['id']) ?>">https://www.diva.com/<?php echo (rand(100000000,989959999))?>/<br>/pub_id<?php echo $pub['id'] ?>///<?php echo (rand(100000000,989959999))?>.gg</a>
												<img src="uploads/<?php echo $pub['file'] ?>">
												<h2><?php echo $pub['pub'] ?></h2>
												<p style="transform: rotateY(0deg);">... En voir plus</p>
												<p style="transform: rotateY(0deg);"><?php echo $send_pub['nom'] ?></p>
											</div>
										</a>
									<?php }?>
									<?php } ?>
								<?php } ?>
							</div>
							<?php 
								$vues=get_vues($texto[count($texto)-1]['id'],1,$bdd);
								if ($i==count($texto)-1 && count($vues)>=1) { ?>	
								<img src="uploads/<?php echo($user1['profil']) ?>" style="height: 25px;width: 25px;border-radius: 50px;display: block;float: right;margin-right: 55px;margin-top: 5px;">
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		<div class="formulaire">
			<form action="message.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="send" value="<?php echo $user['id'] ?>">
				<input type="hidden" name="receive" value="0">
				<input type="hidden" name="groupe" value="<?php echo $_SESSION['id'] ?>">
				<label style="padding-top: 10px;">
					<input accept="image/*" type="file" name="fichier" style="display: none;">
						<i class="fa fa-image" style="cursor: pointer;"></i>
				</label>
				<input name="mp" placeholder="Ecrire ici" autocomplete="off">
				<button type="submit" ><i class="far fa-paper-plane"></i></button>
			</form>
			<a href="message.php?send=<?php echo $user['id'] ?>&groupe=<?php echo $_SESSION['id'] ?>&mp=<?php echo $like ?>"><i class="fa fa-thumbs-up" style="margin-top: 5px;margin-left: 15px;font-size: 35px;"></i></a>
		</div>
	<?php }?>
</div>

</body>
</html>