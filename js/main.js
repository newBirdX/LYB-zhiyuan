// 用户留言模块
$(function(){
    var page=1;
    var pagecount=1;
    var rescount=1;
    $("#fbly").click(function(){
        $("#ly").fadeIn(500);
    })
    $("#cancel").click(function(){
        $("#ly").fadeOut(500);
    })
    // 设置ajax默认参数
    $.ajaxSetup({
        type:"POST",
        dataType:"json"
    })
    // 用户留言
    $("#submit").click(function(){
        $.ajax({
            url:"leavemessage.php",
            data:{author:$("#author").val(),title:$("#title").val(),content:$("#cont").val()},
            success:function(res){
                if(res.status=="10001"){
                    alert("发布成功！");
                    $("#author,#cont,#title").val("");
                    $("#ly").hide();
                }else{
                    alert(res.msg);
                }
            }
        })
    })
    // 取回留言需要的页数
    $.ajax({
        url:"rescount.php",
        success:function(res){
            rescount=res.rescount;
            pagecount=Math.ceil(rescount/4);
        }
    })
    // 获取留言
    $.ajax({
        url:"message.php",
        data:{page:page},
        success:function(res){
            var str="";
            if(res.status=="10001"){
                alert("aaaa");
                $.each(res.data,function(index,value){
                    str+='<div class="ly_content">'+'<p class="author">作者是：'+value.author+'</p>'+'<p class="title">题目是：'+value.title+'</p>'+'<p class="content">内容是：'+value.content+'</p>'+(value.reply!=null?'<p class="glreply">管理员回复到:<em><strong>'+value.reply+'</strong></em></p>':"")+'</div>';
                })
                $("#content").html(str+$("#content").html());
            }else{
                alert("xxx");
                str="<p>"+res.msg+"</p>"
					$("#content").html(str);
            }
        }
    })
    // 上一页
    // var flag=true;
    // if()
})

