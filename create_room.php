<?php
if (isset($_SESSION['message']))
            {
            $message = $_SESSION['message'];
            echo $message;
            unset($_SESSION['message']);
            }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Создать комнату</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
	<div>
		<form method="POST" action="create.php">
			Название: <input type="text" name="name"> <br>
			<div class = "form-check">
			<label class="form-check-label" for="flex">
    			Приватный
  			</label>
			<input type="checkbox" class = "form-check-input" name="private" id="flex" onclick="toggle()"> <br>
			</div>

			<div id="passwords" style="display: none;">
				Введите никнеймы: <input type="text" name="names">
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value='Создать'>
		</form>
	</div>

<script type="text/javascript">
	function toggle(){
		var el = document.getElementById("passwords");
		if(el.style.display === "none"){
			el.style.display = "block";
		}
		else {
			el.style.display = "none";
		}
	}
</script>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>