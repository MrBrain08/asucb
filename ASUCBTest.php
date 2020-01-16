<?php

header('Content-Type: text/html; charset=utf-8');

try {
	gettree("mysql:host=localhost; dbname=asucb","root","abc123");
	getinfo("mysql:host=localhost; dbname=asucb","root","abc123");
	updateinfo("mysql:host=localhost; dbname=asucb","root","abc123");

}

//Отлавливаем исключения
catch(PDOException $e) {
	$error_message = $e -> getMessage();
	echo $error_message;
	exit();
}

function gettree($dsn,$username,$password) 
{
	$dbcon = new PDO($dsn,$username,$password);
	echo "Подключение установлено <br>";
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

function getinfo($dsn,$username,$password)
{
	$dbcon2 = new PDO($dsn,$username,$password);
	$infoquery = "SELECT * FROM structure WHERE id = 1"; 
    $run2 = $dbcon2->prepare($infoquery);
    $run2 -> execute();
    $fetch2 = array();

    while($row2=$run2->fetch(PDO::FETCH_ASSOC)) {
    	$fetch2['structure'][] = $row2;
    }
   	//Преобразуем массив в json формат
   	echo "<br> Информация об определенном элементе узла <br>";
	echo json_encode($fetch2, JSON_UNESCAPED_UNICODE);
}

function updateinfo($dsn,$username,$password)
{
	$dbcon3 = new PDO($dsn,$username,$password);
	$updquery = "UPDATE structure SET name = 'Университет3' WHERE id = 1"; 
	$getnew = "SELECT * FROM structure WHERE id = 1";
    $run3 = $dbcon3->prepare($updquery);
    $run4 = $dbcon3->prepare($getnew);
    $run3 -> execute();
    $run4 -> execute();
    $fetch3 = array();
    $fetch4 = array();

    while($row3=$run3->fetch(PDO::FETCH_ASSOC)) {
    	$fetch3['structure'][] = $row3;
    }
    while($row4=$run4->fetch(PDO::FETCH_ASSOC)) {
    	$fetch3['structure'][] = $row4;
    }
   	//Преобразуем массив в json формат
   	echo "<br> Информация об обновленном элементе узла <br>";
	echo json_encode($fetch3, JSON_UNESCAPED_UNICODE);
	echo json_encode($fetch4, JSON_UNESCAPED_UNICODE);
}


?>