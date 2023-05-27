<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"C:\xampp\htdocs\phpsystem\public/../application/back\view\yxzy\yxzy_query.html";i:1542887792;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/yxzy.css" />

<div id="yxzy_manage"></div>
<div id="yxzy_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="yxzy_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="yxzy_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="yxzy_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="yxzy_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="yxzy_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="yxzyQueryForm" method="post">
		</form>	
	</div>
</div>

<div id="yxzyEditDiv">
	<form id="yxzyEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">院系专业id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="yxzy_yxzyId_edit" name="yxzy_yxzyId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">院系专业名称:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="yxzy_yxzyName_edit" name="yxzy_yxzyName" style="width:200px" />

			</span>

		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/yxzy/yxzy_manage.js"></script>
