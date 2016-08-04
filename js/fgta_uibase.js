	var FGTA_uiBase = function()
	{
		$.extend(this, new FGTA_Object());

		this.Editor = new FGTA_Editor();
		this.idfield = undefined;

		$("input[class*='easyui-textbox'][maxlength][id]").each(function (i, elt) {
			$('#' + elt.id).textbox();
			$('#' + elt.id).textbox('textbox').attr('maxlength', $('#' + elt.id).attr("maxlength"));
		});

		$("input[class*='easyui-numberbox'][maxlength][id]").each(function (i, elt) {
			$('#' + elt.id).numberbox();
			$('#' + elt.id).numberbox('textbox').attr('maxlength', $('#' + elt.id).attr("maxlength"));
		});


		this.ProcessErrorMessage = function(title, message, xhr, status, error) {
			this.ProcessErrorText(title, xhr, status, error, undefined, message);
		};

		this.ProcessErrorText = function(title, xhr, status, error, service_url, hmessage) {

			if (xhr.responseText.substring(0, 12)=="[SESSIONEND]") {
				if (window.self !== window.top) {
					parent.Relogin();
				} else {
					location.href = "container.des.php";
				}
				return;
			}


			if (xhr.responseText.substring(0, 11)=="_DEBUGTEXT:" || xhr.responseText.substring(0, 13) == "WEBEXCEPTION:")
			{

				var pattern1 = /\[(.*?)\]/g;
				var pattern2 = /Exception](.*)/;

				var match;
				var textdata;
				var dialogtitle;
				var dialogmessage;


				if (xhr.responseText.substring(0, 11)=="_DEBUGTEXT:")
				{
					textdata = xhr.responseText.replace("_DEBUGTEXT:", "");
					dialogtitle = "DEBUG";
					dialogmessage = textdata;
				}
				else
				{
					textdata = xhr.responseText.replace("WEBEXCEPTION:", "");


					match = pattern1.exec(textdata);
					dialogtitle = title + " - " + match[1];

					match = pattern2.exec(textdata);
					dialogmessage = match[1];

					if (service_url!=undefined)
						dialogmessage = match[1] + '\\r\\n' + service_url;
					else
						dialogmessage = match[1];

				}

				hmessage = hmessage==undefined? '' : hmessage + '<br><br>';

				$.messager.alert({
					title: dialogtitle,
					msg: '<div style="height:100px">'+ hmessage + textdata.replace("\\r", '').replace("\\n", '<br />') +'</div>',
					icon: 'error',
					shadow: false,
					width: 600
				});

			}
			else
			{
				var querystring = xhr.getResponseHeader('QueryString');
				$('#cnt_messagebox').dialog({
					content: "<table style='-moz-user-select: text;-khtml-user-select: all;-webkit-user-select: all;-ms-user-select: all;user-select: all;'><tr><td><i>" + querystring + "</i></td></tr><tr><td>" + xhr.responseText + "<hr>" + error + "</td></tr></table>",
					title: 'Response Text',
					headerCls: 'messager-window',
					shadow: false
				});
				$('#cnt_messagebox').parent().css( "background-color", "#ccc" );
				$('#cnt_messagebox').dialog('center');
				$('#cnt_messagebox').dialog('open');
			}
		};

		this.ProcessAjaxJsonResult = function(result,status,xhr) {
			if (xhr.responseText==null || xhr.responseText=='null' || xhr.responseText==undefined)
			{
				var querystring = xhr.getResponseHeader('QueryString');
				$.messager.alert("WebMethodException",  "WebMethod doesn't return WebResponse datatype.<br><br>" + "QueryString:<br><i>" + querystring + "</i>", 'error');
			}

			var WebResult = jQuery.parseJSON(xhr.responseText);
			return WebResult.Result;

		};



		this.SetToolboxButtonState = function(mode) {
			var ui = this;
			if (mode == 0) {
				ui.btnNew.linkbutton('enable');
				ui.btnEdit.linkbutton('disable');
				ui.btnSave.linkbutton('disable');
				ui.btnPrint.linkbutton('disable');
				ui.btnDelete.linkbutton('disable');
				ui.btnLoad.linkbutton('enable');
				ui.btnRowadd.linkbutton('disable');
				ui.btnRowremove.linkbutton('disable');
				ui.btnRecFirst.linkbutton('disable');
				ui.btnRecPrev.linkbutton('disable');
				ui.btnRecNext.linkbutton('disable');
				ui.btnRecLast.linkbutton('disable');
			} else {
				ui.btnPrint.linkbutton('enable');
		    	ui.btnLoad.linkbutton('disable');
			}
		}




		this.SetRecordButtonState = function() {
			var isreadonly = ui.Editor.isReadOnly();
			if (isreadonly) {
				var currentrow = ui.dgvList.datagrid('getSelected');
				var index = ui.dgvList.datagrid('getRowIndex', currentrow);
				var totalrows = ui.dgvList.datagrid('getData').total;

				if (totalrows > 0) {
					ui.btnRecFirst.linkbutton((index==0) ? 'disable' : 'enable');
					ui.btnRecPrev.linkbutton((index==0) ? 'disable' : 'enable');
					ui.btnRecNext.linkbutton((index == totalrows -1) ? 'disable' : 'enable');
					ui.btnRecLast.linkbutton((index == totalrows -1) ? 'disable' : 'enable');
				} else {
					ui.btnRecFirst.linkbutton('disable');
					ui.btnRecPrev.linkbutton('disable');
					ui.btnRecNext.linkbutton('disable');
					ui.btnRecLast.linkbutton('disable');
				}
			} else {
				ui.btnRecFirst.linkbutton('disable');
				ui.btnRecPrev.linkbutton('disable');
				ui.btnRecNext.linkbutton('disable');
				ui.btnRecLast.linkbutton('disable');
			}
		}

		this.btnLoad_Click = function(pageNumber, pageSize) {
			var ui = this;
			_btnLoad_Click(ui, pageNumber, pageSize)
		}

		this.btnRecFirst_Click = function () {
			var ui = this;
			var currentrow = ui.dgvList.datagrid('getSelected');
			if (currentrow!=null) {
				var index = ui.dgvList.datagrid('getRowIndex', currentrow)
				if (index > 0)
					ui.dgvList.datagrid('selectRow', 0);
			}
		}

		this.btnRecPrev_Click = function() {
			var ui = this;
			var currentrow = ui.dgvList.datagrid('getSelected');
			if (currentrow!=null) {
				var index = ui.dgvList.datagrid('getRowIndex', currentrow)
				if (index > 0)
					ui.dgvList.datagrid('selectRow', index-1);
			}
		}

		this.btnRecNext_Click = function() {
			var ui = this;
			var currentrow = ui.dgvList.datagrid('getSelected');
			if (currentrow!=null) {
				var totalrows = ui.dgvList.datagrid('getData').total;
				var index = ui.dgvList.datagrid('getRowIndex', currentrow)
				if (index < (totalrows-1))
					ui.dgvList.datagrid('selectRow', index+1);
			}
		}

		this.btnRecLast_Click = function() {
			var ui = this;
			var currentrow = ui.dgvList.datagrid('getSelected');
			if (currentrow!=null) {
				var totalrows = ui.dgvList.datagrid('getData').total;
				var index = ui.dgvList.datagrid('getRowIndex', currentrow)
				if (index < (totalrows-1))
					ui.dgvList.datagrid('selectRow', totalrows-1);
			}
		}

		this.dgv_ClickCell = function(ui, dgv, index) {
			if (ui.Editor.isReadOnly()) return;
			if (dgv.editIndex != index){
				if (ui.endEditing(dgv)){
			        dgv.datagrid('selectRow', index);
			    }
			}
		}


		this.OpenTabData = function() {
			var ui = this;

			//ui.SetRecordButtonState();
			var currentrow = ui.dgvList.datagrid('getSelected');
			if (currentrow!=null) {
				var opts = ui.dgvList.datagrid('options');
				_open_data(ui, currentrow[opts.idField]);
			}
		}

		this.CriteriaSelect = function(chk, tagname, type) {
			if (chk.checked)
				eval("$('#" + tagname +"')." + type + "('enable')");
			else
				eval("$('#" + tagname +"')." + type + "('disable')");

	    };

		this.endEditing = function(dgv){
            if (dgv.editIndex == undefined){return true}
            if (dgv.datagrid('validateRow', dgv.editIndex)){
                dgv.datagrid('endEdit', dgv.editIndex);
                dgv.editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }

		this.appendRow = function(dgv, record) {
			dgv.maxline++;

			var newrecord = {};
			$.extend(newrecord, record, {_LINE:dgv.maxline});

			dgv.datagrid('appendRow',newrecord);
			dgv.editIndex = dgv.datagrid('getRows').length-1;
			dgv.datagrid('selectRow', dgv.editIndex)
						.datagrid('beginEdit', dgv.editIndex);

		}

		this.removeRow = function(dgv) {
			if (ui.endEditing(dgv)){
				var currentrow = dgv.datagrid('getSelected');
				if (currentrow!=null) {
					var index = dgv.datagrid('getRowIndex', currentrow)
					dgv.datagrid('cancelEdit', index)
					   .datagrid('deleteRow', index);

					var maxindex = dgv.datagrid('getRows').length-1;

					if (index<=maxindex)
						dgv.datagrid('selectRow', index);
					else if ((index-1)>=0)
						dgv.datagrid('selectRow', index-1);



				}
			}
		}

		this.updateDgvList = function(data) {
			if (ui.Editor.isDataNew()) {
				ui.dgvList.datagrid('insertRow', {index:0,row:data});
				ui.dgvList.datagrid('selectRow', 0);
			} else {
				var currentrow = ui.dgvList.datagrid('getSelected');
				var rowindex = ui.dgvList.datagrid('getRowIndex', currentrow);
				ui.dgvList.datagrid('updateRow',{
					index: rowindex,
					row: data
				});
			}
		}


		this.SaveSuccess = function(result, status, xhr) {
			try {
				var data = ui.ProcessAjaxJsonResult(result, status, xhr);
				if (data == null) throw "invalid data";

				ui.Editor.setValue(ui.Editor[ui.idfield['name']], data[ui.idfield['mapping']]);

				ui.Editor.setRecordStatus(data, []);
				ui.updateDgvList(data);

				if (ui.Editor.isDataNew()) ui.btnDelete.linkbutton('enable');
				ui.Editor.disableIdField();
				ui.Editor.acceptChanges();
				ui.canvas.unmask();

				if (Array.isArray(ui.ReloadedFieldOnSave)) {
					if (ui.ReloadedFieldOnSave.length>0) {
						for (var i=0; i<=ui.ReloadedFieldOnSave.length-1; i++) {
								var p = ui.ReloadedFieldOnSave[i];
								ui.Editor.setValue(ui.Editor[p['name']], data[p['mapping']]);
						}
						ui.Editor.acceptChanges();
					}
				}
			}
			catch (err) {
				ui.canvas.unmask();
				$.messager.alert("Save Error", err.replace("\\r", '').replace("\\n", '<br />'), "error").window({shadow:false});
			}

		}

		this.SaveError = function(xhr,status,error) {
			ui.canvas.unmask();
			ui.ProcessErrorText("Webservice Save Error", xhr, status, error);
		}


		this.LoadSuccess = function (result, status, xhr, pageNumber, pageSize) {
			try {
				var data = ui.ProcessAjaxJsonResult(result, status, xhr);
				if (data == null) throw "invalid data";

				ui.dgvList.datagrid('loadData', data.records);

				if (ui.dgvList.datagrid('getPager').length>0) {
					ui.dgvList.datagrid('getPager').pagination('refresh',{
				    	total: data.total,
				    	pageNumber: pageNumber
				    });
				}

				ui._LastPageNumber = pageNumber;
				ui._LastPageSize = pageSize;

				ui.tabMain.tabs(data.total > 0 ? 'enableTab' : 'disableTab', 'Data');
				ui.canvas.unmask();
			}
			catch (err) {
				ui.canvas.unmask();
				$.messager.alert("Load Data Error", err.replace("\\r", '').replace("\\n", '<br />'), "error").window({ shadow: false });
			}
		}

		this.LoadError = function(xhr, status, error) {
			ui.canvas.unmask();
			ui.ProcessErrorText("Webservice Load Data Error", xhr, status, error);
		}


		this.tabMain_Select = function(title, index) {
			if (index == 0) {
				ui.SetToolboxButtonState(0);
				ui.tabMain.tabs('enableTab', 'List');
				ui.tabMain.tabs('enableTab', 'Data');
			}
			else {
				if (!ui.Editor.isEditMode())
					ui.OpenTabData();
			}

			if (ui.OnSelecTabMain!=undefined) {
				ui.OnSelecTabMain(title, index);
			}
		}


		this.tabMainDetil_Select = function(title, index) {
			if (ui==undefined)
				return;

			var opts = ui.tabMainDetil.tabs('getSelected').panel('options');
			ui.btnRowadd.linkbutton(opts.allowaddremove && !ui.Editor.isReadOnly() ? 'enable' : 'disable');
			ui.btnRowremove.linkbutton(opts.allowaddremove && !ui.Editor.isReadOnly() ? 'enable' : 'disable');
		}

		this.btnEdit_Toggle = function(fn) {
			if (ui.Editor.isEditMode()) {
				// keluar dari edit mode
				var exiteditmode = false;
				ui.Editor.endEdit();
				if (ui.Editor.isDataChanged()) {
					$.messager.confirm('Confirm', 'Data has changed, are you sure want to exit edit mode?\nAll changes will be lost.', function(ok){
						if (ok) {
							ui.Editor.setEditMode(false);
							ui.Editor.rejectChanges();
							ui.tabMainDetil_Select();
							if (fn!=undefined) fn(false);
						}
					});
				} else {
					ui.Editor.setEditMode(false);
					ui.tabMainDetil_Select();
					if (fn!=undefined) fn(false);
				}
			} else {
				// masuk edit mode
				ui.Editor.setEditMode(true);
				ui.tabMainDetil_Select();
				if (fn!=undefined) fn(true);
			}
		}

		this.dgvList_RowDblClick = function(index, row) {
			ui.tabMain.tabs('select', 'Data');
	    }

		this.dgvList_Select = function(index, row) {
			var tabselected = ui.tabMain.tabs('getSelected');
			var tabindex = ui.tabMain.tabs('getTabIndex',tabselected);



			if (tabindex==1)
				if (!ui.Editor.isDataNew())
					ui.OpenTabData();
		}


		this.ValidateEditor = function(messagerfn) {
			var ed = ui.Editor;

			var isValid = true;
			for (var m in ed) {
				if (typeof ed[m] == "object" && typeof ed[m].prop === 'function') {
					if (ed[m].prop("type") == "fgta_object") {
					} else if (ed[m].prop("type")=="checkbox") {
					} else {
						var objfn;
						switch (ed[m].type) {
							case 'textbox' :
								isValid = ed[m].textbox('isValid');
								break;
							case 'combobox' :
								isValid = ed[m].combobox('isValid');
								break;
							case 'datebox' :
								isValid = ed[m].datebox('isValid');
								break;
							case 'numberbox' :
								isValid = ed[m].numberbox('isValid');
								break;
						}
						if (!isValid) {
							messagerfn(ed[m]);
							return false;
						}

					}
				}
			}

			return true;
		}

		this.setFocus = function(obj) {
			switch (obj.type) {
				case 'textbox' :
					 obj.textbox('textbox').focus();
					break;
				case 'combobox' :
					obj.combobox('textbox').focus();
					break;
				case 'datebox' :
					obj.datebox('textbox').focus();
					break;
				case 'numberbox' :
					obj.numberbox('textbox').focus();
					break;
			}
		}


		this.DataDelete = function(param) {
			var id = param.id;
			$.messager.confirm('Confirm', "Apakah anda yakin akan menghapus data '" + id + "' ?", function(ok){
				if (ok) {
					ui.canvas.mask('Deleting Data...');
					$.ajax({
						type: "POST",
						dataType: "json",
						url: FGTA_ServiceUrl(ui.NS,ui.CL,'Delete'),
						data: param,
						success: function (result, status, xhr) {
							try {
								var data = ui.ProcessAjaxJsonResult(result, status, xhr);
								if (data == null) throw "invalid data";

								var rowindex = ui.dgvList.datagrid('getRowIndex', id);
								ui.dgvList.datagrid('deleteRow', rowindex);

								ui.canvas.unmask();
								ui.Editor.acceptChanges();
								ui.btnEdit_Toggle();
								ui.tabMain.tabs('select', 'List');
							}
							catch (err) {
								ui.canvas.unmask();
								$.messager.alert("Delete Data Error", err, "error").window({ shadow: false });
							}
						},
						error: function (xhr, status, error) {
							ui.canvas.unmask();
							ui.ProcessErrorText("Webservice Delete Data Error", xhr, status, error);
						},
					});

				}
			});
		}

		this.DataLoad = function(pageNumber, pageSize) {

			ui.canvas.mask('Loading Data...');

			var usepaging = ui.dgvList.datagrid('getPager').length==0 ? false : true;

			var defaultPageSize = !usepaging ? 0 : ui.dgvList.datagrid('getPager').pagination('options').pageSize;

			if (defaultPageSize==0) defaultPageSize = 10;
			if (pageSize==0) pageSize = usepaging ? defaultPageSize : 0;
			if (pageNumber==0) pageNumber=1;
			if ((pageNumber==ui._LastPageNumber) && (pageSize!=ui._LastPageSize)) pageNumber=1;

			$.ajax({
				type: "POST",
				dataType: "json",
				url: FGTA_ServiceUrl(ui.NS,ui.CL,'ListData'),
				data: {
					pageNumber: pageNumber,
					pageSize: pageSize,
					param: ui.getSearchParam()
				},
				error: ui.LoadError,
				success: function (result, status, xhr) { ui.LoadSuccess(result, status, xhr, pageNumber, pageSize) }
			});

		}

		this.DataSave = function(data) {
			if (!ui.ValidateEditor(function(obj) {
				$.messager.alert('Save Error','Cek pengisian Form.<br>Ada kesalahan pada <b>' + obj.labeltext + '</b>', 'warning', function() {
					ui.setFocus(obj);
				});
			})) return;

			ui.canvas.mask('Saving Data...');
			//ui.Editor.endEdit();

			$.ajax({
				type: "POST",
				dataType: "json",
				url: FGTA_ServiceUrl(ui.NS,ui.CL,'Save'),
				data: data,
				success: ui.SaveSuccess,
				error: ui.SaveError
			});
		}



		this.DataOpen = function(param, fn) {
			ui.canvas.mask('Opening Data...');
			$.ajax({
				type: "POST",
				dataType: "json",
				url: FGTA_ServiceUrl(ui.NS,ui.CL,'OpenData'),
				data: param,
				success: function (result, status, xhr) {
					try {
						var data = ui.ProcessAjaxJsonResult(result, status, xhr);
						if (data == null) throw "invalid data";

						fn(data);

						ui.Editor.setReadOnly(true);

						ui.Editor.setRecordStatus(data, []);
						ui.Editor.acceptChanges();
						ui.Editor.disableIdField();

						ui.btnSave.linkbutton('disable');
						ui.tabMain.tabs('enableTab', 'List');
						ui.tabMain.tabs('enableTab', 'Data');
						ui.SetToolboxButtonState(1);
						ui.SetRecordButtonState();
						ui.canvas.unmask();

					}
					catch (err) {
						ui.tabMain.tabs('select', 'List');
						ui.canvas.unmask();
						$.messager.alert("Load Data Error", err, "error").window({ shadow: false });
					}
				},
				error: function (xhr, status, error) {
					ui.tabMain.tabs('select', 'List');
					ui.canvas.unmask();
					ui.ProcessErrorText("Webservice Load Data Error", xhr, status, error);
				},
			});

		}


		this.ExecuteWebservice = function(service_url, executingmessage, param, fn_success, fn_error)  {
			var masked = false;
			if (executingmessage != undefined)
				if (executingmessage != '') {
					masked = true;
					ui.canvas.mask(executingmessage);
				}

			$.ajax({
				type: "POST",
				dataType: "json",
				url: service_url,
				data: param,
				success: function (result, status, xhr) {
					try {
						var data = ui.ProcessAjaxJsonResult(result, status, xhr);
						if (data == null) throw "invalid data";
						if (fn_success != undefined) fn_success(data);
						if (masked) ui.canvas.unmask();
					}
					catch (err) {
						if (masked) ui.canvas.unmask();
						$.messager.alert("Webservice Data Error", err, "error").window({ shadow: false });
					}
				},
				error: function (xhr, status, error) {
					if (fn_error != undefined) fn_error(xhr, status, error);
					if (masked) ui.canvas.unmask();
					ui.ProcessErrorText("Webservice Errorss", xhr, status, error, service_url );
				},
			});

		}



	};
