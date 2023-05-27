<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"C:\xampp\htdocs\phpsystem\public/../application/front\view\reply\reply_frontlist.html";i:1542887793;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\header.html";i:1543584427;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\footer.html";i:1538061378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
<title>帖子回复查询</title>
<link href="__PUBLIC__/plugins/bootstrap.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/bootstrap-dashen.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/font-awesome.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/animate.css" rel="stylesheet">
<link href="__PUBLIC__/plugins/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>
<body style="margin-top:70px;">
<div class="container">
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
                <li><a href="<?php echo url('PostInfo/frontlist'); ?>">帖子查询</a></li>
                <li><a href="<?php echo url('Reply/frontlist'); ?>">帖子回复</a></li>
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
                        <li><a href="<?php echo url('BookType/frontlist'); ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;发布信息</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;我发布的信息</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-credit-card"></span>&nbsp;&nbsp;修改个人资料</a></li>
                        <li><a href="<?php echo url('Book/frontlist'); ?>"><span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;我的收藏</a></li>
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

	<div class="row"> 
		<div class="col-md-9 wow fadeInDown" data-wow-duration="0.5s">
			<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
			    	<li><a href="__PUBLIC__/index.php">首页</a></li>
			    	<li role="presentation" class="active"><a href="#replyListPanel" aria-controls="replyListPanel" role="tab" data-toggle="tab">帖子回复列表</a></li>
			    	<li role="presentation" ><a href="<?php echo url('Reply/frontAdd'); ?>" style="display:none;">添加帖子回复</a></li>
				</ul>
			  	<!-- Tab panes -->
			  	<div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="replyListPanel">
				    		<div class="row">
				    			<div class="col-md-12 top5">
				    				<div class="table-responsive">
				    				<table class="table table-condensed table-hover">
				    					<tr class="success bold"><td>序号</td><td>回复id</td><td>被回帖子</td><td>回复内容</td><td>回复人</td><td>回复时间</td><td>操作</td></tr>
				    					<?php
				    						/*计算起始序号*/
				    	            		$startIndex = ($currentPage-1) * $rows;
				    	            		$currentIndex = $startIndex+1;
				    	            		/*遍历记录*/
				    					if(is_array($replyRs) || $replyRs instanceof \think\Collection): $i = 0; $__LIST__ = $replyRs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$reply): $mod = ($i % 2 );++$i;?>
 										<tr>
 											<td><?php echo $currentIndex++; ?></td>
 											<td><?php echo $reply['replyId']; ?></td>
 											<td><?php echo $reply['postInfoObjF']['title']; ?></td>
 											<td><?php echo $reply['content']; ?></td>
 											<td><?php echo $reply['userObjF']['name']; ?></td>
 											<td><?php echo $reply['replyTime']; ?></td>
 											<td>
 												<a href="<?php echo url('Reply/frontshow',array('replyId'=>$reply['replyId'])); ?>"><i class="fa fa-info"></i>&nbsp;查看</a>&nbsp;
 												<a href="#" onclick="replyEdit('<?php echo $reply['replyId']; ?>');" style="display:none;"><i class="fa fa-pencil fa-fw"></i>编辑</a>&nbsp;
 												<a href="#" onclick="replyDelete('<?php echo $reply['replyId']; ?>');" style="display:none;"><i class="fa fa-trash-o fa-fw"></i>删除</a>
 											</td> 
 										</tr>
 										<?php endforeach; endif; else: echo "" ;endif; ?>
				    				</table>
				    				</div>
				    			</div>
				    		</div>

				    		<div class="row">
					            <div class="col-md-12">
						            <nav class="pull-left">
						                <ul class="pagination">
						                    <li><a href="#" onclick="GoToPage(<%=currentPage-1 %>,<%=totalPage %>);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
						                     <?php
						                    	$startPage = $currentPage - 5;
						                    	$endPage = $currentPage + 5;
						                    	if($startPage < 1) $startPage=1;
						                    	if($endPage > $totalPage) $endPage = $totalPage;
						                    	for($i=$startPage;$i<=$endPage;$i++) {
						                    ?>
						                    <li class="<?php echo $currentPage==$i?"active":""; ?>"><a href="#"  onclick="GoToPage(<?php echo $i; ?>,<?php echo $totalPage; ?>);"><?php echo $i; ?></a></li>
						                    <?php } ?>
						                    <li><a href="#" onclick="GoToPage(<?php echo $currentPage + 1; ?>,<?php echo $totalPage; ?>);"><span aria-hidden="true">&raquo;</span></a></li>
						                </ul>
						            </nav>
						            <div class="pull-right" style="line-height:75px;" >共有<?php echo $recordNumber; ?>条记录，当前第<?php echo $currentPage; ?>/<?php echo $totalPage; ?>页</div>
					            </div>
				            </div> 
				    </div>
				</div>
			</div>
		</div>
	<div class="col-md-3 wow fadeInRight">
		<div class="page-header">
    		<h1>帖子回复查询</h1>
		</div>
		<form name="replyQueryForm" id="replyQueryForm" action="<?php echo url('Reply/frontlist'); ?>" class="mar_t15" method="post">
            <div class="form-group">
            	<label for="postInfoObj_postInfoId">被回帖子：</label>
                <select id="postInfoObj_postInfoId" name="postInfoObj_postInfoId" class="form-control">
                	<option value="0">不限制</option>
	 				<?php
	 				foreach($postInfoList as $postInfo) {
	 					$selected = "";
 					if($postInfoObj['postInfoId'] == $postInfo['postInfoId'])
 						$selected = "selected";
	 				?>
 				 <option value="<?php echo $postInfo['postInfoId']; ?>" <?php echo $selected; ?>><?php echo $postInfo['title']; ?></option>
	 				<?php
	 				}
	 				?>
 			</select>
            </div>
            <div class="form-group">
            	<label for="userObj_user_name">回复人：</label>
                <select id="userObj_user_name" name="userObj_user_name" class="form-control">
                	<option value="">不限制</option>
	 				<?php
	 				foreach($userInfoList as $userInfo) {
	 					$selected = "";
 					if($userObj['user_name'] == $userInfo['user_name'])
 						$selected = "selected";
	 				?>
 				 <option value="<?php echo $userInfo['user_name']; ?>" <?php echo $selected; ?>><?php echo $userInfo['name']; ?></option>
	 				<?php
	 				}
	 				?>
 			</select>
            </div>
			<div class="form-group">
				<label for="replyTime">回复时间:</label>
				<input type="text" id="replyTime" name="replyTime" class="form-control"  placeholder="请选择回复时间" value="<?php echo $replyTime; ?>" onclick="SelectDate(this,'yyyy-MM-dd')" />
			</div>
            <input type=hidden name=currentPage id="currentPage" value="<%=currentPage %>" />
            <button type="submit" class="btn btn-primary" onclick="$('#currentPage').val(1);return true;">查询</button>
        </form>
	</div>

		</div>
	</div> 
<div id="replyEditDialog" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;帖子回复信息编辑</h4>
      </div>
      <div class="modal-body" style="height:450px; overflow: scroll;">
      	<form class="form-horizontal" name="replyEditForm" id="replyEditForm" enctype="multipart/form-data" method="post"  class="mar_t15">
		  <div class="form-group">
			 <label for="reply_replyId_edit" class="col-md-3 text-right">回复id:</label>
			 <div class="col-md-9"> 
			 	<input type="text" id="reply_replyId_edit" name="reply.replyId" class="form-control" placeholder="请输入回复id" readOnly>
			 </div>
		  </div> 
		  <div class="form-group">
		  	 <label for="reply_postInfoObj_postInfoId_edit" class="col-md-3 text-right">被回帖子:</label>
		  	 <div class="col-md-9">
			    <select id="reply_postInfoObj_postInfoId_edit" name="reply_postInfoObj_postInfoId" class="form-control">
			    </select>
		  	 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="reply_content_edit" class="col-md-3 text-right">回复内容:</label>
		  	 <div class="col-md-9">
			    <textarea id="reply_content_edit" name="reply_content" rows="8" class="form-control" placeholder="请输入回复内容"></textarea>
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="reply_userObj_user_name_edit" class="col-md-3 text-right">回复人:</label>
		  	 <div class="col-md-9">
			    <select id="reply_userObj_user_name_edit" name="reply_userObj_user_name" class="form-control">
			    </select>
		  	 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="reply_replyTime_edit" class="col-md-3 text-right">回复时间:</label>
		  	 <div class="col-md-9">
                <div class="input-group date reply_replyTime_edit col-md-12" data-link-field="reply_replyTime_edit">
                    <input class="form-control" id="reply_replyTime_edit" name="reply_replyTime" size="16" type="text" value="" placeholder="请选择回复时间" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
		  	 </div>
		  </div>
		</form> 
	    <style>#replyEditForm .form-group {margin-bottom:5px;}  </style>
      </div>
      <div class="modal-footer"> 
      	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      	<button type="button" class="btn btn-primary" onclick="ajaxReplyModify();">提交</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
<script src="__PUBLIC__/plugins/bootstrap-datetimepicker.min.js"></script>
<script src="__PUBLIC__/plugins/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsdate.js"></script>
<script>
/*跳转到查询结果的某页*/
function GoToPage(currentPage,totalPage) {
    if(currentPage==0) return;
    if(currentPage>totalPage) return;
    document.replyQueryForm.currentPage.value = currentPage;
    document.replyQueryForm.submit();
}

/*可以直接跳转到某页*/
function changepage(totalPage)
{
    var pageValue=document.replyQueryForm.pageValue.value;
    if(pageValue>totalPage) {
        alert('你输入的页码超出了总页数!');
        return ;
    }
    document.replyQueryForm.currentPage.value = pageValue;
    documentreplyQueryForm.submit();
}

/*弹出修改帖子回复界面并初始化数据*/
function replyEdit(replyId) {
	$.ajax({
		url :  "<?php echo url('Reply/update'); ?>?replyId=" + replyId ,
		type : "get",
		dataType: "json",
		success : function (reply, response, status) {
			if (reply) {
				$("#reply_replyId_edit").val(reply.replyId);
				$.ajax({
					url: "<?php echo url('Reply/listAll'); ?>",
					type: "get",
					dataType: "json",
					success: function(postInfos,response,status) { 
						$("#reply_postInfoObj_postInfoId_edit").empty();
						var html="";
		        		$(postInfos).each(function(i,postInfo){
		        			html += "<option value='" + postInfo.postInfoId + "'>" + postInfo.title + "</option>";
		        		});
		        		$("#reply_postInfoObj_postInfoId_edit").html(html);
		        		$("#reply_postInfoObj_postInfoId_edit").val(reply.postInfoObj);
					}
				});
				$("#reply_content_edit").val(reply.content);
				$.ajax({
					url: "<?php echo url('Reply/listAll'); ?>",
					type: "get",
					dataType: "json",
					success: function(userInfos,response,status) { 
						$("#reply_userObj_user_name_edit").empty();
						var html="";
		        		$(userInfos).each(function(i,userInfo){
		        			html += "<option value='" + userInfo.user_name + "'>" + userInfo.name + "</option>";
		        		});
		        		$("#reply_userObj_user_name_edit").html(html);
		        		$("#reply_userObj_user_name_edit").val(reply.userObj);
					}
				});
				$("#reply_replyTime_edit").val(reply.replyTime);
				$('#replyEditDialog').modal('show');
			} else {
				alert("获取信息失败！");
			}
		}
	});
}

/*删除帖子回复信息*/
function replyDelete(replyId) {
	if(confirm("确认删除这个记录")) {
		$.ajax({
			type : "POST",
			url: "<?php echo url('Reply/deletes'); ?>",
			data : {
				replyIds : replyId,
			},
			dataType: "json",
			success : function (obj) {
				if (obj.success) {
					alert("删除成功");
					$("#replyQueryForm").submit();
					//location.href="<?php echo url('Reply/frontlist'); ?>";
				}
				else 
					alert(obj.message);
			},
		});
	}
}

/*ajax方式提交帖子回复信息表单给服务器端修改*/
function ajaxReplyModify() {
	$.ajax({
		url :  "<?php echo url('Reply/update'); ?>",
		type : "post",
		dataType: "json",
		data: new FormData($("#replyEditForm")[0]),
		success : function (obj, response, status) {
            if(obj.success){
                alert("信息修改成功！");
                $("#replyQueryForm").submit();
            }else{
                alert(obj.message);
            } 
		},
		processData: false,
		contentType: false,
	});
}

$(function(){
	/*小屏幕导航点击关闭菜单*/
    $('.navbar-collapse a').click(function(){
        $('.navbar-collapse').collapse('hide');
    });
    new WOW().init();

    /*回复时间组件*/
    $('.reply_replyTime_edit').datetimepicker({
    	language:  'zh-CN',  //语言
    	format: 'yyyy-mm-dd hh:ii:ss',
    	weekStart: 1,
    	todayBtn:  1,
    	autoclose: 1,
    	minuteStep: 1,
    	todayHighlight: 1,
    	startView: 2,
    	forceParse: 0
    });
})
</script>
</body>
</html>

