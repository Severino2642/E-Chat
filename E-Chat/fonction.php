<?php

require('require.php'); 
 function get_user($id,$bdd){
 	$format="SELECT * FROM user WHERE id='%s'";
	$sql=sprintf($format,$id);
	$resultat=mysqli_query($bdd,$sql); 
	$donnees=mysqli_fetch_assoc($resultat);
	mysqli_free_result($resultat); 
	return $donnees;
}
function ajout_actif($id,$nb,$bdd)
{
	$format="UPDATE user SET activiter='%s' WHERE id='%s'";
	$sql=sprintf($format,$nb,$id);
	$resultat=mysqli_query($bdd,$sql); 
	return 0; 	
}
function get_texto($id1,$id2,$type,$bdd){
	$sms=array();
	$i=0;
	if ($type!=-2) {
	$format1="SELECT * FROM texto WHERE (receive='%s' and send='%s') or (send='%s' and receive='%s') ORDER BY id ASC";
			$sql1=sprintf($format1,$id1,$id2,$id1,$id2);
			$result=mysqli_query($bdd,$sql1);
			while ($texto=mysqli_fetch_assoc($result)) {
			$sms[$i]=$texto;
			$i++;
		}
	}
	if ($type==-2) {
	$format1="SELECT * FROM texto WHERE groupe='%s' ORDER BY id ASC";
			$sql1=sprintf($format1,$id2);
			$result=mysqli_query($bdd,$sql1);
			while ($texto=mysqli_fetch_assoc($result)) {
					$sms[$i]=$texto;
					$i++;
		}
	}
	mysqli_free_result($result); 
	return $sms;
}
function get_amis($id1,$bdd){
	$amis=array();
	$i=0;
	$format="SELECT * FROM amis";
	$sql=sprintf($format);
	$resultat=mysqli_query($bdd,$sql);
	while ($donnees=mysqli_fetch_assoc($resultat)) { 
		if ($donnees['accept']!=0 && ($donnees['id_membre2']==$id1 || $donnees['id_membre1']==$id1) ) 
			{	 
				if ($donnees['id_membre1']==$id1) {
					$amis[$i]=get_user($donnees['id_membre2'],$bdd);
					$i++;
				}
				if ($donnees['id_membre2']==$id1) {
					$amis[$i]=get_user($donnees['id_membre1'],$bdd);
					$i++;
				}
			}
	}
	mysqli_free_result($resultat); 
	return $amis;  
}
/*function get_amis_texto($id,$bdd)
{
	$amis=get_amis($id,$bdd);
	$texto=array();
	for ($i=0; $i < count($amis); $i++) { 
			$recent=get_texto($id,$amis[$i]['id'],1,$bdd);
			$texto[$i]=$recent;
	}
	$nb=count($texto);
	while ($nb>=0) {
		for ($i=0; $i < count($texto); $i++) { 
			if ($texto[$i][count($texto[$i])-1]['type']!=-3) {
				if ($) {
					# code...
				}
			}
		}
	}
}*/
function get_demande($id,$bdd){
	$membre=array();
	$tab=array();
	$i=0;
	$format="SELECT * FROM amis";
	$sql=sprintf($format);
	$resultat=mysqli_query($bdd,$sql); 
	while ($donnees=mysqli_fetch_assoc($resultat)) { 
		if ($donnees['id_membre2']==$id && $donnees['accept']==0) { 
			$membre[$i]=get_user($donnees['id_membre1'],$bdd);
			$tab[$i]=$donnees['id_amis'];
			$i++;
		}
	}
	$result=array();
	$result[0]=$membre;
	$result[1]=$tab;
	mysqli_free_result($resultat); 
	return $result;
}
function analyseur($id1,$id2,$bdd){
	$format="SELECT * FROM amis where ((id_membre1='%s' and id_membre2='%s') or (id_membre1='%s' and id_membre2='%s')) and accept!=0";
	$sql=sprintf($format,$id1,$id2,$id2,$id1);
	$resultat=mysqli_query($bdd,$sql);
	$donnees=mysqli_fetch_assoc($resultat);
	if (!isset($donnees['id_amis'])) { 
		mysqli_free_result($resultat); 
		return 0;
	}
	mysqli_free_result($resultat); 
	return 1;  
}
function get_suggestion($id,$bdd){
	$membre=array();
	$i=0;
	$format="SELECT * FROM user";
	$sql=sprintf($format);
	$resultat=mysqli_query($bdd,$sql);
	$amis=get_amis($id,$bdd); 
	while ($donnees=mysqli_fetch_assoc($resultat)) {  
			if ($donnees['id']!=$id && analyseur($id,$donnees['id'],$bdd)==0) { 
				$membre[$i]=$donnees;
				$i++;
			}
	}
	mysqli_free_result($resultat); 
	return $membre;
}
function get_pub($id,$bdd)
{
	$pub=array();
	$i=0;
	$format="SELECT * FROM publication ORDER BY id ASC";
	$sql=sprintf($format);
	$resultat=mysqli_query($bdd,$sql);
	while ($donnees=mysqli_fetch_assoc($resultat)) {
		if ($donnees['confidualiter']==0 || $donnees['send_pub']==$id) {
			$pub[$i]=$donnees;
			$i++;
		}
		if ($donnees['confidualiter']==1 && $donnees['send_pub']!=$id) {
			$amis=get_amis($id,$bdd);
			for ($j=0; $j < count($amis); $j++) { 
				if ($donnees['send_pub']==$amis[$j]['id']) {
					$pub[$i]=$donnees;
					$i++;		
				}
			}
		}

	}
	mysqli_free_result($resultat); 
	return $pub;
}
function get_pub_perso($id,$bdd)
{
	$pub=get_pub($id,$bdd);
	$result=array();
	$a=0;
	for ($i=0; $i <count($pub) ; $i++) { 
		if ($pub[$i]['send_pub']==$id) {
			$result[$a]=$pub[$i];
			$a++;
		}
	}
	return $result;
}
function get_story($id,$bdd)
{
	$pub=get_pub($id,$bdd);
	$result=array();
	$a=0;
	for ($i=0; $i <count($pub) ; $i++) { 
		if ($pub[$i]['type']==1) {
			$result[$a]=$pub[$i];
			$a++;
		}
	}
	return $result;
}
function get_story_perso($id,$bdd)
{
	$pub=get_pub($id,$bdd);
	$result=array();
	$a=0;
	for ($i=0; $i <count($pub) ; $i++) { 
		if ($pub[$i]['type']==1 && $pub[$i]['send_pub']==$id) {
			$result[$a]=$pub[$i];
			$a++;
		}
	}
	return $result;
}
function isset_story($id,$bdd)
{
	$pub=get_pub($id,$bdd);
	for ($i=0; $i <count($pub) ; $i++) { 
		if ($pub[$i]['type']==1 && $pub[$i]['send_pub']==$id) {
			return 1;
		}
	}
	return 0;
}
function get_react($pub,$user,$bdd)
{
$format="SELECT * FROM react where id_pub='%s' and id_user='%s'";
$sql=sprintf($format,$pub,$user);
$resultat=mysqli_query($bdd,$sql);
$donnees=mysqli_fetch_assoc($resultat);
if(!isset($donnees['id'])){
    mysqli_free_result($resultat); 
    return 0;
}
mysqli_free_result($resultat); 
return 1;
}
function get_registre($pub,$user,$bdd)
{
$format="SELECT * FROM enregistrement where id_pub='%s' and id_user='%s'";
$sql=sprintf($format,$pub,$user);
$resultat=mysqli_query($bdd,$sql);
$donnees=mysqli_fetch_assoc($resultat);
if(!isset($donnees['id'])){
    mysqli_free_result($resultat); 
    return 0;
}
mysqli_free_result($resultat); 
return 1;
}
function get_enregistrement($user,$bdd){
$format="SELECT * FROM enregistrement where id_user='%s'";	
$sql=sprintf($format,$user);
$resultat=mysqli_query($bdd,$sql);
$pub=array();
$i=0;
while ($donnees=mysqli_fetch_assoc($resultat)) {
	$format1="SELECT * FROM publication where id='%s'";	
	$sql1=sprintf($format1,$donnees['id_pub']);
	$result=mysqli_query($bdd,$sql1);
	$pub[$i]=mysqli_fetch_assoc($result);
	mysqli_free_result($result); 
	$i++;
}
mysqli_free_result($resultat); 
return $pub;
}
function test_demande($id1,$id2,$bdd)
{
$tab=array();
$tab[0]=0;
$format="SELECT * FROM amis where (id_membre1='%s' and id_membre2='%s') or (id_membre1='%s' and id_membre2='%s')";
$sql=sprintf($format,$id1,$id2,$id2,$id1);
$resultat=mysqli_query($bdd,$sql);
$donnees=mysqli_fetch_assoc($resultat);
if(!isset($donnees['id_amis'])){
    $tab[0]=1;
    return $tab;
}
if ($donnees['id_membre1']==$id1) {
	$tab[1]="Annuler";
}
if ($donnees['id_membre1']==$id2) {
	$tab[1]="Rejeter";
}
mysqli_free_result($resultat); 
return $tab;
}
function get_coms($pub,$bdd)
{
$coms=array();
$i=0;
$format="SELECT * FROM commentaire where id_pub='%s' order by id asc";
$sql=sprintf($format,$pub);
$resultat=mysqli_query($bdd,$sql);
while ($donnees=mysqli_fetch_assoc($resultat)) {
	$coms[$i]=$donnees;
	$i++;
}
mysqli_free_result($resultat); 
return $coms;
}
function ajout_vues($story,$user,$type,$bdd)
{
$format="SELECT * FROM vues where id_story='%s' and id_user='%s'";
$sql=sprintf($format,$story,$user);
$resultat=mysqli_query($bdd,$sql);
$donnees=mysqli_fetch_assoc($resultat);
if(!isset($donnees['id'])){
    $format="INSERT vues(id,id_story,id_user,type) VALUES (NULL,'%s','%s','%s')";
    $sql=sprintf($format,$story,$user,$type);
    $resultat=mysqli_query($bdd,$sql); 
} 
return 0;
}
function test_vues_1($story,$user,$type,$bdd)
{
$format="SELECT * FROM vues where id_story='%s' and id_user='%s' and type='%s'";
$sql=sprintf($format,$story,$user,$type);
$resultat=mysqli_query($bdd,$sql);
$donnees=mysqli_fetch_assoc($resultat);
mysqli_free_result($resultat);
if(isset($donnees['id'])){
    return 1;  
} 
return 0;
}
function test_vues($story,$user,$type,$bdd)
{
	 for ($i=0; $i < count($story); $i++) { 
	 	$result=test_vues_1($story[$i]['id'],$user,$type,$bdd);
	 	if ($result==0) {
	 		return 0;
	 	}
	 }
return 1;
}
function get_vues($story,$type,$bdd)
{
$vues=array();
$i=0;
$format="SELECT * FROM vues where id_story='%s' and type='%s'";
$sql=sprintf($format,$story,$type);
$resultat=mysqli_query($bdd,$sql);
while ($donnees=mysqli_fetch_assoc($resultat))
{
	$vues[$i]=get_user($donnees['id_user'],$bdd);
	$i++;
}
mysqli_free_result($resultat); 
return $vues;
}
function get_react_perso($pub,$user,$bdd)
{
$result=array();
$i=0;
$format="SELECT * FROM react where id_pub='%s' and id_user='%s' order by id asc";
$sql=sprintf($format,$pub,$user);
$resultat=mysqli_query($bdd,$sql);
while ($donnees=mysqli_fetch_assoc($resultat)){
	$result[$i]=$donnees;
	$i++;
}
mysqli_free_result($resultat); 
return $result;
}
function get_pub_reacteur($pub,$bdd)
{
$result=array();
$i=0;
$format="SELECT * FROM react where id_pub='%s'";
$sql=sprintf($format,$pub);
$resultat=mysqli_query($bdd,$sql);
while ($donnees=mysqli_fetch_assoc($resultat)){
	$result[$i]=get_user($donnees['id_user'],$bdd);
	$i++;
}
mysqli_free_result($resultat); 
return $result;
}
function get_groupe($user,$bdd)
{
$result=array();
$i=0;
$format="SELECT * FROM membre_groupe where id_membre='%s'";
$sql=sprintf($format,$user);
$resultat=mysqli_query($bdd,$sql);
while ($donnees=mysqli_fetch_assoc($resultat)){
	$format1="SELECT * FROM groupe where id='%s'";
	$sql1=sprintf($format1,$donnees['id_groupe']);
	$resultat1=mysqli_query($bdd,$sql1);
	$groupe=mysqli_fetch_assoc($resultat1);
	$result[$i]=$groupe;
	mysqli_free_result($resultat1); 
	$i++;
}
mysqli_free_result($resultat); 
return $result;
}
function get_one_groupe($id,$bdd)
{
$format="SELECT * FROM groupe where id='%s'";
$sql=sprintf($format,$id);
$resultat=mysqli_query($bdd,$sql);
$donnees=mysqli_fetch_assoc($resultat);
mysqli_free_result($resultat); 
return $donnees;
}
function get_membre_groupe($id,$bdd)
{
$result=array();
$i=0;
$format="SELECT * FROM membre_groupe where id_groupe='%s'";
$sql=sprintf($format,$id);
$resultat=mysqli_query($bdd,$sql);
while ($donnees=mysqli_fetch_assoc($resultat)){
	$result[$i]=get_user($donnees['id_membre'],$bdd);
	$i++;
}
mysqli_free_result($resultat); 
return $result;
}
function test_membre_groupe($id,$id2,$bdd)
{
$format="SELECT * FROM membre_groupe where id_groupe='%s'";
$sql=sprintf($format,$id);
$resultat=mysqli_query($bdd,$sql);
while ($donnees=mysqli_fetch_assoc($resultat)){
	if ($donnees['id_membre']==$id2) {
		mysqli_free_result($resultat); 
		return 1;
	}
}
mysqli_free_result($resultat); 
return 0;
}







//POKER MULTI

$carte[0]['nom']="2";
$carte[0]['valeur']=2;
$carte[0]['hauteur']=1;
 
$carte[1]['nom']="3";
$carte[1]['valeur']=3;
$carte[1]['hauteur']=2;

$carte[2]['nom']="4";
$carte[2]['valeur']=4;
$carte[2]['hauteur']=3;

$carte[3]['nom']="5";
$carte[3]['valeur']=5;
$carte[3]['hauteur']=4;

$carte[4]['nom']="6";
$carte[4]['valeur']=6;
$carte[4]['hauteur']=5;

$carte[5]['nom']="7";
$carte[5]['valeur']=7;
$carte[5]['hauteur']=6;

$carte[6]['nom']="8";
$carte[6]['valeur']=8;
$carte[6]['hauteur']=7;

$carte[7]['nom']="9";
$carte[7]['valeur']=9;
$carte[7]['hauteur']=8;

$carte[8]['nom']="10";
$carte[8]['valeur']=10;
$carte[8]['hauteur']=9;

$carte[9]['nom']="J";
$carte[9]['valeur']=10;
$carte[9]['hauteur']=10;

$carte[10]['nom']="Q";
$carte[10]['valeur']=10;
$carte[10]['hauteur']=11;

$carte[11]['nom']="K";
$carte[11]['valeur']=10;
$carte[11]['hauteur']=12;

$carte[12]['nom']="A";
$carte[12]['valeur']=11;
$carte[12]['hauteur']=13;

$couleur[0]['nom']="carreau";
$couleur[0]['hauteur']=2;
$couleur[1]['nom']="treffle";
$couleur[1]['hauteur']=1;
$couleur[2]['nom']="coueur";
$couleur[2]['hauteur']=3;
$couleur[3]['nom']="pique";
$couleur[3]['hauteur']=4;

function cartes($carte,$couleur)
{
	$result[]=array('nom' => "",
					'couleur' =>"",
					'valeur' =>"",
					'hauteur' =>"",
	 );
	$j=0;
	$a=0;
	while ($a<4) {
		for ($i=0; $i <13 ; $i++) {
			$result[$j]['nom']=$carte[$i]['nom'];
			$result[$j]['valeur']=$carte[$i]['valeur']; 
			$result[$j]['hauteur']=$carte[$i]['hauteur']; 
			$result[$j]['couleur']=$couleur[$a];
			$j++;
		}
		$a++;
	}
	return $result;
}

function killer($id,$carte){
$carte[$id]['valeur']=0;
return $carte;
}

function generateur($nbcarte,$carte,$couleur,$nbjoueur){
$limite=0;
$i=0;
$result=array();
	while ($limite<$nbjoueur) {
		while ($i<$nbcarte) {
			$indice=rand(0,51);
			if ($carte[$indice]['valeur']!=0) {
				$result[$limite][$i]=$carte[$indice];
				$carte=killer($indice,$carte);
				$i++;
			}
		}
		$i=0;
		$limite++;
	}
	return $result;
}
function comparateur($tab)
{
	$result;
	$a=0;
	$nb=-20;
	for ($i=0; $i <count($tab) ; $i++) { 
		if ($nb==$tab[$i]) {
			$result=-1;
		}
		if ($nb<$tab[$i]) {
			$result=$i;
			$nb=$tab[$i];
		}
	}
	return $result;
}
function maxi($tab)
{
	$a=0;
	$nb=0;
	for ($i=0; $i <count($tab) ; $i++) {
		if ($nb<$tab[$i]) {
			$nb=$tab[$i];
		}
	}
	return $nb;
}
function somme($carte){
$somme1=0;
$nbcarte=count($carte);
for ($i=0; $i <$nbcarte ; $i++) { 
	$somme1=$somme1+$carte[$i]['valeur'];
}
$result=$somme1;
return $result;
}

function hauteur($j)
{
	$nb=-1;
	$limite=0;
	$result;
	$a=0;
	$nbcarte=count($j);
		for ($i=0; $i <$nbcarte ; $i++) {
			if ($nb<$j[$i]['hauteur']) {
				$nb=$j[$i]['hauteur'];
			}	
		}
	$result=$nb;
	return $result;
}

function couleur($j,$couleur){
$nb=-1;
$tab[0]=0;
$a=0;
$nbcarte=count($j);
	for ($i=0; $i <count($couleur) ; $i++) {

		for ($k=0; $k <$nbcarte ; $k++) { 
			if ($j[$k]['couleur']==$couleur[$i]) {
			$tab[$a]=$tab[$a]+1;
			}
		}
		$a++;
		$tab[$a]=0;
	}
	for ($i=0; $i <count($tab) ; $i++) {
		if ($nb<$tab[$i]) {
			$nb=$tab[$i];
		}	
	}
	$result=$nb;
	return $result;
}

function couleur_hauteur($j,$nbjoueur,$couleur){
$player=array();
	for ($i=0; $i < $nbjoueur; $i++) { 
		$player[$i]=couleur($j[$i],$couleur);
	}
$winner[0]=comparateur($player);
$winner[1]=1;
	if ($winner[0]==-1) {
		for ($i=0; $i < $nbjoueur; $i++) { 
			$player[$i]=hauteur($j[$i]);
		}
		$winner2[0]=comparateur($player);
		$winner2[1]=2;
		return $winner2;
	}
	return $winner;
}
function arrange($karatra){
$carte=$karatra;
$result=$karatra;
$i=0;
$indice=array();
	while ($i<count($karatra)) {
		$hauteur=hauteur($carte);
		for ($j=0; $j <count($karatra) ; $j++) {
		if ($hauteur==$carte[$j]['hauteur']) {
			$indice[$i]=$j;
			$carte[$j]['hauteur']=-1;
			$i++;
			break;
		}
		}
	}
	for ($i=0; $i <count($karatra) ; $i++) { 
		$result[$i]=$karatra[$indice[$i]];
	}
return $result;
}

function quinte_flush($j){
$nb=0;
$carte=arrange($j);
$nbcarte=count($j);
	if ($carte[0]['hauteur']==13 && $carte[1]['hauteur']==4 && $carte[2]['hauteur']==3 && $carte[3]['hauteur']==2 && $carte[4]['hauteur']==1 ) {
		$nb=$nbcarte-1;
		return $nb;	
	}
	for ($i=1; $i <$nbcarte ; $i++) {
		$hauteur=$carte[$nb]['hauteur']-1; 
		if ($carte[$i]['hauteur']==$hauteur) {
			$nb=$nb+1;
		}
	}
	return $nb;	
}

function carre($j,$carte){
$nb=-1;
$tab=array();
$a=0;
$nbcarte=count($j);
$result=array();
	for ($i=0; $i <count($carte) ; $i++) {
		$tab[$a][0]=0;
		for ($k=0; $k <$nbcarte ; $k++) { 
			if ($j[$k]['nom']==$carte[$i]['nom']) {
			$tab[$a][0]=$tab[$a][0]+1;
			$tab[$a][1]=$carte[$i]['hauteur'];
			}
		}
		$a++;
	}
$id;
	for ($k=0; $k <$nbcarte ; $k++) { 
		for ($i=0; $i <count($tab) ; $i++) {
			if ($nb<$tab[$i][0]) {
				$nb=$tab[$i][0];
				$id=$i;
			}	
		}
		$result[$k][0]=$nb;
		$result[$k][1]=$tab[$id][1];
		$tab[$id][0]=-1;
		$nb=0;

	}
	return $result;
}

function poker_mini($tab)
{
	$result=1;
	$nb=0;
	for ($i=0; $i <count($tab) ; $i++) { 
		if ($tab[$i]==-12) {
			$nb++;
		}
	}
	if ($nb==count($tab)) {
		$result=0;
	}
	return $result;
}

function poker($carte,$couleur,$carteV)
{   
	$result=0;
	$nbcarte=count($carte);
	$nb=quinte_flush($carte);
if ($nb==$nbcarte-1) {
	$result=350;
	$karatra=arrange($carte);
	$nb1=couleur($carte,$couleur);
	if ($karatra[0]['hauteur']==13 && $nb1==$nbcarte) {
			if ($karatra[0]['couleur']['hauteur']==4) {
				$result=60800;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==3) {
				$result=60700;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==2) {
				$result=60600;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==1) {
				$result=60500;
				return $result;
			}
		}
	if ($karatra[0]['hauteur']<13 && $nb1==$nbcarte) {
			if ($karatra[0]['couleur']['hauteur']==4) {
				$result=60400;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==3) {
				$result=60300;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==2) {
				$result=60200;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==1) {
				$result=60100;
				return $result;
			}
		}
	return $result;
}
if ($nb<$nbcarte-1) {
	$result=-12;
	$karatra=arrange($carte);
	$nb2=carre($carte,$carteV);
	$nb1=couleur($carte,$couleur);
	if ($nb2[0][0]==4) {
		$result=$nb2[0][1]*4000;
		/*max=52000 et min=4000;*/
		return $result;
		}
	if ($nb2[0][0]==3 && $nb2[1][0]==2) {
		$result=($nb2[0][1]+$nb2[1][1])*150;
		/*max=3750 et min=450;*/
			return $result;
		}
	if ($nb1==$nbcarte) {
			if ($karatra[0]['couleur']['hauteur']==4) {
				$result=403;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==3) {
				$result=402;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==2) {
				$result=401;
				return $result;
			}
			if ($karatra[0]['couleur']['hauteur']==1) {
				$result=400;
				return $result;
			}
		}
	if ($nb2[0][0]==3) {
			$result=$nb2[0][1]*26;
			/*max=338 et min=26;*/
			return $result;
		}
	if ($nb2[0][0]==2 && $nb2[1][0]==2) {
			$result=$nb2[0][1]+$nb2[1][1];
			/*max=25 et min=3;*/
			return $result;
		}
	if ($nb2[0][0]==2) {
			if ($nb2[0][1]==13) {
			$result=1;
			return $result;	
			}
			if ($nb2[0][1]==12) {
			$result=0;
			return $result;	
			}
			if ($nb2[0][1]==11) {
			$result=-1;
			return $result;	
			}
			if ($nb2[0][1]==10) {
			$result=-2;
			return $result;	
			}
			if ($nb2[0][1]==9) {
			$result=-3;
			return $result;	
			}
			if ($nb2[0][1]==8) {
			$result=-4;
			return $result;	
			}
			if ($nb2[0][1]==7) {
			$result=-5;
			return $result;	
			}
			if ($nb2[0][1]==6) {
			$result=-6;
			return $result;	
			}
			if ($nb2[0][1]==5) {
			$result=-7;
			return $result;	
			}
			if ($nb2[0][1]==4) {
			$result=-8;
			return $result;	
			}
			if ($nb2[0][1]==3) {
			$result=-9;
			return $result;	
			}
			if ($nb2[0][1]==2) {
			$result=-10;
			return $result;	
			}
			if ($nb2[0][1]==1) {
			$result=-11;
			return $result;	
			}

		}
	return $result;
}
}

function zenos($niveau,$money,$limite){
	$mise;
	if ($money>$limite) {
		if ($niveau>449) {
		$mise=rand($limite,$money);
		}
		if ($niveau>2 && $niveau<449) {
			$a=rand(0,50);
			if ($a>30) {
				$mise=0;
			}
			if ($a<=30) {
				$mise=rand($limite,$money);
			}
		}
		if ($niveau<2) {
		$nb=rand(0,1);
			if ($nb==0) {
			$mise=0;
			}
		$nb=rand(0,1);
			if ($nb==1) {
			$mise=rand($limite,($money-$limite));
			}
		}
		return $mise;
	}
	if ($money<$limite) {
			$mise=0;
		return $mise;
		}	
}
function dette($dette,$player)
{
	for ($i=0; $i <count($dette) ; $i++) { 
		if ($dette[$i]==1) {
			$player[$i]=1;
		}
	}
	return $player;
}
function total($gain)
{
	$nb=0;
	for ($i=0; $i <count($gain) ; $i++) { 
		$nb=$nb+$gain[$i];
	}
	return $nb;
}

?>