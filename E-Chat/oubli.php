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
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
<div class="sac">
			<div id="form1">
				<nav>
					<a href="index.php">Revenir au page d'acceuille</a>
				</nav>
		</div>
	<div class="login">
		<div id="form3">
			<div id="n2">
				<?php if (isset($_SESSION['phrase'])) { ?>
				<p style="text-align: center;"><?php echo $_SESSION['phrase'];?></p>
				<?php }session_destroy(); ?>
				<form action="traitement2.php" method="post">
					<p>Adresse email : <input type="email" name="mail" required=""></p>
					<p>Mot de passe :</p>
					<p>
						<input type="password" name="mdp" required="" placeholder="Nouveau mot de passe">
						<input type="password" name="mdp1" required="" placeholder="Retaper votre mot de passe">
					</p>
					<button type="submit">valider</button>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>