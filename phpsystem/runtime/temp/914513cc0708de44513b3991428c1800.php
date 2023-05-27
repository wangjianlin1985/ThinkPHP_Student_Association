<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"C:\xampp\htdocs\phpsystem\public/../application/back\view\postInfo\postInfo_add.html";i:1542887792;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/postInfo.css" />
<div id="postInfoAddDiv">
	<form id="postInfoAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">帖子标题:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="postInfo_title" name="postInfo_title" style="width:200px" />

			</span>

		</div>
		<div>
			<span class="label">帖子内容:</span>
			<span class="inputControl">
                <textarea name="postInfo_content" id="postInfo_content" style="width:750px;height:500px;"></textarea>
			</span>

		</div>
		<div>
			<span class="label">浏览量:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="postInfo_hitNum" name="postInfo_hitNum" style="width:80px" />

			</span>

		</div>
		<div>
			<span class="label">发帖人:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="postInfo_userObj_user_name" name="postInfo.userObj.user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">发帖时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="postInfo_addTime" name="postInfo_addTime" />

			</span>

		</div>
		<div class="operation">
			<a id="postInfoAddButton" class="easyui-linkbutton">添加</a>
			<a id="postInfoClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/postInfo/postInfo_add.js"></script>
