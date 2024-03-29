<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 26/08/2019
 * Time: 14:49
 */

class Sql extends PDO {
    private $conn;

    public function __construct() {
      $this->conn = new PDO('mysql:host=143.106.241.3;dbname=cl17126;charset=utf8', 'cl17126', 'cl*13022002');
    }

    public function setParams($statement, $parameters=array()) {
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    //método separado para o caso de necessidade de algum tratamento
    public function setParam($statement, $key, $value) {
        $statement->bindParam($key, $value);
    }

    //executa qualquer query e retorna o resultado da execução - se for select(registros), delete/update/insert(rows afetadas)
    public function query($rawQuery, $params = array()) {
        $stmt =  $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt;
    }

    public function select($rawQuery, $params = array()):array {
        $stmt = $this->query($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC: returns an array indexed by column name as returned in your result set
    }
}
?>