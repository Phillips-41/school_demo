<?php
$action = '';
if(isset($_POST['action'])){
    $action = $_POST['action'];
}
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

require_once 'partials/User.php';
$obj = new User();

if(isset($_GET['action'])){
    $action = $_GET['action'];
}
// adding user action
    if($action == 'addstudent' && !empty($_POST) ){
        $pname=$_POST ['username' ];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $photo=$_FILES['userphoto']; 
        $class=$_POST['class'];
        $playerid=(! empty($_POST['studentId' ]))? $_POST['studentId']: "";
        $imagename="";
        if(!empty($photo['name'])){
            $imagename=$obj ->uploadPhoto($photo);
            $playerData =[
                'name'=>$pname,
                'email'=>$email,
                'address'=>$address,
                'className'=>$class,
                'image'=>$imagename
            ];
       }else{
        $playerData =[
                'name'=>$pname,
                'email'=>$email,
                'address'=>$address,
                'className'=>$class
        ];
       }
       if($playerid){
        $obj->update($playerid,$playerData);
       }else{
        $playerid =$obj->add($playerData);
       }
       
       if(!empty($playerid)){
        $player = $obj->getSingleRow('id',$playerid);
        echo json_encode($player);
        exit();
       }

    }
   if($action == 'getAllStudents'){
    $users = $obj->getAllRows();
    if(!empty($users)){
        $userlist = $users;
    }else{
        $userlist = [];
    }
    echo json_encode($userlist);
    exit();
    }
    if($action=='edituserdata'){
       $playerid=(! empty($_GET['id' ]))? $_GET['id']: ""; 
       if(!empty($playerid)){
        $user = $obj->getSingleRow('id',$playerid);
        echo json_encode($user);
        exit();
       }
    }
    if($action == 'deleteuser'){
         $userid=(! empty($_GET['id' ]))? $_GET['id']: ""; 
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
