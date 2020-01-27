<?php

header('Content-Type: text/html; charset=utf-8');


$host_actual = "localhost";
$db_actual = "asucb";
$dbuser_actual = "root";
$dbpass_actual = "abc123";

//Создание класса взаимодействия с БД
class ConnectDb
{
    //Свойства и методы класса
    private $host= "localhost"; //Хост mysql:host=localhost;
    private $db= "asucb"; //dbname=asucb";
    private $db_user= "root";// Пользователь "root";
    private $db_pass= "abc123"; // Пароль "abc123";
    private $db_con; //Коннект к БД - переменная класса для подключения

    public $isConn; //Переменная для проверки подключения к БД

    //Конструктор для подключения к БД
    public function __construct($host,$db,$dbuser,$dbpass)
    {
        $this->isConn = TRUE;
        try {
            $this->db_con = new PDO("mysql:host=$this->host; dbname=$this->db", $this->db_user, $this->db_pass);
            $this->db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db_con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            echo "Подключение установлено";
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

    }
    //Методы 
    //Функция отключения от БД
    public function disconnectDB()
    {
        $this->db_con = NULL;
        $this->isConn = FALSE; 
    }
    //Метод получения информации от одной строки 
    public function getRow($query, $params = [])
    {
       try {
            $stmt = $this->db_con->prepare($query);
            $stmt->execute($params);

            return $stmt->fetch(); //Возвращение только одной строки 

       } catch(PDOException $e) {
            throw new Exception($e->getMessage());
       }
    }
    //Функция запроса всего дерева
    public function getTree($query, $params = [])
    {
       try {
            $stmt = $this->db_con->prepare($query);
            $stmt->execute($params);
            return $stmt -> fetchAll(); //Возвращение всех строк 

       } catch(PDOException $e) {
            throw new Exception($e->getMessage());
            
       }
    }
    //Метод вставки строки
    public function insertRow($query,$params=[])
    {
        try {
            $stmt = $this->db_con->prepare($query);
            $stmt->execute($params);
            return TRUE ;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    //Метод обновление строки
    public function updRow($query, $params = [])
    {
        $this->insertRow($query,$params);
    }
    //Метод удаления строки
    public function deleteRow($query, $params = [])
    {
        $this->insertRow($query,$params);
    }  
}
//Класс доделан

//Начало взаимодействия с бд

//Функция вывод в JSON
/*
function main($value)
{
    echo json_encode($value, JSON_UNESCAPED_UNICODE);
}
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
    */
