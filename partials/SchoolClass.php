<?php 
     require_once 'Database.php';
    class SchoolClass extends Database{
    protected $classTable ="classes";

  
    public function getAllClasses(){
        $sql = "SELECT * FROM $this->classTable";
        $stmt = $this->conn->prepare($sql);
        try{
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){ 
            echo "Error:".$e->getMessage();
        }
    }


    public function addClass($data){
        if(!empty($data)){
            $sql = "INSERT INTO $this->classTable (className) VALUES (:className)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':className', $data['className']);
            try{
                $stmt->execute();
                echo "New class has been added.";
            }catch(PDOException $e){ 
                echo "Error:".$e->getMessage();
            }
        }
    }

 
    public function updateClass($id, $data){
        if(!empty($data)){
            $sql = "UPDATE $this->classTable SET className = :className WHERE class_id = :class_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':className', $data['className']);
            $stmt->bindParam(':class_id', $id);
            try{
                $stmt->execute();
                echo "Class with class_id $id has been updated.";
            }catch(PDOException $e){ 
                echo "Error:".$e->getMessage();
            }
        }
    }

   
    public function deleteClass($id){
        $sql = "DELETE FROM $this->classTable WHERE class_id = :class_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':class_id', $id);
        try{
            $stmt->execute();
            echo "Class with class_id $id has been deleted.";
        }catch(PDOException $e){ 
            echo "Error:".$e->getMessage();
        }
    }
    public function getSingleClassRow($field, $value){
    $sql = "SELECT * FROM $this->classTable WHERE $field = :value";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':value', $value);
    try{
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){ 
        echo "Error:".$e->getMessage();
    }
}

}

?>