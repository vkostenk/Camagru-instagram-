<?php
require 'database.php';
try
{
	$pdo = new PDO('mysql:host=localhost;', 'root', 'root');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
 catch (PDOException $e) {
    echo $e->getMessage();
}
$reqest = "CREATE DATABASE IF NOT EXISTS db_camagru;";
$pdo->prepare($reqest)->execute();
require('conect.php');
// $reqest = "USE db_camagru;"
// $pdo->prepare($reqest)->execute();

$reqest = "CREATE TABLE IF NOT EXISTS `db_camagru`.`users` ( `user_id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `phone` VARCHAR(11) NOT NULL , `password` VARCHAR(255) NOT NULL , `valid` INT NOT NULL DEFAULT 0, PRIMARY KEY (`user_id`)) ENGINE = InnoDB;";
	 $pdo->prepare($reqest)->execute();

	 $reqest = "CREATE TABLE IF NOT EXISTS photo (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(40) NOT NULL,
	photo_path varchar(40) NOT NULL,
	photo_date datetime NOT NULL,
	PRIMARY KEY(id))
	ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$pdo->prepare($reqest)->execute();

$reqest = "CREATE TABLE IF NOT EXISTS comments (
	id int NOT NULL AUTO_INCREMENT,
	id_photo int NOT NULL,
	author varchar(40) NOT NULL,
	comment text NOT NULL,
	date_com datetime NOT NULL,
	PRIMARY KEY(id))
	ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$pdo->prepare($reqest)->execute();
 ?>
