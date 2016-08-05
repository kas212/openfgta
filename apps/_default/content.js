var contentClass = function () {
	$.extend(this, new FGTA_uiBase());
	var ui = this;


	this._LastPageNumber = 0;
	this._LastPageSize = 0;
	this.Init = function () {
		ui.NS = '_default';
		ui.CL = 'content';
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
			CONTENT_ID: ui.Editor.obj_txt_CONTENT_ID.textbox('getValue'),
			CONTENT_PUBLISHDATE: ui.Editor.obj_dt_CONTENT_PUBLISHDATE.datebox('getValue'),
			CONTENT_TITLE: ui.Editor.obj_txt_CONTENT_TITLE.textbox('getValue'),
			CONTENT_TEXT: ui.Editor.obj_txt_CONTENT_TEXT.textbox('getValue'),
			CONTENTTYPE_ID: ui.Editor.obj_txt_CONTENTTYPE_ID.textbox('getValue'),
			__STATE: ui.Editor.getFormDataState(),
		},
		D: {
			
		}
	});
}

function _btnDelete_Click(ui) {

	var param = {
		id: ui.Editor.obj_txt_CONTENT_ID.textbox('getValue')
	}
	ui.DataDelete(param);
}

function _btnLoad_Click(ui, pageNumber, pageSize) {
	ui.DataLoad(pageNumber, pageSize);
}

function _btnRowadd_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {
        
	}
}

function _btnRowremove_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {
        
	}
}


function _open_data(ui, id) {
	ui.DataOpen({id, id},
		function(data) {

			ui.Editor.setValue(ui.Editor.obj_txt_CONTENT_ID, data.CONTENT_ID);
			ui.Editor.setValue(ui.Editor.obj_dt_CONTENT_PUBLISHDATE, data.CONTENT_PUBLISHDATE);
			ui.Editor.setValue(ui.Editor.obj_txt_CONTENT_TITLE, data.CONTENT_TITLE);
			ui.Editor.setValue(ui.Editor.obj_txt_CONTENT_TEXT, data.CONTENT_TEXT);
			ui.Editor.setValue(ui.Editor.obj_txt_CONTENTTYPE_ID, data.CONTENTTYPE_ID);

			

			ui.btnEdit.linkbutton('enable');
		}
	);
}
