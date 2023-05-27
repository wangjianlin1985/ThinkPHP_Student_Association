<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"C:\xampp\htdocs\phpsystem\public/../application/back\view\shetuan\shetuan_add.html";i:1542887791;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/shetuan.css" />
<div id="shetuanAddDiv">
	<form id="shetuanAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">社团名称:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_shetuanName" name="shetuan_shetuanName" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">社团图片:</span>
			<span class="inputControl">
				<input id="shetuanPhotoFile" name="shetuanPhotoFile" type="file" size="50" />
			</span>
		</div>
		<div>
			<span class="label">所在院系专业:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_yxzyObj_yxzyId" name="shetuan.yxzyObj.yxzyId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">成立日期:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_bornDate" name="shetuan_bornDate" />

			</span>

		</div>
		<div>
			<span class="label">社团简介:</span>
			<span class="inputControl">
                <textarea name="shetuan_shetuanDesc" id="shetuan_shetuanDesc" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div>
			<span class="label">负责人:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_fuzeren" name="shetuan_fuzeren" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">联系电话:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="shetuan_telephone" name="shetuan_telephone" style="width:200px" />

			</span>

		</div>
		<div class="operation">
			<a id="shetuanAddButton" class="easyui-linkbutton">添加</a>
			<a id="shetuanClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/shetuan/shetuan_add.js"></script>
