var shenqing_manage_tool = null; 
$(function () { 
	initShenqingManageTool(); //建立Shenqing管理对象
	shenqing_manage_tool.init(); //如果需要通过下拉框查询，首先初始化下拉框的值
	$("#shenqing_manage").datagrid({
		url : backURL + getVisitPath("Shenqing") + '/backList',
		fit : true,
		fitColumns : true,
		striped : true,
		rownumbers : true,
		border : false,
		pagination : true,
		pageSize : 5,
		pageList : [5, 10, 15, 20, 25],
		pageNumber : 1,
		sortName : "shenqingId",
		sortOrder : "desc",
		toolbar : "#shenqing_manage_tool",
		columns : [[
			{
				field : "shenqingId",
				title : "申请id",
				width : 70,
			},
			{
				field : "shetuanObj",
				title : "申请的社团",
				width : 140,
			},
			{
				field : "userObj",
				title : "申请用户",
				width : 140,
			},
			{
				field : "shenqingTime",
				title : "申请时间",
				width : 140,
			},
			{
				field : "shenHe",
				title : "审核结果",
				width : 140,
			},
		]],
	});

	$("#shenqingEditDiv").dialog({
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
				if ($("#shenqingEditForm").form("validate")) {
					//验证表单 
					if(!$("#shenqingEditForm").form("validate")) {
						$.messager.alert("错误提示","你输入的信息还有错误！","warning");
					} else {
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
						    	console.log(data);
			                	var obj = jQuery.parseJSON(data);
			                    if(obj.success){
			                        $.messager.alert("消息","信息修改成功！");
			                        $("#shenqingEditDiv").dialog("close");
			                        shenqing_manage_tool.reload();
			                    }else{
			                        $.messager.alert("消息",obj.message);
			                    } 
						    }
						});
						//提交表单
						$("#shenqingEditForm").submit();
					}
				}
			},
		},{
			text : "取消",
			iconCls : "icon-redo",
			handler : function () {
				$("#shenqingEditDiv").dialog("close");
				$("#shenqingEditForm").form("reset"); 
			},
		}],
	});
});

function initShenqingManageTool() {
	shenqing_manage_tool = {
		init: function() {
			$.ajax({
				url : backURL + getVisitPath("Shetuan") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#shetuanObj_shetuanId_query").combobox({ 
					    valueField:"shetuanId",
					    textField:"shetuanName",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{shetuanId:0,shetuanName:"不限制"});
					$("#shetuanObj_shetuanId_query").combobox("loadData",data); 
				}
			});
			$.ajax({
				url : backURL + getVisitPath("UserInfo") + "/listAll",
				type : "post",
				dataType: "json",
				success : function (data, response, status) {
					$("#userObj_user_name_query").combobox({ 
					    valueField:"user_name",
					    textField:"name",
					    panelHeight: "200px",
				        editable: false, //不允许手动输入 
					});
					data.splice(0,0,{user_name:"",name:"不限制"});
					$("#userObj_user_name_query").combobox("loadData",data); 
				}
			});
		},
		reload : function () {
			$("#shenqing_manage").datagrid("reload");
		},
		redo : function () {
			$("#shenqing_manage").datagrid("unselectAll");
		},
		search: function() {
			var queryParams = $("#shenqing_manage").datagrid("options").queryParams;
			queryParams["shetuanObj.shetuanId"] = $("#shetuanObj_shetuanId_query").combobox("getValue");
			queryParams["userObj.user_name"] = $("#userObj_user_name_query").combobox("getValue");
			queryParams["shenqingTime"] = $("#shenqingTime").datebox("getValue"); 
			queryParams["shenHe"] = $("#shenHe").val();
			$("#shenqing_manage").datagrid("options").queryParams=queryParams; 
			$("#shenqing_manage").datagrid("load");
		},
		exportExcel: function() {
			$("#shenqingQueryForm").form({
			    url: backURL + getVisitPath("Shenqing") + "/outToExcel",
			});
			//提交表单
			$("#shenqingQueryForm").submit();
		},
		remove : function () {
			var rows = $("#shenqing_manage").datagrid("getSelections");
			if (rows.length > 0) {
				$.messager.confirm("确定操作", "您正在要删除所选的记录吗？", function (flag) {
					if (flag) {
						var shenqingIds = [];
						for (var i = 0; i < rows.length; i ++) {
							shenqingIds.push(rows[i].shenqingId);
						}
						$.ajax({
							type : "POST",
							url :  backURL + getVisitPath("Shenqing") + "/deletes",
							data : {
								shenqingIds : shenqingIds.join(","),
							},
							dataType: "json",
							beforeSend : function () {
								$("#shenqing_manage").datagrid("loading");
							},
							success : function (data) {
								if (data.success) {
									$("#shenqing_manage").datagrid("loaded");
									$("#shenqing_manage").datagrid("load");
									$("#shenqing_manage").datagrid("unselectAll");
									$.messager.show({
										title : "提示",
										msg : data.message
									});
								} else {
									$("#shenqing_manage").datagrid("loaded");
									$("#shenqing_manage").datagrid("load");
									$("#shenqing_manage").datagrid("unselectAll");
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
			var rows = $("#shenqing_manage").datagrid("getSelections");
			if (rows.length > 1) {
				$.messager.alert("警告操作！", "编辑记录只能选定一条数据！", "warning");
			} else if (rows.length == 1) {
				$.ajax({
					url : backURL + getVisitPath("Shenqing") + "/update",
					type : "get",
					data : {
						shenqingId : rows[0].shenqingId,
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
							$("#shenqingEditDiv").dialog("open");
							$("#shenqing_shenqingId_edit").val(shenqing.shenqingId);
							$("#shenqing_shenqingId_edit").validatebox({
								required : true,
								missingMessage : "请输入申请id",
								editable: false
							});
							$("#shenqing_shetuanObj_shetuanId_edit").combobox({
							    url: backURL + getVisitPath("Shetuan") + "/listAll",
							    dataType: "json",
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
							    dataType: "json",
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
						}
					}
				});
			} else if (rows.length == 0) {
				$.messager.alert("警告操作！", "编辑记录至少选定一条数据！", "warning");
			}
		},
	};
}
