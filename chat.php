<?php
session_start();
require_once 'connection.php';

function wordFilter($text)
{
    $filter_terms = array('\bass(es|holes?)?\b', '\bshit(e|ted|ting|ty|head)\b');
    $filtered_text = $text;
    foreach($filter_terms as $word)
    {
        $match_count = preg_match_all('/' . $word . '/i', $text, $matches);
        for($i = 0; $i < $match_count; $i++)
            {
                $bwstr = trim($matches[0][$i]);
                $filtered_text = preg_replace('/\b' . $bwstr . '\b/', str_repeat("*", strlen($bwstr)), $filtered_text);
            }
    }
    return $filtered_text;
}
function load($db, $id){
	$echo = "";
	$result = mysqli_query($db, "SELECT * FROM `messages` where `chat_id` = '$id'");
	if($result){
		if(mysqli_num_rows($result) >= 1){
			while($array = mysqli_fetch_array($result)) {//Выводим их с помощью цикла
					$q = "SELECT * FROM `messages` WHERE `chat_id` = '$id' AND `user_name` = '$array[user_name]'";
					$user_result = mysqli_query($db,$q);//Получаем данные об авторе сообщения
					if(mysqli_num_rows($user_result) == 1) {
						$user = mysqli_fetch_array($user_result);
						$message_text="<div><b>$user[user_name]:</b>$array[text]</div>";
						$echo .= $message_text; //Добавляем сообщения в переменную $echo
					}
				}

			} else {
				$echo = "Нет сообщений!";//В базе ноль записей
		}
	}

	return $echo;
}

function send($db, $message, $id, $login) {
	$message = htmlspecialchars($message);//Заменяем символы ‘<’ и ‘>’на ASCII-код
	$date = date("Y-m-d H:i:s");		$message = trim($message); //Удаляем лишние пробелы
	$message = addslashes($message); //Экранируем запрещенные символы
	$message = wordFilter($message);
	$result = mysqli_query($db,"INSERT INTO `messages`(`id`, `chat_id`, `date`, `text`, `user_name`) VALUES (NULL,'$id','$date','$message','$login')");//Заносим сообщение в базу данных
	mysqli_query($db, "UPDATE `chats` SET `last_update`='$date' WHERE `id` = '$id'");
	return load($db, $id);
}

if(isset($_POST['act'])) {$act = htmlspecialchars($_POST['act'] ?? '');}
if(isset($_POST['var1'])) {$var1 = htmlspecialchars($_POST['var1'] ?? '');}
if(isset($_POST['login'])) {$login = htmlspecialchars($_POST['login'] ?? '');}
if(isset($_POST['id'])) {$id = htmlspecialchars($_POST['id'] ?? '');}

switch($_POST['act']) {//В зависимости от значения act вызываем разные функции
	case 'load':
		$echo = load($connect, $id); //Загружаем сообщения
		break;

	case 'send':
		if(isset($var1)) {
			$echo = send($connect,$var1, $id, $login); //Отправляем сообщение
		}
		break;
	default:
		break;
}

echo $echo;