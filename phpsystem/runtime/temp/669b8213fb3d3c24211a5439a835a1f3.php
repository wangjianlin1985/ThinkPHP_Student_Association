<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"C:\xampp\htdocs\phpsystem\public/../application/back\view\shenqing\shenqing_query.html";i:1543588655;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/shenqing.css" />

<div id="shenqing_manage"></div>
<div id="shenqing_manage_tool" style="padding:5px;">
	<div style="margin-bottom:5px;">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="shenqing_manage_tool.edit();">审核</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="shenqing_manage_tool.remove();">删除</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="shenqing_manage_tool.reload();">刷新</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="shenqing_manage_tool.redo();">取消选择</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="shenqing_manage_tool.exportExcel();">导出到excel</a>
	</div>
	<div style="padding:0 0 0 7px;color:#333;">
		<form id="shenqingQueryForm" method="post">
			申请的社团：<input class="textbox" type="text" id="shetuanObj_shetuanId_query" name="shetuanObj.shetuanId" style="width: auto"/>
			申请用户：<input class="textbox" type="text" id="userObj_user_name_query" name="userObj.user_name" style="width: auto"/>
			申请时间：<input type="text" id="shenqingTime" name="shenqingTime" class="easyui-datebox" editable="false" style="width:100px">
			审核结果：<input type="text" class="textbox" id="shenHe" name="shenHe" style="width:110px" />
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="shenqing_manage_tool.search();">查询</a>
		</form>	
	</div>
</div>

<div id="shenqingEditDiv">
	<form id="shenqingEditForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">申请id:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shenqing_shenqingId_edit" name="shenqing_shenqingId" style="width:200px" />
			</span>
		</div>
		<div>
			<span class="label">申请的社团:</span>
			<span class="inputControl">
				<input class="textbox"  id="shenqing_shetuanObj_shetuanId_edit" name="shenqing_shetuanObj_shetuanId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">申请用户:</span>
			<span class="inputControl">
				<input class="textbox"  id="shenqing_userObj_user_name_edit" name="shenqing_userObj_user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">申请时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shenqing_shenqingTime_edit" name="shenqing_shenqingTime" />

			</span>

		</div>
		<div>
			<span class="label">审核结果:</span>
			<span class="inputControl">
				<select id="shenqing_shenHe_edit" name="shenqing_shenHe">
					<option value="待审核">待审核</option>
					<option value="审核通过">审核通过</option>
					<option value="审核拒绝">审核拒绝</option>
				</select>
			</span>

		</div>
		<div>
			<span class="label">备注:</span>
			<span class="inputControl">
				<textarea id="shenqing_shenqingMemo_edit" name="shenqing_shenqingMemo" rows="8" cols="60"></textarea>

			</span>

		</div>
	</form>
</div>
<script>
	var publicURL = "__PUBLIC__/";
	var backURL = "__PUBLIC__/index.php/back/";
</script>
<script type="text/javascript" src="__PUBLIC__/backjs/shenqing/shenqing_manage.js"></script>
