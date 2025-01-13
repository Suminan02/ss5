<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login success</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php
session_start();

 if(isset($_SESSION['username'])&& $_SESSION['username']!=''){
    echo "username :"."".$_SESSION['username']."";
 }else{
    echo "login fail";
 }
?>
<script>
     $("#btn").click(function(){
        var username = $("#username").val();

        $.ajax ({
                    type: "POST", //METHOD "GET","POST"
                    url: "loginsucess.php", //File ที่ส่งค่าไปหา
                    data: dataString,
                    //cache: false,
                    success: function(data) {
                        //console.log(data);
                        var data_res=JSON.parse(data);
                        console.log(data_res);
                        if(data_res.ret_code==101){
                            
                        }else{
                            $("#wornning").html(data_res.msg);
                        }
                    } 
                });
     })

</script>
<a href="logout.php"><button type="button" id="btnlogout" >Back to logout</button></a>
<a href="loginpage.php"><button type="button" id="btnlogin" >Back to login</button></a>
</body>
</html>

