<?php
/*
 *      Index.php
 *      
 *     Copyright 2010 Srihari <srih4ri@gmail.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
include 'dbconfig.php';
if($_GET['act']=='destroy'){
	session_start();
	session_destroy();
	header("location:index.php");
	}
if($_POST['is_creating']=='1'){
	$gameid=time();
	$q="INSERT INTO bingo_game (game_id,player_list) VALUES ('".$gameid."','".$_POST['username']."')";
	mysql_query($q);
	session_start();
	$_SESSION['username']=$_POST['username'];
	$_SESSION['game_id']=$gameid;
	$_SESSION['player']=0;
	$linear_bingo=range(1,25);
	shuffle($linear_bingo);
	for($i = 0;$i<5;$i++)
		for($j = 0;$j<5;$j++)
			$bingo[$i][$j]=$linear_bingo[$i*5+$j];
	$_SESSION['bingo']=$bingo;
	header('location:bingo.html');	
}
if($_POST['is_joining']=='1'){
	session_start();
	$gameid=$_POST['game_id'];
	if(mysql_num_rows(mysql_query("SELECT * FROM bingo_game WHERE game_id='$gameid'"))==1){
	$r=mysql_fetch_array(mysql_query("SELECT player_list FROM bingo_game WHERE game_id='$gameid'"));
	$player_list=$r['player_list'];
	$player_list.=", ".$_POST['username'];
	$q="UPDATE bingo_game SET player_list = '$player_list' WHERE game_id='$gameid'";
	mysql_query($q);
	$_SESSION['username']=$_POST['username'];
	$_SESSION['game_id']=$gameid;
	$_SESSION['player']=1;
	$linear_bingo=range(1,25);
	shuffle($linear_bingo);
	for($i = 0;$i<5;$i++)
		for($j = 0;$j<5;$j++)
			$bingo[$i][$j]=$linear_bingo[$i*5+$j];
	$_SESSION['bingo']=$bingo;
	header('location:bingo.html');
	}
	else{	die("invalid Game");}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Welcome to BINGO Online</title>
</head>
<body>
<div align=center>
<div style="border: 1px solid #667;width:370px; background-color: #00FFBA;text-align:left;">
	<form action="<? echo $_PHP['SELF']; ?>" method="post"?>
	Name:<input name="username" type="text"/>
	<input name="is_creating" type="hidden" value="1"/>
	<input type="submit" value="Create game"/></form>
</div>
	<br><br>
<div style="border: 1px solid #667;width:370px; background-color: #EECCEC;text-align:left;">
	<form action="<? echo $_PHP['SELF']; ?>" method="post"?>
	Name:<input name="username" type="text"/><br>
	Game ID:<input name="game_id" type="text"/>
	<input name="is_joining" type="hidden" value="1"/>
	<input type="submit" value="Join Game"/>
	</form>	
	</div>
</div>
</body>
</html>
