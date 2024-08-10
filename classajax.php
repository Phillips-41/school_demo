<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = '';
if(isset($_POST['action'])){
    $action = $_POST['action'];
}
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

require_once 'partials/SchoolClass.php';
$obj = new SchoolClass();

// adding user action
if($action == 'addstudent' && !empty($_POST) ){
    $pname=$_POST ['className' ];
    $playerid=(! empty($_POST['classId' ]))? $_POST['classId']: "";
    $playerData =[
        'ClassName'=>$pname,
    ];
    if($playerid){
        $obj->updateClass($playerid,$playerData);
    }else{
        $playerid =$obj->addClass($playerData);
    }
}
   if($action == 'getAllClass'){
    $users = $obj->getAllClasses();
    if(!empty($users)){
        $userlist = $users;
    }else{
        $userlist = [];
    }
    echo json_encode($userlist);
    exit();
    }
    if($action=='editclassdata'){
       $playerid=(! empty($_GET['class_id' ]))? $_GET['class_id']: ""; 
       if(!empty($playerid)){
        $user = $obj->getSingleClassRow('id',$playerid);
        echo json_encode($user);
        exit();
       }
    }
    if($action == 'deleteclass'){
         $userid=(! empty($_GET['class_id' ]))? $_GET['class_id']: ""; 
         if(!empty($userid)){
            $isdeleted =$obj->delete($userid);
            if($isdeleted){
                $displaymessage['deleted']=1;;
            }else{
                 $displaymessage['deleted']=0;;
            }
            echo json_encode($displaymessage);
         }
    }
?>
