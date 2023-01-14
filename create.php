<?php
	session_start();
	require_once 'connection.php';
	if(isset($_POST['name'])){
		$name = htmlspecialchars($_POST['name'] ?? '');
	}
	else{
		$_SESSION['message'] = "Введите название чата";
		header('Location: create_room.php');
	}
	if(htmlspecialchars($_POST['private'] ?? '') == 'on')
		{
			$names = json_encode(explode(" ", htmlspecialchars($_POST['names'] ?? '')));
			$private = 1;
		}
	else{
			$names = json_encode(" ");
			$private = 0;
	}
	$date= date("Y-m-d H:i:s");
	$q = "INSERT INTO `chats`(`id`, `chat_name`, `nicknames`, `private`, `last_update`) VALUES (NULL,'$name','$names','$private','$date')";
	mysqli_query($connect, $q);
	$q = "SELECT * FROM `chats` WHERE `chat_name` = '$name'";
	$result = mysqli_query($connect, $q);
	$r = $result->fetch_assoc();
	$id = (int)$r['id'];
	$location = "chat.html?id=".$id;
	header("Location: $location");