<?php
$username="";
$password="";

    if(isset($_POST['username'])&&$_POST['username'] !=''){
    $username=$_POST['username'];
    }
    if($username==""){
    $response = array('ret_code'=>'001','msg'=>"empty input username");
    write_log(json_encode($response));
    echo json_encode($response);
    exit;
    }
    $pattern_username = "/^[a-zA-Z0-9_]{6,16}$/";
    if (preg_match($pattern_username, $username)==FALSE) {
        $response = array('ret'=>'201','msg'=>'Invalid pattern username');
        echo json_encode($response);
        write_log(json_encode($response));
        exit;
    }
    if(isset($_POST['password'])&&$_POST['password'] !=''){
        $password=$_POST['password'];
    }
    if($password==""){
        $response = array('ret_code'=>'002','msg'=>"empty input password");
        write_log(json_encode($response));
        echo json_encode($response);
        exit;
    }
    $pattern_password ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (preg_match($pattern_password, $password)==FALSE) {
            $response = array('ret'=>'202','msg'=>'Invalid pattern password');
            echo json_encode($response);
            write_log(json_encode($response));
            exit;
    }

    $servername = "";
    $usernamemysql = "";
    $passwordmysql = "";
    $dbname = "";
     
     $conn = mysqli_connect($servername, $usernamemysql, $passwordmysql);
     mysqli_select_db($conn,$dbname);

if ($conn->errno) {
 // die("Connection failed: " .$conn->connect_error);
  $response = array('ret_code'=>'400','msg'=>"connection fail DB".
  $conn->connect_errno,'data_post'=>$_POST);
  write_log(json_encode($response));
  echo json_encode($response);
  exit;
  
}

    @mysqli_query($conn,"set character_set_results=utf8mb4");
    @mysqli_query($conn,"set character_set_client=utf8mb4");
    @mysqli_query($conn,"set character_set_connection=utf8mb4");

    
    $password =md5($password);
    $sql = "SELECT username, password,status FROM user_info WHERE username='".$username."' AND password='".$password."' ";
  
    $result=mysqli_query($conn,$sql);
   
    $array_result = array();
    while($row = mysqli_fetch_object($result)) {
                array_push($array_result, $row);
            }
    
            
            if(count($array_result)==1){
                if($array_result[0]->status==1){
                    $response = array('ret_code'=>'101','msg'=>"login success");
                    write_log(json_encode($response));
                    echo json_encode($response);
                    
                    session_start();
                    $_SESSION['username']=$array_result[0]->username;

                }else{
                    $response = array('ret_code'=>'110','msg'=>"user not active");
                    write_log(json_encode($response));
                    echo json_encode($response);
                }
            }
            else{
                $response = array('ret_code'=>'111','msg'=>"user account not found or password incorrect");
                    write_log(json_encode($response));
                    echo json_encode($response);
            }
            

    mysqli_close( $conn );

    function write_log($log){
    //Something to write to txt log
    $date_log = date("Y-m-d H:i:s").PHP_EOL.
    "DATA : ".$log.PHP_EOL."-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('logs/log_'.date("Ymd").'.txt', $date_log, FILE_APPEND);
    }
   
?>