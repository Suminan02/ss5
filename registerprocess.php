<?php
//echo json_encode($_POST);
$username="";
$password="";
$c_password="";
$name="";
$lastname="";
$email="";
$cid="";
$phone="";
$address="";

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
  if(isset($_POST['c_password'])&&$_POST['c_password'] !=''){
    $c_password=$_POST['c_password'];
  }
  if($c_password==""){
    $response = array('ret_code'=>'003','msg'=>"empty input confirm password");
    write_log(json_encode($response));
    echo json_encode($response);
    exit;
  }
  $pattern_c_password ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (preg_match($pattern_c_password, $c_password)==FALSE) {
        $response = array('ret'=>'203','msg'=>'Invalid pattern confirm password');
        echo json_encode($response);
        write_log(json_encode($response));
        exit;
    }
  if($c_password!=$password){
    $response = array('ret_code'=>'122','msg'=>"password and confirm password not same");
    write_log(json_encode($response));
    echo json_encode($response);
    exit;
  }
  if(isset($_POST['name'])&&$_POST['name'] !=''){
    $name=$_POST['name'];
  }
  if($name==""){
    $response = array('ret_code'=>'004','msg'=>"empty name");
    write_log(json_encode($response));
    echo json_encode($response);
    exit;
  }
  $pattern_name = "/^\p{L}+$/u";
    if (preg_match($pattern_name, $name)==FALSE) {
        $response = array('ret'=>'204','msg'=>'Invalid pattern name');
        echo json_encode($response);
        write_log(json_encode($response));
        exit;
    }
  if(isset($_POST['lastname'])&&$_POST['lastname'] !=''){ 
    $lastname=$_POST['lastname']; 
    }
  if($lastname==""){$response = 
    array('ret_code'=>'005','msg'=>"empty lastname"); 
    write_log(json_encode($response)); echo json_encode($response);
    exit;
    }
    $pattern_lastname = "/^\p{L}+$/u";
    if (preg_match($pattern_lastname , $lastname)==FALSE) {
        $response = array('ret'=>'205','msg'=>'Invalid pattern last name');
        echo json_encode($response);
        write_log(json_encode($response));
        exit;
    }

    if(isset($_POST['email'])&&$_POST['email'] !=''){
    $email=$_POST['email'];
     }
  
  if($email==""){
    $response = array('ret_code'=>'006','msg'=>"empty email");
    write_log(json_encode($response));
    echo json_encode($response);
    exit;
  }
  $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    if (preg_match($pattern_email , $email)==FALSE) {
        $response = array('ret'=>'206','msg'=>'Invalid pattern email');
        echo json_encode($response);
        write_log(json_encode($response));
        exit;
    }
  if(isset($_POST['cid'])&&$_POST['cid'] !=''){
    $cid=$_POST['cid'];
  }
  if($cid==""){
    $response = array('ret_code'=>'007','msg'=>"empty citizen id");
    write_log(json_encode($response));
    echo json_encode($response);
    exit;
  }
  $pattern_cid= "/^[0-9]+.{12,}$/";
    if (preg_match($pattern_cid , $cid)==FALSE) {
        $response = array('ret'=>'207','msg'=>'Invalid pattern citizen ID');
        echo json_encode($response);
        write_log(json_encode($response));
        exit;
    }
  if(isset($_POST['phone'])&&$_POST['phone'] !=''){
    $phone=$_POST['phone'];
  }
  if(isset($_POST['address'])&&$_POST['address'] !=''){
    $address=$_POST['address'];
  }
  // $response = array('ret_code'=>'101','msg'=>"success","data"=>$_POST);
  // write_log(json_encode($response));
  // echo json_encode($response);

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
$sql="INSERT INTO `full_ss5`.`user_info` (`username`, `password`, `citizen_id`, `email`, `name`, `surname`, `address`, `phone`) 	
VALUES ('".$username."', '".$password."', '".$cid."', '".$email."', '".$name."', '".$lastname."', '".$address."', '".$phone."');";

$result_insert=mysqli_query($conn,$sql);

if($result_insert){
  $response = array('ret_code'=>'101','msg'=>"success","data"=>$_POST);
  write_log(json_encode($response));
  echo json_encode($response);
}else{
    //dupicaye error
    $response = array('ret_code'=>'400','msg'=>"unsuccess".mysqli_error($conn),"data_post"=>$_POST);
    write_log(json_encode($response));
    echo json_encode($response);
}
mysqli_close( $conn );

  function write_log($log){
    //Something to write to txt log
    $date_log = date("Y-m-d H:i:s").PHP_EOL.
    "IP :".get_client_ip().$_SERVER['REMOTE_ADDR'].PHP_EOL.
    "DATA : ".$log.PHP_EOL."-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('logs/log_'.date("Ymd").'.txt', $date_log, FILE_APPEND);
}

function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
     $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}
?>