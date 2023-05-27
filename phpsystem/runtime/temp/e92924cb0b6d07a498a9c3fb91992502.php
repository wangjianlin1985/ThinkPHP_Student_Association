<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"C:\xampp\htdocs\phpsystem\public/../application/back\view\shenqing\shenqing_add.html";i:1542887792;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/shenqing.css" />
<div id="shenqingAddDiv">
	<form id="shenqingAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">申请的社团:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shenqing_shetuanObj_shetuanId" name="shenqing.shetuanObj.shetuanId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">申请用户:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shenqing_userObj_user_name" name="shenqing.userObj.user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">申请时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shenqing_shenqingTime" name="shenqing_shenqingTime" />

			</span>

		</div>
		<div>
			<span class="label">审核结果:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shenqing_shenHe" name="shenqing_shenHe" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">备注:</span>
			<span class="inputControl">
				<textarea id="shenqing_shenqingMemo" name="shenqing_shenqingMemo" rows="6" cols="80"></textarea>

			</span>

		</div>
		<div class="operation">
			<a id="shenqingAddButton" class="easyui-linkbutton">添加</a>
			<a id="shenqingClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/shenqing/shenqing_add.js"></script>
