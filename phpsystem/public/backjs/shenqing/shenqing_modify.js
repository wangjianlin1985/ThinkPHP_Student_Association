$(function () {
	$.ajax({
		url :  backURL + getVisitPath("Shenqing") + "/update",
		type : "get",
		data : {
			shenqingId : $("#shenqing_shenqingId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (shenqing, response, status) {
			$.messager.progress("close");
			if (shenqing) { 
				$("#shenqing_shenqingId_edit").val(shenqing.shenqingId);
				$("#shenqing_shenqingId_edit").validatebox({
					required : true,
					missingMessage : "请输入申请id",
					editable: false
				});
				$("#shenqing_shetuanObj_shetuanId_edit").combobox({
					url: backURL + getVisitPath("Shetuan") + "/listAll",
					valueField:"shetuanId",
					textField:"shetuanName",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#shenqing_shetuanObj_shetuanId_edit").combobox("select", shenqing.shetuanObj);
						//var data = $("#shenqing_shetuanObj_shetuanId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#shenqing_shetuanObj_shetuanId_edit").combobox("select", data[0].shetuanId);
						//}
					}
				});
				$("#shenqing_userObj_user_name_edit").combobox({
					url: backURL + getVisitPath("UserInfo") + "/listAll",
					valueField:"user_name",
					textField:"name",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#shenqing_userObj_user_name_edit").combobox("select", shenqing.userObj);
						//var data = $("#shenqing_userObj_user_name_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#shenqing_userObj_user_name_edit").combobox("select", data[0].user_name);
						//}
					}
				});
				$("#shenqing_shenqingTime_edit").datetimebox({
					value: shenqing.shenqingTime,
					required: true,
					showSeconds: true,
				});
				$("#shenqing_shenHe_edit").val(shenqing.shenHe);
				$("#shenqing_shenHe_edit").validatebox({
					required : true,
					missingMessage : "请输入审核结果",
				});
				$("#shenqing_shenqingMemo_edit").val(shenqing.shenqingMemo);
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

	$("#shenqingModifyButton").click(function(){ 
		if ($("#shenqingEditForm").form("validate")) {
			$("#shenqingEditForm").form({
			    url: backURL + getVisitPath("Shenqing") + "/update",
			    onSubmit: function(){
					if($("#shenqingEditForm").form("validate"))  {
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
			$("#shenqingEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
