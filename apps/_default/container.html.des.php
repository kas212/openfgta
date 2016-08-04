	<script>
		var ui;

		$(document).ready(function () {
			ui = new ContainerClass();
			ui.Username = "<?=$_SESSION['username']?>";
			ui.Userfullname = "<?=$_SESSION['userfullname']?>";

			ui.obj_region_menu = $("#region_menu");
			ui.obj_cbo_group = $("#cnt_cbo_group");
			ui.obj_tre_program = $("#cnt_tree_program");
			ui.obj_tab_main = $("#main_tabs");


			var panel_menu_width = getCookie("panel_menu_width");
			if (panel_menu_width!="" && panel_menu_width!=null) {
				$('#main-layout').layout('panel', 'west').panel('resize', {width:panel_menu_width});
				$('#main-layout').layout('resize');
			}

			ui.Init();

		});

		function on_menu_resize() {
			if (ui==null)
				return;

			var panel = $('#main-layout').layout('panel', 'west');
			setCookie("panel_menu_width", (panel.width() + 5), 7);
		}

	</script>

	<div data-options="region:'north'" border="false" style="height:34px; text-align:left; <?=__FG_HEADER_STYLE?>">
		<div id="header-inner" style="padding-top: 0px; padding-bottom: 0px; height: 30px">
			<table cellpadding="0" border="0" cellspacing="0" margin="0" style="width:100%; height: 28px" >
				<tr>
					<td>
						<div style="color:#fff;font-size:18px;font-weight:bold;">
							<?=__FG_HEADER_TITLE?>
						</div>
					</td>
					<td style="vertical-align: bottom">
						<div style="color:#fff;font-size:12px;font-weight:normal; text-align: right; padding-right: 10px; padding-bottom: 5px">
							<span id="cnt_txt_username" style="font-size:12px;font-weight:bold;">
								<?=$_SESSION['userfullname']?>
							</span> |
							<a class="ui-header" href="javascript: _Preference_Open()">Preference</a> |
							<a class="ui-header" href="?mode=logout">Logout</a>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div data-options="region:'south'" border="false" style="height:18px; text-align:center; <?=__FG_FOOTER_STYLE?>">
		<div style="color:#fff;font-size:10px; padding-top: 0px;">
			<table width="100%">
				<tr>
					<td align="left" width="30%">
						&nbsp;
					</td>
					<td align="center"  width="40%">
						<?=__FG_FOOTER_CREDIT?>
					</td>
					<td align="right"  width="30%">powered by <a href="http://www.fgta.net" target="newwindow" style="color: #cfcfcf">Open FGTA Library</a></td>
				</tr>
			</table>
		</div>
	</div>



	<div data-options="region:'west',split:true, headerCls:'messager-window'" border="false" title="Solution" style="width:240px; ">
		<div id="region_menu" class="easyui-panel" border="false"  data-options="fit:true, onResize: function(e) { on_menu_resize(); }">
			<div class="easyui-layout" data-options="fit:true" >
				<div data-options="region:'north'" border="false">
					<div class="easyui-panel" border="false" style="padding: 0px 5px 0px 5px; background: #eee; border-right: 1px solid #ddd" data-options="fit:true">
						<div style="padding-top: 10px; padding-bottom: 3px;">
						<div class="ui-label" style="float:right; width: 40px; padding-right: 5px;"><a id="cnt_btn_groupreload" href="javascript:_ComboboxGroup_LoadData(ui)">reload</a></div>
						<div class="ui-label" >Group</div>
					</div>
					<div style="height: 23px">
						<select id="cnt_cbo_group" class="easyui-combobox" data-options="fit:true, editable:false, valueField:'group_id',textField:'group_name'"></select>
					</div>
					<div  class="ui-label" style="padding-top: 10px; padding-bottom: 3px;">
						Program
					</div>
				</div>
			</div>
			<div data-options="region:'center'" border="false" style="padding: 0px 5px 5px 5px; background: #eee; border-right: 1px solid #ddd">
					<div class="easyui-panel" border="true" data-options="fit:true">
						<ul id="cnt_tree_program" class="easyui-tree" data-options="fit:true"></ul>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div data-options="region:'center'">
		<div id="main_tabs" class="easyui-tabs" fit="true" border="false" plain="true">
			<div title="welcome" href="?mode=welcome"></div>
		</div>
	</div>
