<?php
require __DIR__.'/src/bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}
verify_csrf();
if(!empty($_POST['website']))exit;
$name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$message=trim($_POST['message']??'');$category=$_POST['category']??'other';
if($name===''||mb_strlen($name)>120||!filter_var($email,FILTER_VALIDATE_EMAIL)||mb_strlen($email)>190||$message===''||mb_strlen($message)>5000||!in_array($category,['service','product','other'],true)){http_response_code(422);exit('Invalid request');}
if(isset($_SESSION['last_request'])&&time()-$_SESSION['last_request']<30){http_response_code(429);exit('Please wait before sending again');}
$stmt=db()->prepare('INSERT INTO requests(name,email,category,message) VALUES(?,?,?,?)');$stmt->execute([$name,$email,$category,$message]);$_SESSION['last_request']=time();redirect('index.php?page=contact&sent=1');
