<?php

class MydbAccessLayer
{
    protected $connection = null;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:dbname=" . DB_DATABASE_NAME . ";host=" . DB_HOST . ";", DB_USERNAME, DB_PASSWORD);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function select($query = "", $params = []) 
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $result[] = $row;
            }
            return $result;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function insert($query = "", $params = []) 
    {
        // code
    }

    private function executeStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }

            foreach($params as $key => $param) {
                if(is_numeric($param)) {
                    $stmt->bindParam($key, $param, PDO::PARAM_INT);
                } else {
                    $stmt-> bindParam($key, $param, PDO::PARAM_STR);
                }
            }

            $stmt->execute();
            
            return $stmt;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}