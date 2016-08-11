	var ContainerClass = function()
	{
		$.extend(this, new FGTA_uiBase());
		var ui = this;



		this.obj_region_menu = null;
		this.obj_cbo_group = null;
		this.obj_tre_program = null;
		this.obj_tab_main = null;

		this.Init = function() {
			ui.NS = '_default';
			ui.CL = 'container';

			ui.obj_cbo_group.combobox({
				onSelect: function(record){
					_ComboboxGroup_Select(ui, record);
				}
			});

			ui.obj_tre_program.tree({
			    onDblClick: function (node) {
			        _Program_DblClick(ui, node);
			    }
			});

			_ComboboxGroup_LoadData(ui);
		}

		this.Iframe_Loaded = function (iframe, programname) {
		    this.obj_region_menu.unmask();
		    this.obj_tab_main.tabs('getTab', programname).unmask();
			if (iframe.contentWindow.LoadedInContainer!=undefined)
				iframe.contentWindow.LoadedInContainer();
		}

	}



	function _ComboboxGroup_LoadData(ui) {
		$('#region_menu').mask('loading group list...');

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "service.json.php?ns=_default&cl=group&sm=LoadGroup",
			data: {},
			success: function(result,status,xhr) {
				try
				{
					var data = ui.ProcessAjaxJsonResult(result,status,xhr);
					if (data==null) throw "Invalid Group Data";

					ui.obj_cbo_group.combobox('clear');
					ui.obj_cbo_group.combobox('loadData', data.groups);
					if (data.groups.length>0)
					{
						var group_id_selected_init = data.groups[0]["group_id"];
						ui.obj_cbo_group.combobox('enable');
						ui.obj_cbo_group.combobox('select', group_id_selected_init);
					} else {
						ui.obj_cbo_group.combobox('disable');
						$('#region_menu').unmask();
					}
				}
				catch (err)
				{
				    $('#region_menu').unmask();
				    $.messager.alert("_ComboboxGroup_LoadData", err, "warning").window({ shadow: false });
				}

			},

			error: function(xhr,status,error) {
				$('#region_menu').unmask();
				ui.ProcessErrorText("_ComboboxGroup_LoadData", xhr, status, error);
			}
		});
	}

	function _ComboboxGroup_Select(ui, record) {
	    ui.obj_region_menu.mask('loading group program of ' + record.group_id + '...');

	    $.ajax({
	        type: "POST",
	        dataType: "json",
	        url: "service.json.php?ns=_default&cl=program&sm=LoadGroupProgram",
	        data: {
	            'group_id': record.group_id,
	        },
	        success: function (result, status, xhr) {
	            //var data = ui.ProcessAjaxJsonResult(result, status, xhr);
	            //if (data == null) throw "Invalid Program Data";

	            try {
	                var data = ui.ProcessAjaxJsonResult(result, status, xhr);
	                if (data == null) throw "Invalid Program Data";

	                ui.obj_tre_program.tree('loadData', []);
	                ui.obj_tre_program.tree('loadData', data.programs);
	            }
	            catch (err) {
	                ui.obj_region_menu.unmask();
	                $.messager.alert("_ComboboxGroup_Select", err, "warning").window({ shadow: false });
	            }
	            finally {
	                ui.obj_region_menu.unmask();
	            }
	        },
	        error: function (xhr, status, error) {
	            ui.obj_region_menu.unmask();
	            ui.ProcessErrorText("_ComboboxGroup_Select", xhr, status, error);
	        }
	    });

	}

	function _Program_DblClick(ui, node) {
	    if (node.type == "item") {
	        var program = {
	            id: node.id,
	            name: node.text,
	            url: node.url,
	            issingleinstance: true,
	        }

	        _Program_Select(ui, program);
	    }
	}

	function _Program_Select(ui, program) {
	    ui.obj_region_menu.mask('get program data...');

		ui.ExecuteWebservice(
			FGTA_ServiceUrl(ui.NS,ui.CL,'GetProgramInfo'), '', program,

			function(data) {

				if (data.isLogin==0) {
					location.href = "?";
					return;
				}


				var opennewtab = false;
			    if (program.issingleinstance) {
			        var exists = ui.obj_tab_main.tabs('exists', program.name);
			        if (!exists) {
			            opennewtab = true;
			        }
			        else {
			            ui.obj_region_menu.unmask();
			            ui.obj_tab_main.tabs('select', program.name);
			            return;
			        }
			    }
			    else {
			        opennewtab = true;
			    }

			    if (opennewtab) _Program_Open(ui, program);
			},

			function() {
				ui.obj_region_menu.unmask();
			}
		);
	}

	function _Program_Open(ui, program) {
	    ui.obj_region_menu.mask();

	    //var tabcontent = '<iframe class="easyui-layout" style="border-left: 1px solid #000" onload="javascript: ui.Iframe_Loaded(this, \'' + program.name + '\')" frameborder="0" src="' + program.url + '" data-options="fit:true"></iframe>';
		var tabcontent = fn_iframe(program);
		ui.obj_tab_main.tabs('add', {
	        title: program.name,
	        content: tabcontent,
	        closable: true
	    });

	    ui.obj_tab_main.tabs('getTab', program.name).mask("Loading Program...");
	}

	function _Preference_Open() {
		var program = {
			id: '_fgta_preference',
			name: 'Preference',
			url: '?mode=app&ns=_default&cl=preference',
			issingleinstance: true,
		}

		_Program_Select(ui, program);
	}
