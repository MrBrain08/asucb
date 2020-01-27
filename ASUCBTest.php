<?php

function main($value)
{
    echo json_encode($value, JSON_UNESCAPED_UNICODE);
}

require_once 'ConnectDb.php';
    $connection = new ConnectDB($host_actual, $db_actual,$dbuser_actual,$dbpass_actual);

    $action1 = $connection->getRow("SELECT * FROM structure WHERE id = ?", ["1"]);

    $action2 = $connection -> getTree("SELECT * FROM structure");

    //$action3=$connection->insertrow ("INSERT INTO structure (id,parent_id,name) VALUE (?,?,?)", ["10","2","Ничейный Потомок"]);

    //Все действия с базой записаныв массив
    $actions = array($action1,$action2);

    //Последовательный перебор ассоциативного массива действий и вывод всех операций
    foreach($actions as $value) {
        main($value);
    }