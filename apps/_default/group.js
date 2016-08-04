var GroupClass = function () {
	$.extend(this, new FGTA_uiBase());
	var ui = this;


	this._LastPageNumber = 0;
	this._LastPageSize = 0;
	this.Init = function () {
		ui.NS = '_default';
		ui.CL = 'group';
		ui.SetToolboxButtonState(0);
		ui.tabMain.tabs('enableTab', 'List');
		ui.tabMain.tabs('disableTab', 'Data');
		ui.formMain.form({
			onChange: function(target) {
				ui.Editor.setDataChanges();
			}
		});
		_btnLoad_Click(ui,0,0);
	};
}




function _dgv_USER_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_USER.editIndex != index){
		if (ui.endEditing(ui.dgv_USER)){
			ui.dgv_USER.datagrid('beginEdit', index);
			ui.dgv_USER.editIndex = index;
		} else {
	        ui.dgv_USER.datagrid('selectRow', ui.dgv_USER.editIndex);
	    }
	}
}

function _dgv_PROGRAM_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_PROGRAM.editIndex != index){
		if (ui.endEditing(ui.dgv_PROGRAM)){
			ui.dgv_PROGRAM.datagrid('beginEdit', index);
			ui.dgv_PROGRAM.editIndex = index;
		} else {
	        ui.dgv_PROGRAM.datagrid('selectRow', ui.dgv_PROGRAM.editIndex);
	    }
	}
}




function _btnNew_Click(ui) {
	ui.Editor.new();
}

function _btnEdit_Click(ui) {
	ui.btnEdit_Toggle();
}

function _btnSave_Click(ui) {
	ui.Editor.endEdit();
	ui.DataSave({
		H: {
			GROUP_ID: ui.Editor.obj_txt_GROUP_ID.textbox('getValue'),
			GROUP_NAME: ui.Editor.obj_txt_GROUP_NAME.textbox('getValue'),
			GROUP_DESCRIPTION: ui.Editor.obj_txt_GROUP_DESCRIPTION.textbox('getValue'),
			GROUP_ISDISABLED: (ui.Editor.obj_chk_GROUP_ISDISABLED.is(':checked')) ? 1 : 0,
			GROUP_ISSYSTEM: (ui.Editor.obj_chk_GROUP_ISSYSTEM.is(':checked')) ? 1 : 0,
			__STATE: ui.Editor.getFormDataState(),
		},
		D: {
			USER: ui.dgv_USER.datagrid('getChanges'),
			PROGRAM: ui.dgv_PROGRAM.datagrid('getChanges')
		}
	});
}

function _btnDelete_Click(ui) {
	var param = {
		id: ui.Editor.obj_txt_GROUP_ID.textbox('getValue')
	}

	ui.DataDelete(param);
}

function _btnLoad_Click(ui, pageNumber, pageSize) {
	ui.DataLoad(pageNumber, pageSize);
}

function _btnRowadd_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {
        case "USER" :
            if (ui.endEditing(ui.dgv_USER)){
				ui.dgv_USER.dialogShow();
            }
            break;

        case "PROGRAM" :
            if (ui.endEditing(ui.dgv_PROGRAM)){
				ui.dgv_PROGRAM.dialogShow();
            }
            break;
	}
}

function _btnRowremove_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {
        case "USER" :
            ui.removeRow(ui.dgv_USER);
            break;
        case "PROGRAM" :
            ui.removeRow(ui.dgv_PROGRAM);
            break;
	}
}


function _open_data(ui, id) {
	ui.DataOpen({id, id},
		function(data) {

			ui.Editor.obj_chk_GROUP_ISSYSTEM.attr("isdisabled", "true");

			ui.Editor.setValue(ui.Editor.obj_txt_GROUP_ID, data.GROUP_ID);
			ui.Editor.setValue(ui.Editor.obj_txt_GROUP_NAME, data.GROUP_NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_GROUP_DESCRIPTION, data.GROUP_DESCRIPTION);
			ui.Editor.setValue(ui.Editor.obj_chk_GROUP_ISDISABLED, data.GROUP_ISDISABLED==1 ? true : false);
			ui.Editor.setValue(ui.Editor.obj_chk_GROUP_ISSYSTEM, data.GROUP_ISSYSTEM==1 ? true : false);

			ui.dgv_USER.datagrid('loadData', data.DETIL.USER.records);
			ui.dgv_USER.maxline = data.DETIL.USER.maxline;

			ui.dgv_PROGRAM.datagrid('loadData', data.DETIL.PROGRAM.records);
			ui.dgv_PROGRAM.maxline = data.DETIL.PROGRAM.maxline;

			ui.btnEdit.linkbutton('enable');
		}
	);
}
