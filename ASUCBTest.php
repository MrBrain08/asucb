<?php

function main($value)
{
    echo json_encode($value, JSON_UNESCAPED_UNICODE);
}

require_once 'ConnectDb.php';
    $connection = new ConnectDB($host_actual, $db_actual,$dbuser_actual,$dbpass_actual);
    //Список действий-запросов
    $action1 = $connection->getRow("SELECT * FROM structure WHERE id = ?", ["1"]);

    $action2 = $connection -> getTree("SELECT * FROM structure");
    //"Внедрить возможность ответтсвенных за подразделение": присваиваем определенный parent_id
    $action3 = $connection -> insertRow("INSERT INTO structure(id, parent_id, name) VALUE(?, ?, ?)", [""]);
    $action4 = $connection -> updRow("UPDATE structure SET name = ? WHERE id = 1", [""]);
    $action5 = $connection -> deletRow("DELETE FROM structure WHERE id = ?", []);

    //внедрить возможность добавдения ответственных за подразделение
    $action6 = $connection -> insertRow("INSERT INTO relations(id, name) VALUE(?,?)",[""]);
    //Возможность на просмотр всех ответсвтенных за подразделение 
    $action7 = $connection -> getTree("SELECT * FROM relations JOIN structure ON structure.id = relations.id");


    //$action3=$connection->insertrow ("INSERT INTO structure (id,parent_id,name) VALUE (?,?,?)", ["10","2","Ничейный Потомок"]);

    //Все действия с базой записаны в массив
    $actions = array($action1,$action2,$action7);

    //Последовательный перебор ассоциативного массива действий и вывод всех операций
    foreach($actions as $value) {
        main($value);
    }