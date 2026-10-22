<?php
require_once __DIR__.'/bootstrap.php';
function customer():?array{if(empty($_SESSION['customer_id']))return null;$q=db()->prepare('SELECT id,name,email FROM customers WHERE id=?');$q->execute([(int)$_SESSION['customer_id']]);return $q->fetch()?:null;}
function require_customer():array{$u=customer();if(!$u)redirect('account.php?next=orders');return $u;}
function log_action(string $actor,int $id,string $action,?string $type=null,?int $subject=null):void{$q=db()->prepare('INSERT INTO activity_log(actor_type,actor_id,action,subject_type,subject_id) VALUES(?,?,?,?,?)');$q->execute([$actor,$id,$action,$type,$subject]);}
function role():string{if(!admin())return '';try{$q=db()->prepare('SELECT role FROM admin_roles WHERE admin_id=?');$q->execute([$_SESSION['admin_id']]);return $q->fetchColumn()?:'';}catch(PDOException $e){return '';}}
function can_manage(string $feature):bool{$r=role();return $r==='owner'||($feature==='content'&&$r==='editor')||($feature==='orders'&&in_array($r,['sales','support'],true));}
