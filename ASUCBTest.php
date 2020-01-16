<?php
$dsn = "mysql:host=localhost; dbname=asucb";
$username = "root";
$password = "abc123";


try {
	$conn = new PDO($dsn, $username, $password);
	echo "You have connected";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, parent_id, name FROM structure"); 
    $stmt->execute();
    //Преобразование результирующего массива в ассоциативный
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $key=>$v) { 
        
        $jresult = json_encode($v);
		echo json_encode($jresult);
    }
}
    
catch(PDOException $e) {
	 $error_message = $e -> getMessage();
	 echo $error_message;
	 exit();
}



?>