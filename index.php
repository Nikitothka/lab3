<?php

session_start();
require_once 'connection.php';

if(isset($_SESSION['message']))
{
	echo $_SESSION['message'];
	unset($_SESSION['message']);
}

$chat = mysqli_query($connect, "SELECT * FROM `chats` ORDER BY `id` DESC");
$chats = mysqli_fetch_all($chat);
$total = count($chats);
$per_page = 20;
$count_page = ceil($total/$per_page);
$page = $_GET['page']??1;
$page=(int)$page;

if(!$page || $page < 1){
        $page = 1;
    } else if ($page > $count_page) {
        $page = $count_page;
    }
    $start = ($page - 1) * $per_page;

?> 
<!DOCTYPE html>
<html>
    <head>
	<title>Анонимный чат</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
	<h1>Чат</h1>

	<a href="create_room.php" class ='btn btn-primary'> Создать комнату</a>



	<?php
		$chat_list = array_slice($chats, $start, $per_page);
		foreach($chat_list as $chat) {
	 	?>

	 <div>
	 	<?php
	 	if($chat[3] == '0'){
	 	$chat_info = "Имя чата: ".$chat[1]." Последнее обновление: ".$chat[4];}
	 	else{
	 		$chat_info = "Имя чата: ".$chat[1]." Последнее обновление: ".$chat[4]." ПРИВАТНЫЙ";
	 	}
echo $chat_info;
	 	?>
	 	<br>
	 	<a class="btn btn-primary" href="chat.html?id=<?=$chat[0]?>">Войти</a>
	 </div>
	<?php } ?>
	 <center>
	 	<?php
                    for ($i = 1; $i <= $count_page; $i++){
                        ?>
                        <a style="font-weight: bold"
                        href='?page=<?=$i?>'><?=$i?></a>
                        <?php
                    }
                    ?>
	 </center>


	 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
