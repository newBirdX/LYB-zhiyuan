<?php
  header("content-type:text/html;charset=utf-8");
  if($_SERVER['REQUEST_METHOD']=="POST"){
      include("conn.php");
      $res1=mysqli_query($conn,"select * from messages where sh==1");
      $rescount=mysqli_num_rows($res1);
      $res['result']="success";
      $res['rescount']=$rescount;
      echo json_encode($res);
  }else{
      header("location:error.html");
  }
?>