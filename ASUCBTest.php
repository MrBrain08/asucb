﻿<?php

header('Content-Type: text/html; charset=utf-8');

$host_actual = "localhost";
$db_actual = "asucb";
$dbuser_actual = "root";
$dbpass_actual = "abc123";


//Создание класса взаимодействия с БД
class Connect_DB
{
    //Свойства и методы класса
    private $host= "localhost"; //Хост mysql:host=localhost;
    private $db= "asucb"; //dbname=asucb";
    private $dbuser= "root";// Пользователь "root";
    private $dbpass= "abc123"; // Пароль "abc123";
    public $dbcon; //Коннект к БД - переменная класса для подключения

    public $isConn; //Переменная для проверки подключения к БД

    //Конструктор для подключения к БД
    public function __construct($host,$db,$dbuser,$dbpass)
    {
        $this->isConn = TRUE;
        try {
            $this->dbcon = new PDO("mysql:host=$this->host; dbname=$this->db", $this->dbuser, $this->dbpass);
            $this->dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbcon->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            echo "Подключение установлено <br>";
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

    }
    //Методы 
    //Функция отключения от БД
    public function disconnestDB()
    {
        $this->dbcon = NULL;
        $this->isConn = FALSE; 
    }
    //Метод получения информации от одной строки 
    public function getrow($query, $params = [])
    {
       try {
            $stmt = $this->dbcon->prepare($query);
            $stmt->execute($params);
            $outvalue = $stmt->fetchAll();
            return $outvalue;

       } catch(PDOException $e) {
            throw new Exception($e->getMessage());
            
       }
    }
    //Функция запроса всего дерева
    public function gettree($query, $params = [])
    {
       try {
            $stmt = $this->dbcon->prepare($query);
            $stmt->execute($params);
            return $stmt -> fetchAll();

       } catch(PDOException $e) {
            throw new Exception($e->getMessage());
            
       }
    }
    //Метод вставки строки
    public function insertrow($query,$params=[])
    {
        try {
            $stmt = $this->dbcon->prepare($query);
            $stmt->execute($params);
            return TRUE;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    //Метод обновление строки
    public function updrow($query, $params = [])
    {
        $this->insertrow($query,$params);
    }
    //Метод удаления строки
    public function deleterow($query, $params = [])
    {
        $this->insertrow($query,$params);
    }  
}
//Класс доделан

//Начало взаимодействия с бд

//Функция вывод в JSON
function main($value)
{
    echo "<br>";
    echo json_encode($value, JSON_UNESCAPED_UNICODE);
    echo "<br>";
}
    $connection = new Connect_DB($host_actual, $db_actual,$dbuser_actual,$dbpass_actual);

    $action1 = $connection->getrow("SELECT * FROM structure WHERE id = ?", ["1"]);

    $action2 = $connection -> gettree("SELECT * FROM structure");

    //Все действия с базой записаныв массив
    $actions = array($action1,$action2);

    //Последовательный перебор ассоциативного массива действий и вывод всех операций
    foreach($actions as $value)
        main($value);

?>