<?php

class db{
    //propriedades
    private $dbhost = 'localhost';
    private $dbuser = 'root';
    private $dbpass = '';
    private $dbname = 'slimapp';

    //conectar 

    public function connect(){
     //quebrando a forma PDO confome manual do php http://php.net/manual/pt_BR/pdo.connections.php
        
        $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname"; // a primeira string apenas guarda o server e nome da base de dados
        $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }



}

