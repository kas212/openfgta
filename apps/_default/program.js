var ProgramClass = function () {
	$.extend(this, new FGTA_uiBase());
	var ui = this;


	this._LastPageNumber = 0;
	this._LastPageSize = 0;
	this.Init = function () {
		ui.NS = '_default';
		ui.CL = 'program';
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




function _dgv_GROUP_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_GROUP.editIndex != index){
		if (ui.endEditing(ui.dgv_GROUP)){
			ui.dgv_GROUP.datagrid('beginEdit', index);
			ui.dgv_GROUP.editIndex = index;
		} else {
	        ui.dgv_GROUP.datagrid('selectRow', ui.dgv_GROUP.editIndex);
	    }
	}
}




function _btnNew_Click(ui) {
	ui.Editor.new(function() {
		ui.Editor.setValue(ui.Editor.obj_chk_PROGRAM_ISSINGLEINSTANCE, true);
		ui.Editor.setValue(ui.Editor.obj_chk_PROGRAM_ISWEBENABLED, true);
		ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_TYPE, 'MST', 'Master');
	});
}

function _btnEdit_Click(ui) {
	ui.btnEdit_Toggle();
}

function _btnSave_Click(ui) {
	ui.Editor.endEdit();
	ui.DataSave({
		H: {
			PROGRAM_ID: ui.Editor.obj_txt_PROGRAM_ID.textbox('getValue'),
			PROGRAM_NAME: ui.Editor.obj_txt_PROGRAM_NAME.textbox('getValue'),
			PROGRAM_TYPE: ui.Editor.obj_txt_PROGRAM_TYPE.textbox('getValue'),
			PROGRAM_ICON: ui.Editor.obj_txt_PROGRAM_ICON.textbox('getValue'),
			PROGRAM_PATH: ui.Editor.obj_txt_PROGRAM_PATH.textbox('getValue'),
			PROGRAM_NS: ui.Editor.obj_txt_PROGRAM_NS.textbox('getValue'),
			PROGRAM_DLL: ui.Editor.obj_txt_PROGRAM_DLL.textbox('getValue'),
			PROGRAM_INSTANCE: ui.Editor.obj_txt_PROGRAM_INSTANCE.textbox('getValue'),
			PROGRAM_DESCRIPTION: ui.Editor.obj_txt_PROGRAM_DESCRIPTION.textbox('getValue'),
			PROGRAM_ISDISABLED: (ui.Editor.obj_chk_PROGRAM_ISDISABLED.is(':checked')) ? 1 : 0,
			PROGRAM_ISSINGLEINSTANCE: (ui.Editor.obj_chk_PROGRAM_ISSINGLEINSTANCE.is(':checked')) ? 1 : 0,
			PROGRAM_ISWEBENABLED: (ui.Editor.obj_chk_PROGRAM_ISWEBENABLED.is(':checked')) ? 1 : 0,
			PROGRAM_ISMOBILEENABLED: (ui.Editor.obj_chk_PROGRAM_ISMOBILEENABLED.is(':checked')) ? 1 : 0,
			PROGRAM_ISSYSTEM: (ui.Editor.obj_chk_PROGRAM_ISSYSTEM.is(':checked')) ? 1 : 0,
			__STATE: ui.Editor.getFormDataState(),
		},
		D: {
			GROUP: ui.dgv_GROUP.datagrid('getChanges')
		}
	});
}

function _btnDelete_Click(ui) {
	var param = {
		id: ui.Editor.obj_txt_PROGRAM_ID.textbox('getValue')
	}
	ui.DataDelete(param);
}

function _btnLoad_Click(ui, pageNumber, pageSize) {
	ui.DataLoad(pageNumber, pageSize);
}

function _btnRowadd_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {
            case "Group" :
                if (ui.endEditing(ui.dgv_GROUP)){
					ui.dgv_GROUP.dialogShow();
                }
                break;


	}
}

function _btnRowremove_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {

            case "Group" :
                ui.removeRow(ui.dgv_GROUP);
                break;


	}
}


function _open_data(ui, id) {
	ui.DataOpen({id, id},
		function(data) {

			ui.Editor.obj_chk_PROGRAM_ISSYSTEM.attr("isdisabled", "true");


			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_ID, data.PROGRAM_ID);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_NAME, data.PROGRAM_NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_TYPE, data.PROGRAM_TYPE, data.PROGRAM_TYPENAME);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_ICON, data.PROGRAM_ICON);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_PATH, data.PROGRAM_PATH);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_NS, data.PROGRAM_NS);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_DLL, data.PROGRAM_DLL);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_INSTANCE, data.PROGRAM_INSTANCE);
			ui.Editor.setValue(ui.Editor.obj_txt_PROGRAM_DESCRIPTION, data.PROGRAM_DESCRIPTION);
			ui.Editor.setValue(ui.Editor.obj_chk_PROGRAM_ISDISABLED, data.PROGRAM_ISDISABLED==1 ? true : false);
			ui.Editor.setValue(ui.Editor.obj_chk_PROGRAM_ISSINGLEINSTANCE, data.PROGRAM_ISSINGLEINSTANCE==1 ? true : false);
			ui.Editor.setValue(ui.Editor.obj_chk_PROGRAM_ISWEBENABLED, data.PROGRAM_ISWEBENABLED==1 ? true : false);
			ui.Editor.setValue(ui.Editor.obj_chk_PROGRAM_ISMOBILEENABLED, data.PROGRAM_ISMOBILEENABLED==1 ? true : false);
			ui.Editor.setValue(ui.Editor.obj_chk_PROGRAM_ISSYSTEM, data.PROGRAM_ISSYSTEM==1 ? true : false);

			ui.dgv_GROUP.datagrid('loadData', data.DETIL.GROUP.records);
			ui.dgv_GROUP.maxline = data.DETIL.GROUP.maxline;

			ui.btnEdit.linkbutton('enable');
		}
	);

}
