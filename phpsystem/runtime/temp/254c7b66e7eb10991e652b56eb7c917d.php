<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"C:\xampp\htdocs\phpsystem\public/../application/back\view\yxzy\yxzy_add.html";i:1542887792;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/yxzy.css" />
<div id="yxzyAddDiv">
	<form id="yxzyAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">院系专业名称:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="yxzy_yxzyName" name="yxzy_yxzyName" style="width:200px" />

			</span>

		</div>
		<div class="operation">
			<a id="yxzyAddButton" class="easyui-linkbutton">添加</a>
			<a id="yxzyClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/yxzy/yxzy_add.js"></script>
