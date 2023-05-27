$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('shetuan_shetuanDesc_edit');
	var shetuan_shetuanDesc_edit = UE.getEditor('shetuan_shetuanDesc_edit'); //社团简介编辑器
	shetuan_shetuanDesc_edit.addListener("ready", function () {
		 // editor准备好之后才可以使用 
		 ajaxModifyQuery();
	}); 
  function ajaxModifyQuery() {	
	$.ajax({
		url :  backURL + getVisitPath("Shetuan") + "/update",
		type : "get",
		data : {
			shetuanId : $("#shetuan_shetuanId_edit").val(),
		},
		dataType: "json",
		beforeSend : function () {
			$.messager.progress({
				text : "正在获取中...",
			});
		},
		success : function (shetuan, response, status) {
			$.messager.progress("close");
			if (shetuan) { 
				$("#shetuan_shetuanId_edit").val(shetuan.shetuanId);
				$("#shetuan_shetuanId_edit").validatebox({
					required : true,
					missingMessage : "请输入社团id",
					editable: false
				});
				$("#shetuan_shetuanName_edit").val(shetuan.shetuanName);
				$("#shetuan_shetuanName_edit").validatebox({
					required : true,
					missingMessage : "请输入社团名称",
				});
				$("#shetuan_shetuanPhoto").val(shetuan.shetuanPhoto);
				$("#shetuan_shetuanPhotoImg").attr("src", publicURL + shetuan.shetuanPhoto);
				$("#shetuan_yxzyObj_yxzyId_edit").combobox({
					url: backURL + getVisitPath("Yxzy") + "/listAll",
					valueField:"yxzyId",
					textField:"yxzyName",
					panelHeight: "auto",
					editable: false, //不允许手动输入 
					onLoadSuccess: function () { //数据加载完毕事件
						$("#shetuan_yxzyObj_yxzyId_edit").combobox("select", shetuan.yxzyObj);
						//var data = $("#shetuan_yxzyObj_yxzyId_edit").combobox("getData"); 
						//if (data.length > 0) {
							//$("#shetuan_yxzyObj_yxzyId_edit").combobox("select", data[0].yxzyId);
						//}
					}
				});
				$("#shetuan_bornDate_edit").datebox({
					value: shetuan.bornDate,
					required: true,
					showSeconds: true,
				});
				shetuan_shetuanDesc_edit.setContent(shetuan.shetuanDesc);
				$("#shetuan_fuzeren_edit").val(shetuan.fuzeren);
				$("#shetuan_fuzeren_edit").validatebox({
					required : true,
					missingMessage : "请输入负责人",
				});
				$("#shetuan_telephone_edit").val(shetuan.telephone);
				$("#shetuan_telephone_edit").validatebox({
					required : true,
					missingMessage : "请输入联系电话",
				});
			} else {
				$.messager.alert("获取失败！", "未知错误导致失败，请重试！", "warning");
				$(".messager-window").css("z-index",10000);
			}
		}
	});

  }

	$("#shetuanModifyButton").click(function(){ 
		if ($("#shetuanEditForm").form("validate")) {
			$("#shetuanEditForm").form({
			    url: backURL + getVisitPath("Shetuan") + "/update",
			    onSubmit: function(){
					if($("#shetuanEditForm").form("validate"))  {
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
			$("#shetuanEditForm").submit();
		} else {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		}
	});
});
