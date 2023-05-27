$(function () {
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	UE.delEditor('shetuan_shetuanDesc');
	var shetuan_shetuanDesc_editor = UE.getEditor('shetuan_shetuanDesc'); //社团简介编辑框
	$("#shetuan_shetuanName").validatebox({
		required : true, 
		missingMessage : '请输入社团名称',
	});

	$("#shetuan_yxzyObj_yxzyId").combobox({
	    url: backURL + getVisitPath("Yxzy") + '/listAll',
	    valueField: "yxzyId",
	    textField: "yxzyName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#shetuan_yxzyObj_yxzyId").combobox("getData"); 
            if (data.length > 0) {
                $("#shetuan_yxzyObj_yxzyId").combobox("select", data[0].yxzyId);
            }
        }
	});
	$("#shetuan_bornDate").datebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	$("#shetuan_fuzeren").validatebox({
		required : true, 
		missingMessage : '请输入负责人',
	});

	$("#shetuan_telephone").validatebox({
		required : true, 
		missingMessage : '请输入联系电话',
	});

	//单击添加按钮
	$("#shetuanAddButton").click(function () {
		if(shetuan_shetuanDesc_editor.getContent() == "") {
			alert("请输入社团简介");
			return;
		}
		//验证表单 
		if(!$("#shetuanAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#shetuanAddForm").form({
			    url: backURL + getVisitPath("Shetuan") + "/add",
			    onSubmit: function(){
					if($("#shetuanAddForm").form("validate"))  { 
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
                    //此处data={"Success":true}是字符串
                	var obj = jQuery.parseJSON(data); 
                    if(obj.success){ 
                        $.messager.alert("消息","保存成功！");
                        $(".messager-window").css("z-index",10000);
                        $("#shetuanAddForm").form("clear");
                        shetuan_shetuanDesc_editor.setContent("");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#shetuanAddForm").submit();
		}
	});

	//单击清空按钮
	$("#shetuanClearButton").click(function () { 
		$("#shetuanAddForm").form("clear"); 
	});
});
