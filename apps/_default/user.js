var UserClass = function () {
	$.extend(this, new FGTA_uiBase());
	var ui = this;


	this._LastPageNumber = 0;
	this._LastPageSize = 0;
	this.Init = function () {
		ui.NS = '_default';
		ui.CL = 'user';
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


$.extend($.fn.validatebox.defaults.rules, {
	USER_ID: {
		validator: function(value, param){
			return value.match(/^[A-Za-z0-9.]*$/);
		},
		message: 'hanya diperbolehkan menggunakan huruf dan atau ANGKA.'
	}
});

/*
$.extend($.fn.validatebox.defaults.rules,{
    exists:{
        validator:function(value,param){
            var cc = $(param[0]);
            var v = cc.combobox('getValue');
            var rows = cc.combobox('getData');
            for(var i=0; i<rows.length; i++){
                if (rows[i].id == v){return true}
            }
            return false;
        },
        message:'The entered value does not exists.'
    }
});
*/




function _dgv_GROUP_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_GROUP.editIndex != index){
		if (ui.endEditing(ui.dgv_GROUP)){
			var GROUP_ID = ui.dgv_GROUP.datagrid('getRows')[index]['GROUP_ID'];
			var GROUP_NAME = ui.dgv_GROUP.datagrid('getRows')[index]['GROUP_NAME'];
			ui.dgv_GROUP.datagrid('beginEdit', index);
			ui.dgv_GROUP.editIndex = index;
		} else {
	        ui.dgv_GROUP.datagrid('selectRow', ui.dgv_GROUP.editIndex);
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
			USER_ID: ui.Editor.obj_txt_USER_ID.textbox('getValue'),
			USER_NAME: ui.Editor.obj_txt_USER_NAME.textbox('getValue'),
			USER_EMAIL: ui.Editor.obj_txt_USER_EMAIL.textbox('getValue'),
			USER_ISDISABLED: (ui.Editor.obj_chk_USER_ISDISABLED.is(':checked')) ? 1 : 0,
			USER_ISSYSTEM: (ui.Editor.obj_chk_USER_ISSYSTEM.is(':checked')) ? 1 : 0,
			USER_PASSWORD:  ui.Editor.obj_txt_PASWORD.textbox('getValue'),
			__STATE: ui.Editor.getFormDataState(),
		},
		D: {
			GROUP: ui.dgv_GROUP.datagrid('getChanges')
		}
	});
}

function _btnDelete_Click(ui) {
	var param = {
		id: ui.Editor.obj_txt_USER_ID.textbox('getValue')
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

			ui.Editor.obj_chk_USER_ISSYSTEM.attr("isdisabled", "true");

			ui.Editor.setValue(ui.Editor.obj_txt_USER_ID, data.USER_ID);
			ui.Editor.setValue(ui.Editor.obj_txt_USER_NAME, data.USER_NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_USER_EMAIL, data.USER_EMAIL);
			ui.Editor.setValue(ui.Editor.obj_chk_USER_ISDISABLED, data.USER_ISDISABLED==1 ? true : false);
			ui.Editor.setValue(ui.Editor.obj_chk_USER_ISSYSTEM, data.USER_ISSYSTEM==1 ? true : false);

			ui.dgv_GROUP.datagrid('loadData', data.DETIL.GROUP.records);
			ui.dgv_GROUP.maxline = data.DETIL.GROUP.maxline;

			ui.btnEdit.linkbutton('enable');
		}
	);
}
