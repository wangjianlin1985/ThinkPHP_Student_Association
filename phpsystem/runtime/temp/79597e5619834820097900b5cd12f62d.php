<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"C:\xampp\htdocs\phpsystem\public/../application/back\view\reply\reply_add.html";i:1542887793;}*/ ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/backcss/reply.css" />
<div id="replyAddDiv">
	<form id="replyAddForm" enctype="multipart/form-data"  method="post">
		<div>
			<span class="label">被回帖子:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="reply_postInfoObj_postInfoId" name="reply.postInfoObj.postInfoId" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">回复内容:</span>
			<span class="inputControl">
				<textarea id="reply_content" name="reply_content" rows="6" cols="80"></textarea>

			</span>

		</div>
		<div>
			<span class="label">回复人:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="reply_userObj_user_name" name="reply.userObj.user_name" style="width: auto"/>
			</span>
		</div>
		<div>
			<span class="label">回复时间:</span>
			<span class="inputControl">
				<input class="textbox" type="text" id="reply_replyTime" name="reply_replyTime" />

			</span>

		</div>
		<div class="operation">
			<a id="replyAddButton" class="easyui-linkbutton">添加</a>
			<a id="replyClearButton" class="easyui-linkbutton">重填</a>
		</div> 
	</form>
</div>
<script> var backURL = "__PUBLIC__/index.php/back/";</script>
<script src="__PUBLIC__/backjs/reply/reply_add.js"></script>
