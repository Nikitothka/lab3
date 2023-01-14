<?php 
	$connect = mysqli_connect('localhost', 'root','', 'anon_chat');

	if(!$connect){
		die('Error connect to DataBase');
	}