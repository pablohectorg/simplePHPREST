<?php
Class Database{

  private $user = 'proinco_zipdev';
  private $pass = '12345';
  private $server = 'localhost';
  private $database = 'proinco_zipdev';
  private $instance;

  public function __construct(){
      $dsn = 'mysql:host='.$this->server.';dbname='.$this->database;
	    $options = [
	        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
	        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	    ];
	    $this->instance = new PDO($dsn, $this->user, $this->pass, $options);
  }

  public function get($table, $filter = false){
      $conditionStr = '';
      if($filter){
        $conditionStr = ' WHERE ';
        foreach ($filter as $field => $value) {
            $conditionStr .= $field." = '".$value."' AND ";
        }
        $conditionStr = substr($conditionStr, 0, -5);
      }

      $query = 'SELECT * FROM '.$table.$conditionStr;
      $result = $this->instance->query($query);
      if($result->rowCount() == 1){
        return $result->fetch();
      }else{
        return $result->fetchAll();
      }
  }

  public function insert($table, $data){

      foreach ($data as $field => $value) {
        $fieldsStr .= $field.',';
        $dataStr .= "'$value',";
      }
      $fieldsStr = substr($fieldsStr, 0, -1);
      $dataStr = substr($dataStr, 0, -1);
      $query = 'INSERT INTO '.$table.' ('.$fieldsStr.') VALUES ('.$dataStr.')';
      $result = $this->instance->query($query);
      return $result;
  }

  public function update($table, $filter, $data){

      $conditionStr = ' WHERE ';

      $updateStr = '';

      foreach ($filter as $field => $value) {
        $conditionStr .= $field." = '".$value."' AND ";
      }

      foreach ($data as $field => $value) {
        $updateStr .= $field." = '".$value."',";
      }

      $conditionStr = substr($conditionStr, 0, -5);
      $updateStr = substr($updateStr, 0, -1);

      $query = 'UPDATE '.$table.' SET '.$updateStr.' '.$conditionStr;
      $result = $this->instance->query($query);
      return $result;
  }

  public function delete($table, $condition){
      $result = $this->instance->query($query);
      return $result;
  }
}
?>
