<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"C:\xampp\htdocs\phpsystem\public/../application/front\view\postInfo\postInfo_frontshow.html";i:1543587974;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\header.html";i:1543588362;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\footer.html";i:1538061378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
  <TITLE>查看帖子详情</TITLE>
  <link href="__PUBLIC__/plugins/bootstrap.css" rel="stylesheet">
  <link href="__PUBLIC__/plugins/bootstrap-dashen.css" rel="stylesheet">
  <link href="__PUBLIC__/plugins/font-awesome.css" rel="stylesheet">
  <link href="__PUBLIC__/plugins/animate.css" rel="stylesheet"> 
</head>
<body style="margin-top:70px;"> 
<!--导航开始-->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!--小屏幕导航按钮和logo-->
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="__PUBLIC__/index.php" class="navbar-brand">php学生社团网</a>
        </div>
        <!--小屏幕导航按钮和logo-->
        <!--导航-->
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="__PUBLIC__/index.php">首页</a></li>
                <li><a href="<?php echo url('UserInfo/frontlist'); ?>">用户查询</a></li>
                <li><a href="<?php echo url('Shetuan/frontlist'); ?>">社团查询</a></li>
                <li><a href="<?php echo url('Yxzy/frontlist'); ?>">院系专业</a></li>
                <li><a href="<?php echo url('Shenqing/frontlist'); ?>">社团申请</a></li>
                <li><a href="<?php echo url('PostInfo/frontlist'); ?>">帖子交流</a></li>
                <!--<li><a href="<?php echo url('Reply/frontlist'); ?>">帖子回复</a></li>-->
                <li><a href="<?php echo url('Notice/frontlist'); ?>">新闻公告</a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if(\think\Session::get('user_name') == null): ?>
                <li><a href="<?php echo url('UserInfo/frontAdd'); ?>" onclick="register();"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;注册</a></li>
                <li><a href="#" onclick="login();"><i class="fa fa-user"></i>&nbsp;&nbsp;登录</a></li>
                    <?php else: ?>
                <li class="dropdown">
                    <a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo \think\Session::get('user_name'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="__PUBLIC__/index.php"><span class="glyphicon glyphicon-screenshot"></span>&nbsp;&nbsp;首页</a></li>
                        <li><a href="<?php echo url('Shenqing/user_frontlist'); ?>"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;我申请的社团</a></li>
                        <li><a href="<?php echo url('PostInfo/frontUserAdd'); ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;发布帖子</a></li>
                        <li><a href="<?php echo url('PostInfo/user_frontlist'); ?>"><span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;我发布的帖子</a></li>
                        <li><a href="<?php echo url('UserInfo/frontSelfModify'); ?>"><span class="glyphicon glyphicon-credit-card"></span>&nbsp;&nbsp;修改个人资料</a></li>

                    </ul>
                </li>
                <li><a href="<?php echo url('Index/logout'); ?>"><span class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;退出</a></li>
                <?php endif; ?>
            </ul>

        </div>
        <!--导航-->
    </div>
</nav>
<!--导航结束-->


<div id="loginDialog" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-key"></i>&nbsp;系统登录</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="loginForm" id="loginForm" enctype="multipart/form-data" method="post"  class="mar_t15">

                    <div class="form-group">
                        <label for="userName" class="col-md-3 text-right">用户名:</label>
                        <div class="col-md-9">
                            <input type="text" id="userName" name="userName" class="form-control" placeholder="请输入用户名">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-3 text-right">密码:</label>
                        <div class="col-md-9">
                            <input type="password" id="password" name="password" class="form-control" placeholder="登录密码">
                        </div>
                    </div>

                </form>
                <style>#bookTypeAddForm .form-group {margin-bottom:10px;}  </style>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="ajaxLogin();">登录</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<div id="registerDialog" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-sign-in"></i>&nbsp;用户注册</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="registerForm" id="registerForm" enctype="multipart/form-data" method="post"  class="mar_t15">



                </form>
                <style>#bookTypeAddForm .form-group {margin-bottom:10px;}  </style>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="ajaxRegister();">注册</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->






<script>

    function register() {
        $("#registerDialog input").val("");
        $("#registerDialog textarea").val("");
        $('#registerDialog').modal('show');
    }
    function ajaxRegister() {
        $("#registerForm").data('bootstrapValidator').validate();
        if(!$("#registerForm").data('bootstrapValidator').isValid()){
            return;
        }

        jQuery.ajax({
            type : "post" ,
            url : basePath + "UserInfo/add",
            dataType : "json" ,
            data: new FormData($("#registerForm")[0]),
            success : function(obj) {
                if(obj.success){
                    alert("注册成功！");
                    $("#registerForm").find("input").val("");
                    $("#registerForm").find("textarea").val("");
                }else{
                    alert(obj.message);
                }
            },
            processData: false,
            contentType: false,
        });
    }


    function login() {
        $("#loginDialog input").val("");
        $('#loginDialog').modal('show');
    }
    function ajaxLogin() {
        $.ajax({
            url : "<?php echo url('Index/frontLogin'); ?>",
            type : 'post',
            dataType: "json",
            data : {
                "userName" : $('#userName').val(),
                "password" : $('#password').val(),
            },
            success : function (obj, response, status) {
                if (obj.success) {
                    location.href = "__PUBLIC__/index.php";
                } else {
                    alert(obj.message);
                }
            }
        });
    }


</script>

<div class="container">
	<ul class="breadcrumb">
  		<li><a href="__PUBLIC__/index.php">首页</a></li>
  		<li><a href="<?php echo url('PostInfo/frontlist'); ?>">帖子信息</a></li>
  		<li class="active">详情查看</li>
	</ul>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">帖子id:</div>
		<div class="col-md-10 col-xs-6"><?php echo $postInfo['postInfoId']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">帖子标题:</div>
		<div class="col-md-10 col-xs-6"><?php echo $postInfo['title']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">帖子内容:</div>
		<div class="col-md-10 col-xs-6"><?php echo $postInfo['content']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">浏览量:</div>
		<div class="col-md-10 col-xs-6"><?php echo $postInfo['hitNum']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">发帖人:</div>
		<div class="col-md-10 col-xs-6"><?php echo $postInfo['userObjF']['name']; ?></div>
	</div>
	<div class="row bottom15"> 
		<div class="col-md-2 col-xs-4 text-right bold">发帖时间:</div>
		<div class="col-md-10 col-xs-6"><?php echo $postInfo['addTime']; ?></div>
	</div>
	<div class="row bottom15">
		<div class="col-md-2 col-xs-4 text-right bold">评论内容:</div>
		<div class="col-md-10 col-xs-6">
			<textarea id="content" style="width:100%" rows=8></textarea>
		</div>
	</div>

	<div class="row bottom15">
		<div class="col-md-2 col-xs-4"></div>
		<div class="col-md-6 col-xs-6">
			<button onclick="userReply();" class="btn btn-primary">发布评论</button>
			<button onclick="history.back();" class="btn btn-info">返回</button>
		</div>
	</div>
	<div class="row bottom15">
		<div class="col-md-2 col-xs-4 text-right bold"></div>
		<div class="col-md-8 col-xs-7">
			<?php if(is_array($replyList) || $replyList instanceof \think\Collection): $i = 0; $__LIST__ = $replyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$reply): $mod = ($i % 2 );++$i;?>
			<div class="row" style="margin-top: 20px;">
				<div class="col-md-2 col-xs-3">
					<div class="row text-center"><img src="__PUBLIC__/<?php echo $reply['userObjF']['userPhoto']; ?>" style="border: none;width:60px;height:60px;border-radius: 50%;" /></div>
					<div class="row text-center" style="margin: 5px 0px;"><?php echo $reply['userObjF']['user_name']; ?></div>
				</div>
				<div class="col-md-7 col-xs-5"><?php echo $reply['content']; ?></div>
				<div class="col-md-3 col-xs-4" ><?php echo $reply['replyTime']; ?></div>
			</div>

			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div> 
<!--footer-->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="http://www.baidu.com" target=_blank>© 大神开发网 from 2020</a> |
                <a href="http://www.baidu.com">本站招聘</a> |
                <a href="http://www.baidu.com">联系站长</a> |
                <a href="http://www.baidu.com">意见与建议</a> |
                <a href="http://www.baidu.com" target=_blank>蜀ICP备0343346号</a> |
                <a href="__PUBLIC__/back/login">后台登录</a>
            </div>
        </div>
    </div>
</footer>
<!--footer-->





<script src="__PUBLIC__/plugins/jquery.min.js"></script>
<script src="__PUBLIC__/plugins/bootstrap.js"></script>
<script src="__PUBLIC__/plugins/wow.min.js"></script>
<script>

    function userReply() {
        var content = $("#content").val();
        if(content == "") {
            alert("请输入评论内容");
            return;
        }

        $.ajax({
            url : "<?php echo url('Reply/frontUserAdd'); ?>",
            type : "post",
            dataType: "json",
            data: {
                "reply_postInfoObj_postInfoId": <?php echo $postInfo['postInfoId']; ?>,
                "reply_content": content
            },
            success : function (data, response, status) {
                if(data.success){
                    alert("评论成功~");
                    location.reload();
                } else{
                    alert(data.message);
                }
            }
        });
    }

$(function(){
        /*小屏幕导航点击关闭菜单*/
        $('.navbar-collapse a').click(function(){
            $('.navbar-collapse').collapse('hide');
        });
        new WOW().init();
 })
 </script> 
</body>
</html>

