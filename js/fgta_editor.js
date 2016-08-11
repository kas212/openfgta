var FGTA_Editor = function()
{
    var editor = this;
    var _isreadonly = true;
    var _iseditmode = false;
    var _isdatanew = false;

    this.FormData = new FGTA_FormData();
    this.FormDataText = new FGTA_FormData();
    this.ui = undefined;
    this.DataGrids = [];

    this.CreateEditorObject = function(name, obj, ftype, labeltext) {
        obj.name = name;
        obj.Ftype = ftype;
        obj.labeltext = labeltext;

        switch (ftype) {
            case 'FGTA_Control_Checkbox':
                obj.type = 'checkbox';
                break;
            case 'FGTA_Control_Combobox':
                obj.type = 'combobox';
                break;
            case 'FGTA_Control_Datebox':
                obj.type = 'datebox';
                break;
            case 'FGTA_Control_Numberbox':
                obj.type = 'numberbox';
                break;
            default:
                obj.type = 'textbox';
        }

        return obj;
    }

    this.add = function(obj) {
        Object.keys(obj).forEach(function (key) {
            editor[key] = obj[key];
        });
    };




    this.ApplyObjectState = function(o, ro) {

        var readonly = (ro==undefined) ? _isreadonly : ro;
        var data = [];
        if (o instanceof Array) {
            data = o;
        } else {
            data.push(o);
        }

        for (var i=0; i<data.length; i++) {
            var obj = data[i];

            if (obj.prop("type")=="checkbox") {
                if (obj.attr("isdisabled")=="false") {
                    obj.parent().children().each(function() {
                        if ($(this).is(':checkbox')) {
                            $(this).removeClass('css-checkbox-readandwrite').removeClass('css-checkbox-readonly').removeClass('css-checkbox-disabled').addClass(!readonly ? 'css-checkbox-readandwrite' : 'css-checkbox-readonly');
                            $(this).attr("disabled", !readonly ? false : true);
                        } else
                            $(this).removeClass('css-label-readandwrite').removeClass('css-label-readonly').removeClass('css-label-disabled').addClass(!readonly ? 'css-label-readandwrite' : 'css-label-readonly');
                    });
                } else {
                    obj.parent().children().each(function() {
                        if ($(this).is(':checkbox')) {
                            $(this).removeClass('css-checkbox-readandwrite').removeClass('css-checkbox-readonly').removeClass('css-checkbox-disabled').addClass('css-checkbox-disabled');
                            $(this).attr("disabled", true);
                        } else {
                            $(this).removeClass('css-label-readandwrite').removeClass('css-label-readonly').removeClass('css-label-disabled').addClass('css-label-disabled');
                        }
                    });
                }
            } else {
                var background_disabled =  getStyleRuleValue('background', '.textbox-text-noneditable');
                var background_readandwrite = getStyleRuleValue('background', '.fgta-textbox-text-readandwrite');
                var background_readonly = getStyleRuleValue('background', '.fgta-textbox-text-readonly');

                var opts = obj.textbox('options');

                if (opts.disabled) {
                    obj.textbox('textbox').removeClass('fgta-textbox-text-readandwrite').removeClass('fgta-textbox-text-readonly');
                    obj.textbox('textbox').css('background', background_disabled);
                } else {
                    obj.textbox('readonly', readonly);
                    obj.textbox('textbox').removeClass('fgta-textbox-text-readandwrite').removeClass('fgta-textbox-text-readonly').addClass(!readonly ? 'fgta-textbox-text-readandwrite' : 'fgta-textbox-text-readonly');
                    obj.textbox('textbox').css('background', !readonly ? background_readandwrite : background_readonly);
                }
            }

        }
    }


    this.setReadOnly = function(readonly) {
        for (var m in editor) {
            if (typeof editor[m] == "object" && typeof editor[m].prop === 'function') {
                if (editor[m].prop("type") == "fgta_object") {
                } else if (editor[m].prop("type")=="checkbox") {
					//tangani checkbox
                    if (editor[m].attr("isdisabled")=="false") {
                        editor[m].parent().children().each(function() {
                            if ($(this).is(':checkbox')) {
                                $(this).removeClass('css-checkbox-readandwrite').removeClass('css-checkbox-readonly').removeClass('css-checkbox-disabled').addClass(!readonly ? 'css-checkbox-readandwrite' : 'css-checkbox-readonly');
                                $(this).attr("disabled", !readonly ? false : true);
                            } else
                                $(this).removeClass('css-label-readandwrite').removeClass('css-label-readonly').removeClass('css-label-disabled').addClass(!readonly ? 'css-label-readandwrite' : 'css-label-readonly');
                        });
                    } else {
                        editor[m].parent().children().each(function() {
                            if ($(this).is(':checkbox')) {
                                $(this).removeClass('css-checkbox-readandwrite').removeClass('css-checkbox-readonly').removeClass('css-checkbox-disabled').addClass('css-checkbox-disabled');
                                $(this).attr("disabled", true);
                            } else {
                                $(this).removeClass('css-label-readandwrite').removeClass('css-label-readonly').removeClass('css-label-disabled').addClass('css-label-disabled');
                            }
                        });
                    }
                } else {
					// tangani selain checkbox (berbasis textbox)

                    var background_disabled =  getStyleRuleValue('background', '.textbox-text-noneditable');
                    var background_readandwrite = getStyleRuleValue('background', '.fgta-textbox-text-readandwrite');
                    var background_readonly = getStyleRuleValue('background', '.fgta-textbox-text-readonly');

                    var opts = editor[m].textbox('options');

                    if (opts.disabled) {
                        editor[m].textbox('textbox').removeClass('fgta-textbox-text-readandwrite').removeClass('fgta-textbox-text-readonly');
                        editor[m].textbox('textbox').css('background', background_disabled);
                    } else {
						editor[m].textbox('readonly', readonly);
						editor[m].textbox('textbox').removeClass('fgta-textbox-text-readandwrite').removeClass('fgta-textbox-text-readonly').addClass(!readonly ? 'fgta-textbox-text-readandwrite' : 'fgta-textbox-text-readonly');
						editor[m].textbox('textbox').css('background', !readonly ? background_readandwrite : background_readonly);

						// tangani apabila typenya adalah filebox (juga termasuk berbasis textbox)
						if (editor[m].Ftype=="FGTA_Control_File") {
							var objtext = $($(editor[m].parent().children()[2]).find(":text")[0]);
							objtext.removeClass('fgta-textbox-text-readandwrite').removeClass('fgta-textbox-text-readonly').addClass('fgta-textbox-text-readonly');
							objtext.css('background', background_readonly);
							objtext.attr("disabled", true);
							$($(editor[m].parent().children()[2]).find(":file")[0]).attr("disabled", !readonly ? false : true);
						}
                    }



                }
            }
        }

        _isreadonly = readonly;
    };

    this.isReadOnly = function() {
        return _isreadonly
    }


    this.isEditMode = function() {
        return _iseditmode;
    }

    this.setEditMode = function(editmode) {
        _iseditmode = editmode;
        editor.setReadOnly(!editmode);

		var btnNew_permanentDisabled = false;
		if (ui.btnNew.permanentDisabled!=null)
			if (ui.btnNew.permanentDisabled)
				btnNew_permanentDisabled = true;

		if (btnNew_permanentDisabled)
			ui.btnNew.linkbutton('disable');
		else
        	ui.btnNew.linkbutton(editmode ?  'disable' : 'enable');


        ui.btnEdit.linkbutton(editmode ?  'select' : 'unselect');

    	ui.btnSave.linkbutton(editmode ?  'enable' : 'disable');
    	ui.btnPrint.linkbutton(editmode ? 'disable' : 'enable');
    	ui.btnDelete.linkbutton(editmode ?  'enable' : 'disable');
    	ui.tabMain.tabs(editmode ? 'disableTab' : 'enableTab' ,  'List');
    	ui.SetRecordButtonState();


        if (!editmode)
        {
            changeCss('.datagrid-row-selected', getDataGridRowSelectedStyle());
            if (ui.Editor.isDataNew()) {
                ui.tabMain.tabs('select', 'List');
                ui.tabMain.tabs(ui.dgvList.datagrid('getData').total>0 ? 'enableTab' : 'disableTab', 'Data');
            }
        } else {
            changeCss('.datagrid-row-selected', 'background: #FFE095; color: #000000');
        }
    }

    this.isDataNew = function() {
        return _isdatanew;
    }


    this.setValue = function(obj, value, text, datainit) {
        var ui = editor.ui;
        switch (obj.Ftype) {
            case 'FGTA_Control_Combobox' :
                obj.combobox('setValue', value);
                obj.combobox('setText', text);

                var opt = obj.combobox('options');
                var textField = opt.textField;
                var valueField = opt.valueField;
                var currentdata = obj.combobox('getData');
                var available = false;
                if (currentdata.length!=undefined) {
                    for (var i=0; i<currentdata.length; i++) {
                        if (currentdata[i][valueField]==value) {
                            available = true;
                            break;
                        }
                    }
                }

                if (!available) {
                    var data = {};
                    data[valueField] = value;
                    data[textField] = text;
                    currentdata.push(data);
                    obj.combobox('loadData',currentdata);
                }

                editor.FormDataText[obj.name] = text;
                break;

			case 'FGTA_Control_File' :
				$($(obj.parent().children()[2]).find(":text")[0]).val(value);
				break;

            case 'FGTA_Control_Checkbox' : obj.prop('checked', value); break;
            case 'FGTA_Control_Datebox'  : obj.datebox('setValue', value);
            default: obj.textbox('setValue', value);
        }

        editor.FormData[obj.name] = value;
        editor.FormData.isDataChanged = true;
    }

    this.setRecordStatus = function(data, valuepair) {
        var ui = editor.ui;
        ui.obj_txt_recordcreateby.textbox('setValue', data['_recordcreateby']);
        ui.obj_txt_recordcreatedate.textbox('setValue', data['_recordcreatedate']);
        ui.obj_txt_recordmodifyby.textbox('setValue', data['_recordmodifyby']);
        ui.obj_txt_recordmodifydate.textbox('setValue', data['_recordmodifydate']);
        ui.obj_txt_recordrowid.textbox('setValue', data['_recordrowid']);

    }


    this.endEdit = function() {
        var ui = editor.ui;
        for (dgv of editor.DataGrids) {
            ui.endEditing(dgv);
            for (row of  dgv.datagrid('getChanges', 'inserted')) {
                row.__STATE="insert";
            }
            for (row of  dgv.datagrid('getChanges', 'updated')) {
                row.__STATE="update";
            }
            for (row of  dgv.datagrid('getChanges', 'deleted')) {
                row.__STATE="delete";
            }
        }
    }


    this.setDataChanges = function() {
        editor.FormData.isDataChanged = true;
    }

    this.getFormDataState = function() {
        return ui.Editor.isDataNew() ? 'insert' : (editor.FormData.isDataChanged ? 'update' : 'nochange');
    }

    this.rejectChanges = function() {
        var ui = editor.ui;
        var name = undefined;
        for (var m in editor) {
            if (typeof editor[m] == "object" && typeof editor[m].prop === 'function') {
                if (editor[m].prop("type") == "fgta_object") {
                } else if (editor[m].prop("type")=="checkbox") {
                    name = editor[m].name;
                    editor[m].prop('checked', editor.FormData[name]);
                } else {
                    name = editor[m].name;
                    var lastvalue = editor.FormData[name];
                    if (editor[m].Ftype=='FGTA_Control_Combobox') {
                        editor[m].combobox('setValue', lastvalue);
                        editor[m].combobox('setText', editor.FormDataText[name]);
                    } else {
                        editor[m].textbox('setValue', lastvalue);
                    }
                }
            }
        }

        for (dgv of ui.Editor.DataGrids) {
            dgv.datagrid('rejectChanges');
        }

        editor.FormData.isDataChanged = false;

        _isdatanew = false;
    }

    this.acceptChanges = function() {
        var ui = editor.ui;
        var name = undefined;
        for (var m in editor) {
            if (typeof editor[m] == "object" && typeof editor[m].prop === 'function') {
                if (editor[m].prop("type") == "fgta_object") {
                } else if (editor[m].prop("type")=="checkbox") {
                    name = editor[m].name;
                    editor.FormData[name] = editor[m].is(':checked') ? true : false;
                } else {
                    name = editor[m].name;
                    if (editor[m].Ftype=='FGTA_Control_Combobox') {
                        editor.FormData[name] = editor[m].combobox('getValue');
                    } else {
                        editor.FormData[name] = editor[m].textbox('getValue');
                    }
                }
            }
        }

        for (dgv of ui.Editor.DataGrids) {
            dgv.datagrid('acceptChanges');
        }

        editor.FormData.isDataChanged = false;

        _isdatanew = false;
    }

    this.isDataChanged = function() {
        if (editor.FormData.isDataChanged) return true;
        for (dgv of editor.DataGrids) {
            var rows = dgv.datagrid('getChanges');
            if (rows.length > 0) return true;
        }
        return false;
    }

    this.new = function(fn) {

        var ui = editor.ui;
        var name = undefined;
        for (var m in editor) {
            if (typeof editor[m] == "object" && typeof editor[m].prop === 'function') {
                if (editor[m].prop("type") == "fgta_object") {
                } else if (editor[m].prop("type")=="checkbox") {
                    name = editor[m].name;
                    editor.FormData[name] = false;
                    editor[m].prop('checked', editor.FormData[name]);
                } else {
                    name = editor[m].name;
                    if (editor[m].Ftype=='FGTA_Control_Combobox') {
                        editor.FormData[name] = 0;
                        editor[m].combobox('setValue', editor.FormData[name]);
                    } else if (editor[m].Ftype=='FGTA_Control_Numberbox') {
                        editor.FormData[name] = 0;
                        editor[m].numberbox('setValue', editor.FormData[name]);
                    } else if (editor[m].Ftype=='FGTA_Control_Datebox') {
                        var date = new Date();
                        var ye = date.getFullYear();
                        var me = date.getMonth() + 1;
                        var de = date.getDate();
                        editor.FormData[name] = (de < 10 ? '0' + de : de) + '/' + (me < 10 ? '0' + me : me) + '/' + ye;
                        editor[m].datebox('setValue', editor.FormData[name]);
                    } else {
                        editor.FormData[name] = "";
                        editor[m].textbox('setValue', editor.FormData[name]);
                    }
                }
            }
        }


        ui.obj_txt_recordcreateby.textbox('setValue', '');
        ui.obj_txt_recordcreatedate.textbox('setValue', '');
        ui.obj_txt_recordmodifyby.textbox('setValue', '');
        ui.obj_txt_recordmodifydate.textbox('setValue', '');
        ui.obj_txt_recordrowid.textbox('setValue', '');

        for (dgv of ui.Editor.DataGrids) {
            dgv.editIndex = undefined;
            dgv.maxline = 0;
            dgv.datagrid('loadData', {"total":0,"rows":[]});
        }


        if (ui.idfield['isauto']==true) {
            ui.idfield.textbox('disable');
            ui.Editor.setValue(ui.idfield, "[AUTO]");
        } else {
            ui.idfield.textbox('enable');
            ui.Editor.setValue(ui.idfield, "");
        }

        if (fn!=undefined)
            fn();


        ui.SetToolboxButtonState(1);
        ui.Editor.acceptChanges();
		ui.Editor.setEditMode(true);
        ui.tabMain.tabs('enableTab', 'Data');
        ui.btnEdit.linkbutton('enable');
        ui.btnDelete.linkbutton('disable');
		ui.tabMain.tabs('select', 'Data');

        ui.tabMainDetil_Select();

        _isdatanew = true;
    }

    this.disableIdField = function() {
        var ui = editor.ui;
        var background_disabled =  getStyleRuleValue('background', '.textbox-text-noneditable');
        ui.idfield.textbox('disable');
        ui.idfield.textbox('textbox').removeClass('fgta-textbox-text-readandwrite').removeClass('fgta-textbox-text-readonly');
        ui.idfield.textbox('textbox').css('background', background_disabled);
    }




}
