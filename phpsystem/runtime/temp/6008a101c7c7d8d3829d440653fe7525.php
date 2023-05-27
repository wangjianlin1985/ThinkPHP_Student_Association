<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"C:\xampp\htdocs\phpsystem\public/../application/back\view\shetuan\shetuan_query.html";i:1542887791;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/shetuan.css" />

<div id="shetuan_manage"></div>
<div id="shetuan_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="shetuan_manage_tool.edit();">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="shetuan_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="shetuan_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="shetuan_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="shetuan_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="shetuanQueryForm" method="post">
			社团名称：<input type="text" class="textbox" id="shetuanName" name="shetuanName" style="width:110px" />
			所在院系专业：<input class="textbox" type="text" id="yxzyObj_yxzyId_query" name="yxzyObj.yxzyId" style="width: auto"/>
			成立日期：<input type="text" id="bornDate" name="bornDate" class="easyui-datebox" editable="false" style="width:100px">
			联系电话：<input type="text" class="textbox" id="telephone" name="telephone" style="width:110px" />
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="shetuan_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="shetuanEditDiv">
	<form id="shetuanEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">社团id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_shetuanId_edit" name="shetuan_shetuanId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">社团名称:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_shetuanName_edit" name="shetuan_shetuanName" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">社团图片:</span>
			<span class="inputControl">
				<img id="shetuan_shetuanPhotoImg" width="200px" border="0px"/><br/>
    			<input type="hidden" id="shetuan_shetuanPhoto" name="shetuan_shetuanPhoto"/>
				<input id="shetuanPhotoFile" name="shetuanPhotoFile" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">所在院系专业:</span>
			<span class="inputControl">
				<input class="textbox"  id="shetuan_yxzyObj_yxzyId_edit" name="shetuan_yxzyObj_yxzyId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">成立日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_bornDate_edit" name="shetuan_bornDate" />

			</span>

		</div>
		<div>
			<span class="label">社团简介:</span>
			<span class="inputControl">
                <textarea name="shetuan_shetuanDesc" id="shetuan_shetuanDesc_edit" style="width:100%;height:500px;"></textarea>

			</span>

		</div>
		<div>
			<span class="label">负责人:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_fuzeren_edit" name="shetuan_fuzeren" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">联系电话:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_telephone_edit" name="shetuan_telephone" style="width:200px" />

			</span>

		</div>
	</form>
</div>
<script>
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
var shetuan_shetuanDesc_editor = UE.getEditor('shetuan_shetuanDesc_edit'); //社团简介编辑器
</script>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/shetuan/shetuan_manage.js"></script>
