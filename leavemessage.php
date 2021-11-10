<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
	$author=$_POST['author'];
	$content=$_POST['content'];
	// $face=$_POST['face'];
	$title=$_POST['title'];
	include("conn.php");
	$flag=mysqli_query($conn,"insert into messages(author,content,title,addtime) values('$author','$content','$title',now())");
	if($flag){
		echo '{"status":"10001","msg":"success"}';
	}else{
		echo '{"status":"20001","msg":"添加失败,请联系管理员"}';
	}
}else{
	header("location:error.php");
}



?>