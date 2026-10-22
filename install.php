<?php
require __DIR__.'/src/bootstrap.php';
$installed=(int)db()->query('SELECT COUNT(*) FROM admins')->fetchColumn()>0;
if($installed){http_response_code(403);exit('Installation already completed. Delete install.php from hosting.');}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$email=trim($_POST['email']??'');$password=$_POST['password']??'';if(!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<12){$error='استخدم بريدًا صحيحًا وكلمة مرور 12 حرفًا على الأقل';}else{$stmt=db()->prepare('INSERT INTO admins(email,password_hash) VALUES(?,?)');$stmt->execute([$email,password_hash($password,PASSWORD_DEFAULT)]);redirect('admin.php');}}
?><!doctype html><html lang="ar" dir="rtl"><meta charset="utf-8"><link rel="stylesheet" href="assets/style.css"><main class="wrap"><h1>إنشاء حساب مدير المنصة</h1><p>بعد الإنشاء احذف install.php من الاستضافة.</p><form class="form" method="post"><?=csrf_field()?><label>البريد<input type="email" name="email" required></label><label>كلمة مرور قوية<input type="password" name="password" minlength="12" required></label><button class="btn">إنشاء المدير</button></form><p><?=e($error)?></p></main>