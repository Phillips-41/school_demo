<?php

    require_once 'Database.php';
    class User extends Database{
    protected $studentTable ="student";
    protected $classTable ="classes";

    public function add($data){
        if(!empty($data)){
            $this->conn->query("INSERT INTO $this->classTable (className) VALUES ('".$data['className']."')");
            $data['class_id'] = $this->conn->lastInsertId();

            $fields = [];
            $placeholders = [];
            foreach($data as $field => $value){
                if($field != 'className'){
                    $fields[] = $field;
                    $placeholders[] = ":$field";
                }
            }
            $sql = "INSERT INTO $this->studentTable (". implode(',', $fields).") VALUES (". implode(',', $placeholders).")";
            $stmt = $this->conn->prepare($sql);
            foreach($data as $field => &$value){
                if($field != 'className'){
                    $stmt->bindParam($field, $value);
                }
            }
            try{
                $stmt->execute();
            }catch(PDOException $e){ 
                echo "Error:".$e->getMessage();
            }
        }
    }

    public function getAllRows(){
        $sql = "SELECT * FROM $this->studentTable JOIN $this->classTable ON $this->studentTable.class_id = $this->classTable.class_id";
        $stmt = $this->conn->prepare($sql);
        try{
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){ 
            echo "Error:".$e->getMessage();
        }
    }

    public function getSingleRow($field, $value){
        $sql = "SELECT * FROM $this->studentTable JOIN $this->classTable ON $this->studentTable.class_id = $this->classTable.class_id WHERE $field = :value";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':value', $value);
        try{
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){ 
            echo "Error:".$e->getMessage();
        }
    }

    // public function getCount(){
    //     $sql = "SELECT COUNT(*) as count FROM $this->studentTable";
    //     $stmt = $this->conn->prepare($sql);
    //     try{
    //         $stmt->execute();
    //         return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    //     }catch(PDOException $e){ 
    //         echo "Error:".$e->getMessage();
    //     }
    // }
    public function uploadPhoto($file){
        if(!empty($file)){
            $fileTemPath = $file['tmp_name'];
            $fileName=$file['name'];
            $fileType=$file['type'];
            $fileNameCmps=explode('.',$fileName);
            $fileExtension=strtolower(end($fileNameCmps));
            $newFileName=md5(time().$fileName).'.'.$fileExtension;
            $allowedExten=["jpg","png"];
            if(in_array($fileExtension,$allowedExten)){
                $uploadFileDir=getcwd().'/uploads/';
                $destFilePath=$uploadFileDir.$newFileName;
                if(move_uploaded_file($fileTemPath,$destFilePath)){
                    return $newFileName;
                }
            }
        }
        return null;
    }
    // Function to update data
        public function update($id, $data){
            if(!empty($data)){
                // Update student table
                $student_fields = ['name', 'email', 'address', 'class_id', 'image'];
                $student_data = array_intersect_key($data, array_flip($student_fields));
                $fields = [];
                foreach($student_data as $field => $value){
                    $fields[] = "$field = :$field";
                }
                $sql = "UPDATE $this->studentTable SET ". implode(',', $fields)." WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $student_data['id'] = $id;
                foreach($student_data as $field => &$value){
                    $stmt->bindParam($field, $value);
                }
                try{
                    $stmt->execute();
                    echo "Data in student table with id $id has been updated.";
                }catch(PDOException $e){ 
                    echo "Error:".$e->getMessage();
                }

                // Update classes table
                if(isset($data['className'])){
                    $sql = "UPDATE $this->classTable SET className = :className WHERE class_id = :class_id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':className', $data['className']);
                    $stmt->bindParam(':class_id', $data['class_id']);
                    try{
                        $stmt->execute();
                        echo "Data in classes table with class_id {$data['class_id']} has been updated.";
                    }catch(PDOException $e){ 
                        echo "Error:".$e->getMessage();
                    }
                }
            }
        }
        // Function to delete data
        public function delete($id){
            // Delete from student table
            $sql = "DELETE FROM $this->studentTable WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            try{
                $stmt->execute();
                echo "Data in student table with id $id has been deleted.";
            }catch(PDOException $e){ 
                echo "Error:".$e->getMessage();
            }

            // Delete from classes table
            $sql = "DELETE FROM $this->classTable WHERE class_id = :class_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':class_id', $id);
            try{
                $stmt->execute();
                echo "Data in classes table with class_id $id has been deleted.";
            }catch(PDOException $e){ 
                echo "Error:".$e->getMessage();
            }
        }

    }
?>