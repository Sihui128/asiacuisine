<?php
function dbConnect($usertype='write', $connectionType = 'pdo') {
	$host = 'localhost';
	$db = 'asiacuisine_orders';
	if ($usertype  == 'read') {
	$user = 'asiacuisine_user';
	$pwd = 'Sihui8mp5e878';
	} elseif ($usertype == 'write') {
	$user = 'asiacuisine_user';
	$pwd = 'Sihui8mp5e878';
	} else {
	exit('Unrecognized connection type');
	}
	if ($connectionType == 'mysqli') {
	return new mysqli($host, $user, $pwd, $db) or die ('Cannot open database');
	} else {
		try {
			return new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
		} catch (PDOException $e) {
			echo 'Cannot connect to database';
			exit;
		}
	}
}