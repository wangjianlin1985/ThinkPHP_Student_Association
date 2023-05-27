$(function () {
	$.ajax({
		url :  backURL + getVisitPath("Reply") + "/update",
		type : "get",
		data : {
			replyId : $("#reply_replyId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (reply, response, status) {
			$.messager.progress("close");
			if (reply) { 
				$("#reply_replyId_edit").val(reply.replyId);
				$("#reply_replyId_edit").validatebox({
					required : true,
					missingMessage : "请输入回复id",
					editable: false
				});
				$("#reply_postInfoObj_postInfoId_edit").combobox({
					url: backURL + getVisitPath("PostInfo") + "/listAll",
					valueField:"postInfoId",
					textField:"title",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#reply_postInfoObj_postInfoId_edit").combobox("select", reply.postInfoObj);
						//var data = $("#reply_postInfoObj_postInfoId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#reply_postInfoObj_postInfoId_edit").combobox("select", data[0].postInfoId);
						//}
					}
				});
				$("#reply_content_edit").val(reply.content);
				$("#reply_content_edit").validatebox({
					required : true,
					missingMessage : "请输入回复内容",
				});
				$("#reply_userObj_user_name_edit").combobox({
					url: backURL + getVisitPath("UserInfo") + "/listAll",
					valueField:"user_name",
					textField:"name",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#reply_userObj_user_name_edit").combobox("select", reply.userObj);
						//var data = $("#reply_userObj_user_name_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#reply_userObj_user_name_edit").combobox("select", data[0].user_name);
						//}
					}
				});
				$("#reply_replyTime_edit").datetimebox({
					value: reply.replyTime,
					required: true,
					showSeconds: true,
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#replyModifyButton").click(function(){ 
		if ($("#replyEditForm").form("validate")) {
			$("#replyEditForm").form({
			    url: backURL + getVisitPath("Reply") + "/update",
			    onSubmit: function(){
					if($("#replyEditForm").form("validate"))  {
	                	$.messager.progress({
							text : "正在提交数据中...",
						});
	                	return true;
	                } else {
	                    return false;
	                }
			    },
			    success:function(data){
			    	$.messager.progress("close");
                	var obj = jQuery.parseJSON(data);
                    if(obj.success){
                        $.messager.alert("消息","信息修改成功！");
                        $(".messager-window").css("z-index",10000);
                        //location.href="frontlist";
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    } 
			    }
			});
			//提交表单
			$("#replyEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
