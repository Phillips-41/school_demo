<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Database {
    private $dbserver = "localhost";
    private $dbuser = "root";
    private $dbpassword = "Phillips@41";
    private $dbname = "school_db";
    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->dbserver;dbname=$this->dbname", $this->dbuser, $this->dbpassword);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully"; 
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
}
?>
