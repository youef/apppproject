<?php
declare(strict_types=1);
session_start();
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
$configFile=__DIR__.'/../config.php';
if(!is_file($configFile)){http_response_code(503);exit('Configure config.php from config.example.php first.');}
$config=require $configFile;
function db(): PDO {global $config;static $pdo=null;if(!$pdo){$pdo=new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'].';charset=utf8mb4',$config['db_user'],$config['db_pass'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);}return $pdo;}
function e(?string $value):string{return htmlspecialchars((string)$value,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function csrf_field():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return '<input type="hidden" name="csrf" value="'.e($_SESSION['csrf']).'">';}
function verify_csrf():void{if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Invalid form token');}}
function admin():bool{return isset($_SESSION['admin_id']);}
function require_admin():void{if(!admin()){header('Location: admin.php');exit;}}
function redirect(string $to):never{header('Location: '.$to);exit;}
