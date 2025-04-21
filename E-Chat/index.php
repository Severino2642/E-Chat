<?php 
session_start();
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
    <link rel="stylesheet" type="text/css" href="index.css">

</head>
<body>
<div class="sac">
	<div class="login">
		<div class="form2">
			<div style="text-align: center;" class="b1">
				<div class="title" style="padding-left: 5px;">
					<img src="image/logo2.png" height="90px">
					<h1><samp>G</samp><samp style="text-decoration: overline;font-size: 25px;">looChat</samp></h1>
				</div>
				<h1 style="margin: 0px;text-align: center;margin-top:20px;color: grey;font-style: oblique;font-size: 45px; ">Bienvenue sur Gloochat</h1>
				<button id="connecter" >Se connecter</button>
			</div>
			<div class="form1">

				<div id="n1">
					<div class="title" style="padding-left: 5px;">
						<img src="image/logo2.png" height="90px">
						<h1><samp>G</samp><samp style="text-decoration: overline;font-size: 25px;">looChat</samp></h1>
					</div>
					<h1 style="text-align: center;font-size: 60px;" >Connecter avec votre compte</h1>
					<?php if (isset($_SESSION['phrase'])) { ?>
					<p><i class="fa fa-exclamation-triangle" style="color: red;"></i> <?php echo $_SESSION['phrase'];?> <i class="fa fa-exclamation-triangle" style="color: red;"></i></p>
					<?php } session_destroy(); ?>
					<form action="traitement.php" method="post" style="margin-top: 15px;">
						<p><input type="email" name="mail" required="" placeholder="Adresse email"></p>
						<p><input type="password" name="mdp" required="" placeholder="Mot de passe"></p>
						<button type="submit">connecter</button>
						<br>
						<br>
					</form>
					<br>
					<div style="display: flex;justify-content: center;">
						<h2>________________________</h2>
						<h2 style="margin-top: 1%;margin-right: 5px;margin-left: 5px;">ou</h2>
						<h2>________________________</h2>
					</div>
					<br>
					<a href="#n3">Mot de passe oublier ?</a>
				</div>
				<div id="n3">
					<div class="title" style="padding-left: 5px;">
						<img src="image/logo2.png" height="90px">
						<h1><samp>G</samp><samp style="text-decoration: overline;font-size: 25px;">looChat</samp></h1>
					</div>
					<h1 style="text-align: center;font-size: 60px;" >Formuler votre demande</h1>
					<form action="traitement2.php" method="post">
						<p>Adresse email : <input type="email" name="mail" required="" placeholder=".......@gmail.com"></p>
						<p>Mot de passe :</p>
						<p>
							<input type="password" name="mdp" required="" placeholder="Nouveau mot de passe">
							<input type="password" name="mdp1" required="" placeholder="Retaper votre mot de passe">
						</p>
						<button type="submit">envoyer</button>
						<br>
						<br>
					</form>
					<br>
					<div style="display: flex;justify-content: center;">
						<h2>________________________</h2>
						<h2 style="margin-top: 1%;margin-right: 5px;margin-left: 5px;">ou</h2>
						<h2>________________________</h2>
					</div>
					<br>
					<a href="#n1">Se connecter</a>
				</div>
			</div>
		</div>
		<div class="form3">
			<div style="text-align: center;" class="b2">
				<h1 style="font-size: 50px;max-width: 70%;margin-left: auto;margin-right: auto;color: rgba(250,250,250);">VOUS ÊTES NOUVEAU 🤔️ ?</h1>
				<h2 style="max-width: 80%;margin-left: auto;margin-right: auto;">Inscrivez vous sur GlooChat pour discuter avec vos amis</h2>
				<button id="inscription" >S'inscrire</button>
			</div>
			<div id="n2">
				<h1 style="text-align: center;font-size: 60px;color: rgba(250,250,250,0.8);margin-bottom: 35px;" >Inscriver vous sur GlooChat</h1>
				<form action="inserer.php" method="post" enctype="multipart/form-data">
					<p style="text-align: center;">Nom :<input type="text" name="nom" required="" style="width: 70%;"></p>
					<p>Genre : <select name="genre" >
						<option value="Homme">Homme</option>
						<option value="Femme">Femme</option>
						<option value="Non identifier">Non identifier</option>
					</select>
					</p>
					<p>Date de naissance :<input type="date" name="dtn" required=""></p>
					<p >Adresse email : <input type="email" name="mail" required="" placeholder=".......@gmail.com"  style="width: 62%;"></p>
					<p>Mot de passe :</p>
					<p>
						<input type="password" name="mdp" required="" placeholder="Entrer votre mot de passe">
						<input type="password" name="mdp1" required="" placeholder="Retaper votre mot de passe">
					</p>
					<p>Ajoutez une Photo de profil et Photo de couverture </p>
					<p>
						<label style="margin-right: 25px;color: white;">
							<input accept="image/*" type="file" name="profil" style="display: none;">
							<i class="fa fa-image" style="font-size: 50px;"></i>
						</label>
						<label style="color: white;">
							<input accept="image/*" type="file" name="couverture" style="display: none;">
							<i class="fa fa-image"  style="font-size: 50px;"></i>
						</label>
					</p>
					<button type="submit">Inscrire</button>
				</form>
			</div>
		</div>	
	</div>
</div>
<script src="app.js"></script>
</body>
</html>
					<!--<nav>
						<a href="#n1"><i class="fa fa-globe"></i> Se connecter</a>
						<a href="#n2"><i class="fa fa-envelope-open-text"></i> S'inscrire</a>
					</nav>-->