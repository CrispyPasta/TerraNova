<?php
class Sql {
    //  property to store all conn settings to the DB in one array
    private $c = array(
        'host' => 'localhost',
        'username' => 'WarehouseRoot',
        'password' => 'WarehouseRoot',
        'port' => '3306',
    );

    public $conn = NULL;

    function __construct(){
    }

    //  connection function
    private function connect($dbname = 'users') {
        //this line seems to just dump a massive error to the page and I don't know how to stop it from doing that.
        $this->conn = new mysqli($this->c['host'], $this->c['username'], $this->c['password'], $dbname); 
        if($this->conn->connect_error){
            echo("Connection to database failed");
            exit(0);
        }
    }

    // disconnect function
    private function disconnect() {
        unset($conn);
        $this->conn->close();
    }

    /**
     * @param query Holds the string representation of the SQL query to be executed. 
     * @brief This function is used to execute queries that don't return records, only make changes in the database.
     * @return True/False Whether or not the query executed successfully. 
     */
    public function runQuery($query) {
        $this->connect('warehouse');
        $result = $this->conn->query($query);
        if ($result === true){
            return true;
        } else if ($result === false){
            return false;
        } else {
            return $result;
        }
    }

}
?>