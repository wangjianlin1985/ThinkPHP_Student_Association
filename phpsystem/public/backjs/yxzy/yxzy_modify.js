$(function () {
	$.ajax({
		url :  backURL + getVisitPath("Yxzy") + "/update",
		type : "get",
		data : {
			yxzyId : $("#yxzy_yxzyId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (yxzy, response, status) {
			$.messager.progress("close");
			if (yxzy) { 
				$("#yxzy_yxzyId_edit").val(yxzy.yxzyId);
				$("#yxzy_yxzyId_edit").validatebox({
					required : true,
					missingMessage : "请输入院系专业id",
					editable: false
				});
				$("#yxzy_yxzyName_edit").val(yxzy.yxzyName);
				$("#yxzy_yxzyName_edit").validatebox({
					required : true,
					missingMessage : "请输入院系专业名称",
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#yxzyModifyButton").click(function(){ 
		if ($("#yxzyEditForm").form("validate")) {
			$("#yxzyEditForm").form({
			    url: backURL + getVisitPath("Yxzy") + "/update",
			    onSubmit: function(){
					if($("#yxzyEditForm").form("validate"))  {
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
			$("#yxzyEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
