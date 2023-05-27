<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"C:\xampp\htdocs\phpsystem\public/../application/front\view\shetuan\shetuan_frontlist.html";i:1542887791;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\header.html";i:1543588362;s:77:"C:\xampp\htdocs\phpsystem\public/../application/front\view\common\footer.html";i:1538061378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
<title>社团查询</title>
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

	<div class="col-md-9 wow fadeInLeft">
		<ul class="breadcrumb">
  			<li><a href="__PUBLIC__/index.php">首页</a></li>
  			<li><a href="<?php echo url('Shetuan/frontlist'); ?>">社团信息列表</a></li>
  			<li class="active">查询结果显示</li>
  			<a class="pull-right" href="<?php echo url('Shetuan/frontAdd'); ?>" style="display:none;">添加社团</a>
		</ul>
		<div class="row">
			<?php
				/*计算起始序号*/
				$startIndex = ($currentPage-1) * $rows;
				$currentIndex = $startIndex+1;
				/*遍历记录*/
			if(is_array($shetuanRs) || $shetuanRs instanceof \think\Collection): $i = 0; $__LIST__ = $shetuanRs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shetuan): $mod = ($i % 2 );++$i;
				$clearLeft = "";
				if(($i-1)%4 == 0) $clearLeft = "style=\"clear:left;\"";
			?>
			<div class="col-md-3 bottom15" <?php echo $clearLeft; ?>>
			  <a  href="<?php echo url('Shetuan/frontshow',array('shetuanId'=>$shetuan['shetuanId'])); ?>"><img class="img-responsive" src="__PUBLIC__/<?php echo $shetuan['shetuanPhoto']; ?>" /></a>
			     <div class="showFields">
			     	<div class="field">
	            		社团id:<?php echo $shetuan['shetuanId']; ?>
			     	</div>
			     	<div class="field">
	            		社团名称:<?php echo $shetuan['shetuanName']; ?>
			     	</div>
			     	<div class="field">
	            		所在院系专业:<?php echo $shetuan['yxzyObjF']['yxzyName']; ?>
			     	</div>
			     	<div class="field">
	            		成立日期:<?php echo $shetuan['bornDate']; ?>
			     	</div>
			     	<div class="field">
	            		负责人:<?php echo $shetuan['fuzeren']; ?>
			     	</div>
			     	<div class="field">
	            		联系电话:<?php echo $shetuan['telephone']; ?>
			     	</div>
			        <a class="btn btn-primary top5" href="<?php echo url('Shetuan/frontshow',array('shetuanId'=>$shetuan['shetuanId'])); ?>">详情</a>
			        <a class="btn btn-primary top5" onclick="shetuanEdit('<?php echo $shetuan['shetuanId']; ?>');" style="display:none;">修改</a>
			        <a class="btn btn-primary top5" onclick="shetuanDelete('<?php echo $shetuan['shetuanId']; ?>');" style="display:none;">删除</a>
			     </div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>

			<div class="row">
				<div class="col-md-12">
					<nav class="pull-left">
						<ul class="pagination">
							<li><a href="#" onclick="GoToPage(<?php echo $currentPage-1; ?>,<?php echo $totalPage; ?>);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
							<?php
								$startPage = $currentPage - 5;
								$endPage = $currentPage + 5;
								if($startPage < 1) $startPage=1;
								if($endPage > $totalPage) $endPage = $totalPage;
								for($i=$startPage;$i<=$endPage;$i++) {
							?>
							<li class="<?php echo $currentPage==$i?"active":""; ?>"><a href="#"  onclick="GoToPage(<?php echo $i; ?>,<?php echo $totalPage; ?>);"><?php echo $i; ?></a></li>
							<?php } ?>
							<li><a href="#" onclick="GoToPage(<?php echo $currentPage+1; ?>,<?php echo $totalPage; ?>);"><span aria-hidden="true">&raquo;</span></a></li>
						</ul>
					</nav>
					<div class="pull-right" style="line-height:75px;" >共有<?php echo $recordNumber; ?>条记录，当前第 <?php echo $currentPage; ?>/<?php echo $totalPage; ?>  页</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3 wow fadeInRight">
		<div class="page-header">
    		<h1>社团查询</h1>
		</div>
		<form name="shetuanQueryForm" id="shetuanQueryForm" action="<?php echo url('Shetuan/frontlist'); ?>" class="mar_t15" method="post">
			<div class="form-group">
				<label for="shetuanName">社团名称:</label>
				<input type="text" id="shetuanName" name="shetuanName" value="<?php echo $shetuanName; ?>" class="form-control" placeholder="请输入社团名称">
			</div>
            <div class="form-group">
            	<label for="yxzyObj_yxzyId">所在院系专业：</label>
                <select id="yxzyObj_yxzyId" name="yxzyObj_yxzyId" class="form-control">
                	<option value="0">不限制</option>
	 				<?php
	 				foreach($yxzyList as $yxzy) {
	 					$selected = "";
 					if($yxzyObj['yxzyId'] == $yxzy['yxzyId'])
 						$selected = "selected";
	 				?>
 				 <option value="<?php echo $yxzy['yxzyId']; ?>" <?php echo $selected; ?>><?php echo $yxzy['yxzyName']; ?></option>
	 				<?php
	 				}
	 				?>
 			</select>
            </div>
			<div class="form-group">
				<label for="bornDate">成立日期:</label>
				<input type="text" id="bornDate" name="bornDate" class="form-control"  placeholder="请选择成立日期" value="<?php echo $bornDate; ?>" onclick="SelectDate(this,'yyyy-MM-dd')" />
			</div>
			<div class="form-group">
				<label for="telephone">联系电话:</label>
				<input type="text" id="telephone" name="telephone" value="<?php echo $telephone; ?>" class="form-control" placeholder="请输入联系电话">
			</div>
            <input type=hidden name=currentPage id="currentPage" value="<?php echo $currentPage; ?>" />
            <button type="submit" class="btn btn-primary" onclick="$('#currentPage').val(1);return true;">查询</button>
        </form>
	</div>

		</div>
</div>
<div id="shetuanEditDialog" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:900px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;社团信息编辑</h4>
      </div>
      <div class="modal-body" style="height:450px; overflow: scroll;">
      	<form class="form-horizontal" name="shetuanEditForm" id="shetuanEditForm" enctype="multipart/form-data" method="post"  class="mar_t15">
		  <div class="form-group">
			 <label for="shetuan_shetuanId_edit" class="col-md-3 text-right">社团id:</label>
			 <div class="col-md-9"> 
			 	<input type="text" id="shetuan_shetuanId_edit" name="shetuan.shetuanId" class="form-control" placeholder="请输入社团id" readOnly>
			 </div>
		  </div> 
		  <div class="form-group">
		  	 <label for="shetuan_shetuanName_edit" class="col-md-3 text-right">社团名称:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="shetuan_shetuanName_edit" name="shetuan_shetuanName" class="form-control" placeholder="请输入社团名称">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="shetuan_shetuanPhoto_edit" class="col-md-3 text-right">社团图片:</label>
		  	 <div class="col-md-9">
			    <img  class="img-responsive" id="shetuan_shetuanPhotoImg" border="0px"/><br/>
			    <input type="hidden" id="shetuan_shetuanPhoto_edit" name="shetuan_shetuanPhoto"/>
			    <input id="shetuanPhotoFile" name="shetuanPhotoFile" type="file" size="50" />
		  	 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="shetuan_yxzyObj_yxzyId_edit" class="col-md-3 text-right">所在院系专业:</label>
		  	 <div class="col-md-9">
			    <select id="shetuan_yxzyObj_yxzyId_edit" name="shetuan_yxzyObj_yxzyId" class="form-control">
			    </select>
		  	 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="shetuan_bornDate_edit" class="col-md-3 text-right">成立日期:</label>
		  	 <div class="col-md-9">
                <div class="input-group date shetuan_bornDate_edit col-md-12" data-link-field="shetuan_bornDate_edit" data-link-format="yyyy-mm-dd">
                    <input class="form-control" id="shetuan_bornDate_edit" name="shetuan_bornDate" size="16" type="text" value="" placeholder="请选择成立日期" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
		  	 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="shetuan_shetuanDesc_edit" class="col-md-3 text-right">社团简介:</label>
		  	 <div class="col-md-9">
			 	<textarea name="shetuan_shetuanDesc" id="shetuan_shetuanDesc_edit" style="width:100%;height:500px;"></textarea>
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="shetuan_fuzeren_edit" class="col-md-3 text-right">负责人:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="shetuan_fuzeren_edit" name="shetuan_fuzeren" class="form-control" placeholder="请输入负责人">
			 </div>
		  </div>
		  <div class="form-group">
		  	 <label for="shetuan_telephone_edit" class="col-md-3 text-right">联系电话:</label>
		  	 <div class="col-md-9">
			    <input type="text" id="shetuan_telephone_edit" name="shetuan_telephone" class="form-control" placeholder="请输入联系电话">
			 </div>
		  </div>
		</form> 
	    <style>#shetuanEditForm .form-group {margin-bottom:5px;}  </style>
      </div>
      <div class="modal-footer"> 
      	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      	<button type="button" class="btn btn-primary" onclick="ajaxShetuanModify();">提交</button>
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
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
//实例化编辑器
var shetuan_shetuanDesc_edit = UE.getEditor('shetuan_shetuanDesc_edit'); //社团简介编辑器
/*跳转到查询结果的某页*/
function GoToPage(currentPage,totalPage) {
    if(currentPage==0) return;
    if(currentPage>totalPage) return;
    document.shetuanQueryForm.currentPage.value = currentPage;
    document.shetuanQueryForm.submit();
}

/*可以直接跳转到某页*/
function changepage(totalPage)
{
    var pageValue=document.shetuanQueryForm.pageValue.value;
    if(pageValue>totalPage) {
        alert('你输入的页码超出了总页数!');
        return ;
    }
    document.shetuanQueryForm.currentPage.value = pageValue;
    documentshetuanQueryForm.submit();
}

/*弹出修改社团界面并初始化数据*/
function shetuanEdit(shetuanId) {
	$.ajax({
		url :  "<?php echo url('Shetuan/update'); ?>?shetuanId=" + shetuanId ,
		type : "get",
		dataType: "json",
		success : function (shetuan, response, status) {
			if (shetuan) {
				$("#shetuan_shetuanId_edit").val(shetuan.shetuanId);
				$("#shetuan_shetuanName_edit").val(shetuan.shetuanName);
				$("#shetuan_shetuanPhoto_edit").val(shetuan.shetuanPhoto);
				$("#shetuan_shetuanPhotoImg").attr("src", "__PUBLIC__/" + shetuan.shetuanPhoto);
				$.ajax({
					url: "<?php echo url('Yxzy/listAll'); ?>",
					type: "get",
					dataType: "json",
					success: function(yxzys,response,status) { 
						$("#shetuan_yxzyObj_yxzyId_edit").empty();
						var html="";
		        		$(yxzys).each(function(i,yxzy){
		        			html += "<option value='" + yxzy.yxzyId + "'>" + yxzy.yxzyName + "</option>";
		        		});
		        		$("#shetuan_yxzyObj_yxzyId_edit").html(html);
		        		$("#shetuan_yxzyObj_yxzyId_edit").val(shetuan.yxzyObj);
					}
				});
				$("#shetuan_bornDate_edit").val(shetuan.bornDate);
				shetuan_shetuanDesc_edit.setContent(shetuan.shetuanDesc, false);
				$("#shetuan_fuzeren_edit").val(shetuan.fuzeren);
				$("#shetuan_telephone_edit").val(shetuan.telephone);
				$('#shetuanEditDialog').modal('show');
			} else {
				alert("获取信息失败！");
			}
		}
	});
}

/*删除社团信息*/
function shetuanDelete(shetuanId) {
	if(confirm("确认删除这个记录")) {
		$.ajax({
			type : "POST",
			url: "<?php echo url('Shetuan/deletes'); ?>",
			data : {
				shetuanIds : shetuanId,
			},
			dataType: "json",
			success : function (obj) {
				if (obj.success) {
					alert("删除成功");
					$("#shetuanQueryForm").submit();
					//location.href= "<?php echo url('Shetuan/frontlist'); ?>";
				}
				else 
					alert(obj.message);
			},
		});
	}
}

/*ajax方式提交社团信息表单给服务器端修改*/
function ajaxShetuanModify() {
	$.ajax({
		url :  "<?php echo url('Shetuan/update'); ?>",
		type : "post",
		dataType: "json",
		data: new FormData($("#shetuanEditForm")[0]),
		success : function (obj, response, status) {
            if(obj.success){
                alert("信息修改成功！");
                $("#shetuanQueryForm").submit();
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

    /*成立日期组件*/
    $('.shetuan_bornDate_edit').datetimepicker({
    	language:  'zh-CN',  //语言
    	format: 'yyyy-mm-dd',
    	minView: 2,
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

