<?php
header("content-type:text/html;charset=utf-8");
if($_SERVER['REQUEST_METHOD']=="POST"){
	$page=$_POST['page'];
	include("conn.php");
	$num1=($page-1)*5;
	$rs=mysqli_query($conn,"select * from messages order by addTime desc limit $num1,5");//limit 后面两个数字 用,隔开  第一个参数是从哪里开始第二个参数是截取几个  这里如果$num1带上'' 会报错
	$json='{"status":"10001","msg":"ok","data":[';
	$num=mysqli_num_rows($rs);
	if($num>0){
		while($info=mysqli_fetch_array($rs)){
			$json.=json_encode($info).",";
		}
		echo substr($json,0,strlen($json)-1)."]}";
	}else{
		echo '{"status":"20001","msg":"没有记录"}';
	}
	
	
}else{
	header("location:errpr.php");
}



?>