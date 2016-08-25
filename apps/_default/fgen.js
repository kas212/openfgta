var fgenClass = function () {
	$.extend(this, new FGTA_uiBase());
	var ui = this;


	this._LastPageNumber = 0;
	this._LastPageSize = 0;
	this.Init = function () {
		ui.NS = '_default';
		ui.CL = 'fgen';
		ui.SetToolboxButtonState(0);
		ui.tabMain.tabs('enableTab', 'List');
		ui.tabMain.tabs('disableTab', 'Data');
		ui.formMain.form({
			onChange: function(target) {
				ui.Editor.setDataChanges();
			}
		});
		_btnLoad_Click(ui,0,0);


		$('#btnGenerate').hide();
		ui.OnSelecTabMain = function(title, index) {
			if (index==0) {
				$('#btnGenerate').hide();
			} else {
				$('#btnGenerate').show();
				$('#btnGenerate').linkbutton('enable');
			}
		}



	};
}




function _dgv_H_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_H.editIndex != index){
		if (ui.endEditing(ui.dgv_H)){
			ui.dgv_H.datagrid('beginEdit', index);
			ui.dgv_H.editIndex = index;
		} else {
	        ui.dgv_H.datagrid('selectRow', ui.dgv_H.editIndex);
	    }
	}
}

function _dgv_D1_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_D1.editIndex != index){
		if (ui.endEditing(ui.dgv_D1)){
			ui.dgv_D1.datagrid('beginEdit', index);
			ui.dgv_D1.editIndex = index;
		} else {
	        ui.dgv_D1.datagrid('selectRow', ui.dgv_D1.editIndex);
	    }
	}
}

function _dgv_D2_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_D2.editIndex != index){
		if (ui.endEditing(ui.dgv_D2)){
			ui.dgv_D2.datagrid('beginEdit', index);
			ui.dgv_D2.editIndex = index;
		} else {
	        ui.dgv_D2.datagrid('selectRow', ui.dgv_D2.editIndex);
	    }
	}
}

function _dgv_D3_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_D3.editIndex != index){
		if (ui.endEditing(ui.dgv_D3)){
			ui.dgv_D3.datagrid('beginEdit', index);
			ui.dgv_D3.editIndex = index;
		} else {
	        ui.dgv_D3.datagrid('selectRow', ui.dgv_D3.editIndex);
	    }
	}
}

function _dgv_D4_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_D4.editIndex != index){
		if (ui.endEditing(ui.dgv_D4)){
			ui.dgv_D4.datagrid('beginEdit', index);
			ui.dgv_D4.editIndex = index;
		} else {
	        ui.dgv_D4.datagrid('selectRow', ui.dgv_D4.editIndex);
	    }
	}
}

function _dgv_D5_RowDblClick(ui,index,row) {
	if (ui.Editor.isReadOnly()) return;

	if (ui.dgv_D5.editIndex != index){
		if (ui.endEditing(ui.dgv_D5)){
			ui.dgv_D5.datagrid('beginEdit', index);
			ui.dgv_D5.editIndex = index;
		} else {
	        ui.dgv_D5.datagrid('selectRow', ui.dgv_D5.editIndex);
	    }
	}
}


function _TableBrowseTextboxSetReadonly(objtext) {
	var background_readonly = getStyleRuleValue('background', '.fgta-textbox-text-readonly');
	objtext.removeClass('fgta-textbox-text-readandwrite').removeClass('fgta-textbox-text-readonly').addClass('fgta-textbox-text-readonly');
	objtext.css('background', background_readonly);
	objtext.attr("disabled", true);
}

function _InitTableBrowseTextbox() {
	_TableBrowseTextboxSetReadonly($($(ui.Editor.obj_txt_FGEN_PK.parent().children()[2]).find(":text")[0]));

	_TableBrowseTextboxSetReadonly($($(ui.Editor.obj_txt_FGEN_TABLE.parent().children()[2]).find(":text")[0]));
	_TableBrowseTextboxSetReadonly($($(ui.Editor.obj_txt_FGEN_D1TABLE.parent().children()[2]).find(":text")[0]));
	_TableBrowseTextboxSetReadonly($($(ui.Editor.obj_txt_FGEN_D2TABLE.parent().children()[2]).find(":text")[0]));
	_TableBrowseTextboxSetReadonly($($(ui.Editor.obj_txt_FGEN_D3TABLE.parent().children()[2]).find(":text")[0]));
	_TableBrowseTextboxSetReadonly($($(ui.Editor.obj_txt_FGEN_D4TABLE.parent().children()[2]).find(":text")[0]));
	_TableBrowseTextboxSetReadonly($($(ui.Editor.obj_txt_FGEN_D5TABLE.parent().children()[2]).find(":text")[0]));
}

function _btnNew_Click(ui) {
	ui.Editor.new(function() {
	});
	$('#btnGenerate').linkbutton('disable');
	$('#btn_H_Get').linkbutton('enable');
	$('#btn_D1_Get').linkbutton('enable');
	$('#btn_D2_Get').linkbutton('enable');
	$('#btn_D3_Get').linkbutton('enable');
	$('#btn_D4_Get').linkbutton('enable');
	$('#btn_D5_Get').linkbutton('enable');
	_InitTableBrowseTextbox();

	$('#obj_test').html('');
}

function _btnEdit_Click(ui) {
	ui.btnEdit_Toggle();
	if (ui.Editor.isEditMode()) {
		$('#btnGenerate').linkbutton('disable');
		$('#btn_H_Get').linkbutton('enable');
		$('#btn_D1_Get').linkbutton('enable');
		$('#btn_D2_Get').linkbutton('enable');
		$('#btn_D3_Get').linkbutton('enable');
		$('#btn_D4_Get').linkbutton('enable');
		$('#btn_D5_Get').linkbutton('enable');
	} else {
		$('#btnGenerate').linkbutton('enable');
		$('#btn_H_Get').linkbutton('disable');
		$('#btn_D1_Get').linkbutton('disable');
		$('#btn_D2_Get').linkbutton('disable');
		$('#btn_D3_Get').linkbutton('disable');
		$('#btn_D4_Get').linkbutton('disable');
		$('#btn_D5_Get').linkbutton('disable');
	}

	_InitTableBrowseTextbox();
}

function _btnSave_Click(ui) {
	ui.Editor.endEdit();
	ui.DataSave({
		H: {
			FGEN_ID: ui.Editor.obj_txt_FGEN_ID.textbox('getValue'),
			FGEN_NAME: ui.Editor.obj_txt_FGEN_NAME.textbox('getValue'),
			FGEN_PROGTYPE: ui.Editor.obj_cbo_FGEN_PROGTYPE.combobox('getValue'),
			FGEN_FOLDER: ui.Editor.obj_txt_FGEN_FOLDER.textbox('getValue'),
			FGEN_IDENT: ui.Editor.obj_txt_FGEN_IDENT.textbox('getValue'),
			FGEN_TABLE: ui.Editor.obj_txt_FGEN_TABLE.textbox('getValue'),
			FGEN_PK: ui.Editor.obj_txt_FGEN_PK.textbox('getValue'),
			FGEN_ISAUTO: (ui.Editor.obj_chk_FGEN_ISAUTO.is(':checked')) ? 1 : 0,
			FGEN_D1NAME: ui.Editor.obj_txt_FGEN_D1NAME.textbox('getValue'),
			FGEN_D1TABLE: ui.Editor.obj_txt_FGEN_D1TABLE.textbox('getValue'),
			FGEN_D2NAME: ui.Editor.obj_txt_FGEN_D2NAME.textbox('getValue'),
			FGEN_D2TABLE: ui.Editor.obj_txt_FGEN_D2TABLE.textbox('getValue'),
			FGEN_D3NAME: ui.Editor.obj_txt_FGEN_D3NAME.textbox('getValue'),
			FGEN_D3TABLE: ui.Editor.obj_txt_FGEN_D3TABLE.textbox('getValue'),
			FGEN_D4NAME: ui.Editor.obj_txt_FGEN_D4NAME.textbox('getValue'),
			FGEN_D4TABLE: ui.Editor.obj_txt_FGEN_D4TABLE.textbox('getValue'),
			FGEN_D5NAME: ui.Editor.obj_txt_FGEN_D5NAME.textbox('getValue'),
			FGEN_D5TABLE: ui.Editor.obj_txt_FGEN_D5TABLE.textbox('getValue'),
			__STATE: ui.Editor.getFormDataState(),
		},
		D: {
			H: ui.dgv_H.datagrid('getChanges'),
			D1: ui.dgv_D1.datagrid('getChanges'),
			D2: ui.dgv_D2.datagrid('getChanges'),
			D3: ui.dgv_D3.datagrid('getChanges'),
			D4: ui.dgv_D4.datagrid('getChanges'),
			D5: ui.dgv_D5.datagrid('getChanges')
		}
	});
}

function _btnDelete_Click(ui) {

	var param = {
		id: ui.Editor.obj_txt_FGEN_ID.textbox('getValue')
	}
	ui.DataDelete(param);
}

function _btnLoad_Click(ui, pageNumber, pageSize) {
	ui.DataLoad(pageNumber, pageSize);
}

function _btnRowadd_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {

            case "H" :
                if (ui.endEditing(ui.dgv_H)){
                    // muncul dialog

                    //tambahkan ke grid
                    ui.appendRow(ui.dgv_H, {});
                }
                break;


            case "D1" :
                if (ui.endEditing(ui.dgv_D1)){
                    // muncul dialog

                    //tambahkan ke grid
                    ui.appendRow(ui.dgv_D1, {});
                }
                break;


            case "D2" :
                if (ui.endEditing(ui.dgv_D2)){
                    // muncul dialog

                    //tambahkan ke grid
                    ui.appendRow(ui.dgv_D2, {});
                }
                break;


            case "D3" :
                if (ui.endEditing(ui.dgv_D3)){
                    // muncul dialog

                    //tambahkan ke grid
                    ui.appendRow(ui.dgv_D3, {});
                }
                break;


            case "D4" :
                if (ui.endEditing(ui.dgv_D4)){
                    // muncul dialog

                    //tambahkan ke grid
                    ui.appendRow(ui.dgv_D4, {});
                }
                break;


            case "D5" :
                if (ui.endEditing(ui.dgv_D5)){
                    // muncul dialog

                    //tambahkan ke grid
                    ui.appendRow(ui.dgv_D5, {});
                }
                break;


	}
}

function _btnRowremove_Click(ui) {
	var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
	switch (opts.title) {

            case "H" :
                ui.removeRow(ui.dgv_H);
                break;


            case "D1" :
                ui.removeRow(ui.dgv_D1);
                break;


            case "D2" :
                ui.removeRow(ui.dgv_D2);
                break;


            case "D3" :
                ui.removeRow(ui.dgv_D3);
                break;


            case "D4" :
                ui.removeRow(ui.dgv_D4);
                break;


            case "D5" :
                ui.removeRow(ui.dgv_D5);
                break;


	}
}

function _open_data(ui, id) {
	ui.DataOpen({id, id},
		function(data) {

			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_ID, data.FGEN_ID);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_NAME, data.FGEN_NAME);
			ui.Editor.setValue(ui.Editor.obj_cbo_FGEN_PROGTYPE, data.FGEN_PROGTYPE, data.FGEN_PROGTYPENAME);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_FOLDER, data.FGEN_FOLDER);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_IDENT, data.FGEN_IDENT);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_TABLE, data.FGEN_TABLE);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_PK, data.FGEN_PK);
			ui.Editor.setValue(ui.Editor.obj_chk_FGEN_ISAUTO, data.FGEN_ISAUTO==1 ? true : false);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D1NAME, data.FGEN_D1NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D1TABLE, data.FGEN_D1TABLE);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D2NAME, data.FGEN_D2NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D2TABLE, data.FGEN_D2TABLE);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D3NAME, data.FGEN_D3NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D3TABLE, data.FGEN_D3TABLE);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D4NAME, data.FGEN_D4NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D4TABLE, data.FGEN_D4TABLE);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D5NAME, data.FGEN_D5NAME);
			ui.Editor.setValue(ui.Editor.obj_txt_FGEN_D5TABLE, data.FGEN_D5TABLE);

			ui.dgv_H.datagrid('loadData', data.DETIL.H.records);
			ui.dgv_H.maxline = data.DETIL.H.maxline;

			ui.dgv_D1.datagrid('loadData', data.DETIL.D1.records);
			ui.dgv_D1.maxline = data.DETIL.D1.maxline;

			ui.dgv_D2.datagrid('loadData', data.DETIL.D2.records);
			ui.dgv_D2.maxline = data.DETIL.D2.maxline;

			ui.dgv_D3.datagrid('loadData', data.DETIL.D3.records);
			ui.dgv_D3.maxline = data.DETIL.D3.maxline;

			ui.dgv_D4.datagrid('loadData', data.DETIL.D4.records);
			ui.dgv_D4.maxline = data.DETIL.D4.maxline;

			ui.dgv_D5.datagrid('loadData', data.DETIL.D5.records);
			ui.dgv_D5.maxline = data.DETIL.D5.maxline;


			$('#btn_H_Get').linkbutton('disable');
			$('#btn_D1_Get').linkbutton('disable');
			$('#btn_D2_Get').linkbutton('disable');
			$('#btn_D3_Get').linkbutton('disable');
			$('#btn_D4_Get').linkbutton('disable');
			$('#btn_D5_Get').linkbutton('disable');

			_InitTableBrowseTextbox();

			ShowTestLink();


			ui.btnEdit.linkbutton('enable');
		}
	);
}

function _load_table_field(tabname, tablename, dgv, pk, fn_fieldloaded) {


	ui.tabMainDetil.tabs('select', tabname);
	ui.canvas.mask('Loading table field of ' + tablename);

	$.ajax({
		type: "POST",
		dataType: "json",
		url: FGTA_ServiceUrl(ui.NS,ui.CL,'LoadTableField'),
		data: {
			tablename: tablename
		},
		success: function (result, status, xhr) {
			try {
				var data = ui.ProcessAjaxJsonResult(result, status, xhr);
				if (data == null) throw "invalid data";

				var index;
                var exists = [];
                var rows = dgv.datagrid('getData').rows;
                for (index = 0; index < rows.length; index++) {
                    exists.push(rows[index].FGEND_FIELD);
                }

				if (pk!=undefined)
					exists.push(pk);

                for(index=data.records.length-1; index>=0; index--){
                    if (jQuery.inArray(data.records[index].FGEND_FIELD, exists)>=0) data.records.splice(index, 1);
                }

				for (var i=0; i<data.records.length; i++) {
					if (ui.endEditing(dgv)){
						ui.appendRow(dgv, {
							FGEND_FIELD: data.records[i].FGEND_FIELD,
							FGEND_LABEL: data.records[i].FGEND_LABEL,
							FGEND_CONTROL: data.records[i].FGEND_CONTROL,
							FGEND_ISLIST: data.records[i].FGEND_ISLIST,
							FGEND_ISSEARCH: data.records[i].FGEND_ISSEARCH,
							FGEND_ISFORM: data.records[i].FGEND_ISFORM
						});
					}
				}
				ui.endEditing(dgv);
				ui.canvas.unmask();


				fn_fieldloaded();
			}
			catch (err) {
				ui.canvas.unmask();
				$.messager.alert("_load_table_field Error", err, "error").window({ shadow: false });
			}
		},
		error: function (xhr, status, error) {
			ui.canvas.unmask();
			ui.ProcessErrorText("Webservice LoadTableField on _load_table_field Error", xhr, status, error);
		},
	});
}

function _Generate() {

	try
	{
		if (ui.Editor.obj_txt_FGEN_TABLE.textbox('getValue')=='')
			throw 'Nama Table Header belum diisi';

		if (ui.dgv_H.datagrid('getData').total==0)
			throw 'Table H belum diisi';

		if (ui.Editor.obj_txt_FGEN_PK.textbox('getValue')=='')
			throw 'PK Table Header belum diisi';

	}
	catch (err) {
		$.messager.alert("Generate", err, "error").window({ shadow: false });
		return;
	}

	ui.canvas.mask('Generating Program Skeleton... ');

	$.ajax({
		type: "POST",
		dataType: "json",
		url: FGTA_ServiceUrl(ui.NS,ui.CL,'Generate'),
		data: {
			id: ui.Editor.obj_txt_FGEN_ID.textbox('getValue')
		},
		success: function (result, status, xhr) {
			try {
				var data = ui.ProcessAjaxJsonResult(result, status, xhr);
				if (data == null) throw "invalid data";

				if (data.result=='1') {
					$.messager.alert("Generator", "Done.", "info").window({ shadow: false });
				}

				ShowTestLink();
				ui.canvas.unmask();
			}
			catch (err) {
				ui.canvas.unmask();
				$.messager.alert("_Generate() Error", err, "error").window({ shadow: false });
			}
		},
		error: function (xhr, status, error) {
			ui.canvas.unmask();
			ui.ProcessErrorText("Webservice Generate on _Generate() Error", xhr, status, error);
		},
	});

}

function OpenTable_Dialog(tabname, dgv) {
	var rows = dgv.datagrid('getData').rows;
	if (rows.length>0) {
		$.messager.alert(tabname, "Table di '"+ tabname +"' tidak dalam keadaan kosong!", "error", function() {
			ui.tabMainDetil.tabs('select', tabname);
		}).window({ shadow: false });
	} else {
		ui.list_TABLE_dlg.tabname = tabname;
		ui.list_TABLE_dlg.dgv = dgv;
		ui.list_TABLE_dlg.fn_load_table_field = _load_table_field;
		ui.list_TABLE_dlg.dialog({closed: false});
		$('#list_TABLE_dlg_srcGridResult').datagrid('loadData', []);
		$('#list_TABLE_dlg_srcTextbox').textbox('setValue', '');
		$('#list_TABLE_dlg_srcTextbox').textbox('textbox').focus();
	}
}

function OpenTable(PK, tabname, obj_textbox, obj_dgv) {
	if (!ui.Editor.isEditMode())
		return;


	var name = $('#obj_txt_FGEN_' + tabname + 'NAME').textbox('getValue');
	var h_table = $('#obj_txt_FGEN_TABLE').textbox('getValue');

	if (h_table.trim()=='') {
		$.messager.alert('Table Master', "Table Master belum diisi", "error", function() {
			$('#obj_txt_FGEN_TABLE').textbox('textbox').focus();
		}).window({ shadow: false });
	}
	else if (PK.trim()=='') {
		$.messager.alert('Primary Key', "Primary Key Table Master belum diisi", "error", function() {
			$('#obj_txt_FGEN_PK').textbox('textbox').focus();
		}).window({ shadow: false });
	}
	else if (name.trim()=='') {
			$.messager.alert(tabname + " Name", tabname + " Name belum diisi", "error", function() {
				$('#obj_txt_FGEN_' + tabname + 'NAME').textbox('textbox').focus();
			}).window({ shadow: false });
	}
	else {
		//_load_table_field(tabname, obj_textbox.textbox('getValue'), obj_dgv, PK);
		OpenTable_Dialog(tabname, obj_dgv);
	}

}

function ShowTestLink() {
	var ns = ui.Editor.obj_txt_FGEN_FOLDER.textbox('getValue');
	var cl = ui.Editor.obj_txt_FGEN_IDENT.textbox('getValue');
	var link = '<a href="http://localhost/openfgta/container.des.php?mode=app&ns=' + ns + '&cl='+ cl +'" target="newtab">Test</a>'
	$('#obj_test').html(link);
}
