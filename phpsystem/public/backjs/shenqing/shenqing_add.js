$(function () {
	$("#shenqing_shetuanObj_shetuanId").combobox({
	    url: backURL + getVisitPath("Shetuan") + '/listAll',
	    valueField: "shetuanId",
	    textField: "shetuanName",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#shenqing_shetuanObj_shetuanId").combobox("getData"); 
            if (data.length > 0) {
                $("#shenqing_shetuanObj_shetuanId").combobox("select", data[0].shetuanId);
            }
        }
	});
	$("#shenqing_userObj_user_name").combobox({
	    url: backURL + getVisitPath("UserInfo") + '/listAll',
	    valueField: "user_name",
	    textField: "name",
	    panelHeight: "auto",
        editable: false, //不允许手动输入
        required : true,
        onLoadSuccess: function () { //数据加载完毕事件
            var data = $("#shenqing_userObj_user_name").combobox("getData"); 
            if (data.length > 0) {
                $("#shenqing_userObj_user_name").combobox("select", data[0].user_name);
            }
        }
	});
	$("#shenqing_shenqingTime").datetimebox({
	    required : true, 
	    showSeconds: true,
	    editable: false
	});

	$("#shenqing_shenHe").validatebox({
		required : true, 
		missingMessage : '请输入审核结果',
	});

	//单击添加按钮
	$("#shenqingAddButton").click(function () {
		//验证表单 
		if(!$("#shenqingAddForm").form("validate")) {
			$.messager.alert("错误提示","你输入的信息还有错误！","warning");
			$(".messager-window").css("z-index",10000);
		} else {
			$("#shenqingAddForm").form({
			    url: backURL + getVisitPath("Shenqing") + "/add",
			    onSubmit: function(){
					if($("#shenqingAddForm").form("validate"))  { 
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
                        $("#shenqingAddForm").form("clear");
                    }else{
                        $.messager.alert("消息",obj.message);
                        $(".messager-window").css("z-index",10000);
                    }
			    }
			});
			//提交表单
			$("#shenqingAddForm").submit();
		}
	});

	//单击清空按钮
	$("#shenqingClearButton").click(function () { 
		$("#shenqingAddForm").form("clear"); 
	});
});
