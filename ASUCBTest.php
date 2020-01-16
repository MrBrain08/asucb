<?php
header('Content-Type: text/html; charset=utf-8');
$dsn = "mysql:host=localhost; dbname=asucb";
$username = "root";
$password = "abc123";


try {
	$dbcon = new PDO($dsn,$username,$password);
	echo "Подключено";
	$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlquery = "SELECT id, parent_id, name FROM structure"; 
    $run = $dbcon->prepare($sqlquery);
    $run -> execute();

    $fetch = array();

    while($row=$run->fetch(PDO::FETCH_ASSOC)) {
    	$fetch['structure'][] = $row;
    }
   	//Преобразуем массив в json формат
    echo json_encode($fetch, JSON_UNESCAPED_UNICODE);
}  
//Отлавливаем исключения
catch(PDOException $e) {
	 $error_message = $e -> getMessage();
	 echo $error_message;
	 exit();
}



?>