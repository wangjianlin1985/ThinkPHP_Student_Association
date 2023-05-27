var shetuan_manage_tool = null; 
$(function () { 
	initShetuanManageTool(); //建立Shetuan管理对象
	shetuan_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#shetuan_manage").datagrid({
		url : backURL + getVisitPath("Shetuan") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "shetuanId",
		sortOrder : "desc",
		toolbar : "#shetuan_manage_tool",
		columns : [[
			{
				field : "shetuanId",
				title : "社团id",
				width : 70,
			},
			{
				field : "shetuanName",
				title : "社团名称",
				width : 140,
			},
			{
				field : "shetuanPhoto",
				title : "社团图片",
				width : "70px",
				height: "65px",
				formatter: function(val,row) {
					return "<img src='" + publicURL + val + "' width='65px' height='55px' />";
				}
 			},
			{
				field : "yxzyObj",
				title : "所在院系专业",
				width : 140,
			},
			{
				field : "bornDate",
				title : "成立日期",
				width : 140,
			},
			{
				field : "fuzeren",
				title : "负责人",
				width : 140,
			},
			{
				field : "telephone",
				title : "联系电话",
				width : 140,
			},
		]],
	});

	$("#shetuanEditDiv").dialog({
		title : "修改管理",
		top: "10px",
		width : 1000,
		height : 600,
		modal : true,
		closed : true,
		iconCls : "icon-edit-new",
		buttons : [{
			text : "提交",
			iconCls : "icon-edit-new",
			handler : function () {
				if ($("#shetuanEditForm").form("validate")) {
					//验证表单 
					if(!$("#shetuanEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
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
						    	console.log(data);
			                	var obj = jQuery.parseJSON(data);
			                    if(obj.success){
			                        $.messager.alert("消息","信息修改成功！");
			                        $("#shetuanEditDiv").dialog("close");
			                        shetuan_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#shetuanEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#shetuanEditDiv").dialog("close");
				$("#shetuanEditForm").form("reset"); 
			},
		}],
	});
});

function initShetuanManageTool() {
	shetuan_manage_tool = {
		init: function() {
			$.ajax({
				url : backURL + getVisitPath("Yxzy") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#yxzyObj_yxzyId_query").combobox({ 
					    valueField:"yxzyId",
					    textField:"yxzyName",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{yxzyId:0,yxzyName:"不限制"});
					$("#yxzyObj_yxzyId_query").combobox("loadData",data); 
				}
			});
		},
		reload : function () {
			$("#shetuan_manage").datagrid("reload");
		},
		redo : function () {
			$("#shetuan_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#shetuan_manage").datagrid("options").queryParams;
			queryParams["shetuanName"] = $("#shetuanName").val();
			queryParams["yxzyObj.yxzyId"] = $("#yxzyObj_yxzyId_query").combobox("getValue");
			queryParams["bornDate"] = $("#bornDate").datebox("getValue"); 
			queryParams["telephone"] = $("#telephone").val();
			$("#shetuan_manage").datagrid("options").queryParams=queryParams; 
			$("#shetuan_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#shetuanQueryForm").form({
			    url: backURL + getVisitPath("Shetuan") + "/outToExcel",
			});
			//提交表单
			$("#shetuanQueryForm").submit();
		},
		remove : function () {
			var rows = $("#shetuan_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var shetuanIds = [];
						for (var i = 0; i < rows.length; i ++) {
							shetuanIds.push(rows[i].shetuanId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Shetuan") + "/deletes",
							data : {
								shetuanIds : shetuanIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#shetuan_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#shetuan_manage").datagrid("loaded");
									$("#shetuan_manage").datagrid("load");
									$("#shetuan_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#shetuan_manage").datagrid("loaded");
									$("#shetuan_manage").datagrid("load");
									$("#shetuan_manage").datagrid("unselectAll");
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
			var rows = $("#shetuan_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Shetuan") + "/update",
					type : "get",
					data : {
						shetuanId : rows[0].shetuanId,
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
							$("#shetuanEditDiv").dialog("open");
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
							    dataType: "json",
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
							shetuan_shetuanDesc_editor.setContent(shetuan.shetuanDesc, false);
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
						}
					}
				});
			} else if (rows.length == 0) {
				$.messager.alert("警告操作！", "编辑记录至少选定一条数据！", "warning");
			}
		},
	};
}
