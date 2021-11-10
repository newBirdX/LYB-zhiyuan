<?php
date_default_timezone_set('PRC');
require 'JWT.php';
use \Firebase\JWT\JWT;
define("KEY",'1gHuiop975cdashyex9Ud23ldsvm2Xq');
$action=@$_GET['action'];
$res['result']="failed";
if($action=="login"){
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$userName=$_POST['userName'];
		$pwd=md5($_POST['pwd']);
		include("conn.php");
		$res1=mysqli_query($conn,"select * from admins where admins='$userName' and pwd='$pwd'");
		$num=mysqli_fetch_array($res1);
		if($num){
			$nowtime=time();
			$token=[
				'iss' => 'http://localhost', //签发者
				'aud' => 'http://localhost', //jwt所面向的用户
				'iat' => $nowtime, //签发时间
				'nbf' => $nowtime + 10, //在什么时间之后该jwt才可用
				'exp' => $nowtime + 3600, //过期时间-10min
				'data' => [
				    'userId' => 1,
				    'userName' => $userName
				]
				
			];
			$jwt=JWT::encode($token,KEY);
			$res['jwt']=$jwt;
			$res['result']="success";
		}else{
			$res['msg']="用户名或者密码错误";
		}
		
	}
	echo json_encode($res);
}else{
	$jwt=@$_SERVER['HTTP_TOKEN'];
	if(empty($jwt)){
		$res['msg']="非法登录";
		echo json_encode($res);
		exit;
	}
	try{
		JWT::$leeway=60;
		$decoded=JWT::decode($jwt,KEY,['HS256']);
		$arr=(array)$decoded;
		if($arr['exp']<time()){
			$res['msg']="请重新登录";
		}else{
			$res['result']="success";
			$res['info']=$arr;
		}
	}catch(Exception $e){
		$res['msg']="Token验证错误,请联系管理员";
	}
	echo json_encode($res);
}

?>