var yxzy_manage_tool = null; 
$(function () { 
	initYxzyManageTool(); //建立Yxzy管理对象
	yxzy_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#yxzy_manage").datagrid({
		url : backURL + getVisitPath("Yxzy") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "yxzyId",
		sortOrder : "desc",
		toolbar : "#yxzy_manage_tool",
		columns : [[
			{
				field : "yxzyId",
				title : "院系专业id",
				width : 70,
			},
			{
				field : "yxzyName",
				title : "院系专业名称",
				width : 140,
			},
		]],
	});

	$("#yxzyEditDiv").dialog({
		title : "修改管理",
		top: "50px",
		width : 700,
		height : 515,
		modal : true,
		closed : true,
		iconCls : "icon-edit-new",
		buttons : [{
			text : "提交",
			iconCls : "icon-edit-new",
			handler : function () {
				if ($("#yxzyEditForm").form("validate")) {
					//验证表单 
					if(!$("#yxzyEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
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
						    	console.log(data);
			                	var obj = jQuery.parseJSON(data);
			                    if(obj.success){
			                        $.messager.alert("消息","信息修改成功！");
			                        $("#yxzyEditDiv").dialog("close");
			                        yxzy_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#yxzyEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#yxzyEditDiv").dialog("close");
				$("#yxzyEditForm").form("reset"); 
			},
		}],
	});
});

function initYxzyManageTool() {
	yxzy_manage_tool = {
		init: function() {
		},
		reload : function () {
			$("#yxzy_manage").datagrid("reload");
		},
		redo : function () {
			$("#yxzy_manage").datagrid("unselectAll");
		},
		search: function() {
			$("#yxzy_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#yxzyQueryForm").form({
			    url: backURL + getVisitPath("Yxzy") + "/outToExcel",
			});
			//提交表单
			$("#yxzyQueryForm").submit();
		},
		remove : function () {
			var rows = $("#yxzy_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var yxzyIds = [];
						for (var i = 0; i < rows.length; i ++) {
							yxzyIds.push(rows[i].yxzyId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Yxzy") + "/deletes",
							data : {
								yxzyIds : yxzyIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#yxzy_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#yxzy_manage").datagrid("loaded");
									$("#yxzy_manage").datagrid("load");
									$("#yxzy_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#yxzy_manage").datagrid("loaded");
									$("#yxzy_manage").datagrid("load");
									$("#yxzy_manage").datagrid("unselectAll");
									$.messager.alert("消息",data.message);
								}
							},
						});
					}
				});
			} else {
				$.messager.alert("提示", "请选择要删除的记录！", "info");
			}
		},
		edit : function () {
			var rows = $("#yxzy_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Yxzy") + "/update",
					type : "get",
					data : {
						yxzyId : rows[0].yxzyId,
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
							$("#yxzyEditDiv").dialog("open");
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
						}
					}
				});
			} else if (rows.length == 0) {
				$.messager.alert("警告操作！", "编辑记录至少选定一条数据！", "warning");
			}
		},
	};
}
