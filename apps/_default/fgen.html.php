<script>
    var ui;
    var DATA = {
        'CONTROL': [<?php $this->LoadPage_PreloadData('CONTROL'); ?>],
        'TYPE' : [{id:'0', text:'--PILIH--'},{id:'MST', text:'MASTER'},{id:'TRN', text:'TRANSAKSI'},{id:'RPT', text:'REPORT'}]
    };


    $(document).ready(function () {
        ui = new fgenClass();
        ui.canvas = $("#maincontent");

        <?php
        $this->bind_fgta_toolbox();
        ?>


        ui.tabMain = $("#tabMain");
        ui.tabMain.tabs({
            onSelect: function(title,index) { ui.tabMain_Select(title,index) }
        });

        ui.formMain = $("#formMain");
        ui.tabMainDetil = $("#tabMainDetil");


        <?php
        $this->bind_dglist($this->dgvList);
        $this->bind_datagrid($this->Editor);
        $this->bind_editor($this->Editor);
        $this->bind_recordform();
        ?>


		ui.list_TABLE_dlg = $('#list_TABLE_dlg');
        ui.getSearchParam = function() {
            return [
                <?php $this->bind_search_param($this->Search) ?>
        ]};
        <?php $this->init_search($this->Search) ?>

        ui.Init();
        <?php $this->bind_datagrid_init($this->Editor); ?>


        $('#btn_H_Get').bind('click', function(){
            if ($('#btn_H_Get').linkbutton('options').disabled) return;

            //_load_table_field('H', ui.Editor.obj_txt_FGEN_TABLE.textbox('getValue'), ui.dgv_H);
			OpenTable_Dialog('H', ui.dgv_H);
        });



        $('#btn_D1_Get').bind('click', function(){
            if ($('#btn_H_Get').linkbutton('options').disabled) return;
            //_load_table_field('D1', ui.Editor.obj_txt_FGEN_D1TABLE.textbox('getValue'), ui.dgv_D1, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
			OpenTable(ui.Editor.obj_txt_FGEN_PK.textbox('getValue'), 'D1', ui.Editor.obj_txt_FGEN_D1TABLE, ui.dgv_D1);
        });

        $('#btn_D2_Get').bind('click', function(){
            if ($('#btn_D2_Get').linkbutton('options').disabled) return;
			OpenTable(ui.Editor.obj_txt_FGEN_PK.textbox('getValue'), 'D2', ui.Editor.obj_txt_FGEN_D2TABLE, ui.dgv_D2);
        });

        $('#btn_D3_Get').bind('click', function(){
            if ($('#btn_D3_Get').linkbutton('options').disabled) return;
			OpenTable(ui.Editor.obj_txt_FGEN_PK.textbox('getValue'), 'D3', ui.Editor.obj_txt_FGEN_D3TABLE, ui.dgv_D3);
			//_load_table_field('D3', ui.Editor.obj_txt_FGEN_D3TABLE.textbox('getValue'), ui.dgv_D3, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btn_D4_Get').bind('click', function(){
            if ($('#btn_D4_Get').linkbutton('options').disabled) return;
			OpenTable(ui.Editor.obj_txt_FGEN_PK.textbox('getValue'), 'D4', ui.Editor.obj_txt_FGEN_D4TABLE, ui.dgv_D4);
            //_load_table_field('D4', ui.Editor.obj_txt_FGEN_D4TABLE.textbox('getValue'), ui.dgv_D4, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btn_D5_Get').bind('click', function(){
            if ($('#btn_D5_Get').linkbutton('options').disabled) return;
			OpenTable(ui.Editor.obj_txt_FGEN_PK.textbox('getValue'), 'D5', ui.Editor.obj_txt_FGEN_D5TABLE, ui.dgv_D5);
            //_load_table_field('D5', ui.Editor.obj_txt_FGEN_D5TABLE.textbox('getValue'), ui.dgv_D5, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btnGenerate').bind('click', function(){
            if ($('#btnGenerate').linkbutton('options').disabled) return;
            _Generate();
        });


		list_TABLE_fn_Dialog_Init(ui);

    });
</script>

<div id="maincontent" class="easyui-layout" data-options="fit:true">
    <div data-options="region:'north'" border="false" style="padding: 2px 10px 2px 10px">
        <?php $this->load_html_fgta_toolbox(); ?>
        <a href="#" id="btnGenerate" class="easyui-linkbutton c4" data-options="disabled: true">Generate</a>
    </div>

    <div data-options="region:'center'" border="false" style="padding: 0px 10px 5px 10px">
        <div id="tabMain" class="easyui-tabs" fit="true" border="false" plain="true" >
            <div title="List" >
                <div class="easyui-layout" data-options="fit:true">
                    <!-- SEARCH DATA -->
                    <div data-options="region:'north'" border="false" style="height: 50px">
                        <?php $this->load_html_fgta_search($this->Search); ?>
                    </div>

                    <!-- DATAGRID LIST -->
                    <div data-options="region:'center'" border="false">
                        <?php $this->load_html_datagrid($this->dgvList); ?>
                    </div>
                </div>
            </div>


            <div title="Data">

                <div class="easyui-layout" data-options="fit:true">
                    <!-- FORM -->
                    <div data-options="region:'north'" border="false" style="height:180px;">
                    <form id="formMain">
                    <?php $this->load_html_control($this->Editor); ?>
                    </form>
                    </div>

                    <!-- TAB DETAIL -->
                    <div data-options="region:'center'" border="false">
                        <div id="tabMainDetil" class="easyui-tabs" fit="true" border="false" plain="true" data-options="onSelect: function(title, index) { if (ui==undefined) return; ui.tabMainDetil_Select(title, index); }" >
                            <?php $this->load_html_datagrid($this->Editor); ?>
                            <div title="Record" data-options="allowaddremove:false" >
                            <?php $this->load_html_fgta_recordform(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

</div>

<?php $this->bind_datagrid_dialog($this->Editor); ?>







<!-- DIALOG BEGIN [list_TABLE] //-->
<div id="list_TABLE_dlg" class="easyui-dialog" title="Select Table"
    style="width:400px;height:500px;padding:10px;"
    data-options="
		modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true
	" >
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'north'" border="false" style="height:40px;">

            <div fgta-id="list_TABLE_dlg_srcTextbox" class="fgta_field" style=" top:5px; left:0px; width:300px; border-bottom: 0px">
                <table cellpadding="0" cellspacing="0"><tr>
                <td width="70" align="right" style="padding-right: 5px"><label for="list_TABLE_dlg_srcChk" style="font-size: 8pt; cursor: pointer">Search</label></td>
                <td>
                    <input id="list_TABLE_dlg_srcChk" class="css-checkbox-disabled" type="checkbox"  checked="true"  disabled onclick="ui.CriteriaSelect(this, 'list_TABLE_dlg_srcTextbox', 'textbox')">
                    <label for="list_TABLE_dlg_srcChk" class="css-label-disabled" style="font-size: 8pt"></label>
                </td>
                <td style="padding-left: 5px"><input class="easyui-textbox" id="list_TABLE_dlg_srcTextbox" style="width:140px;" data-options="disabled: false"></td>
                <td style="padding-left: 5px"><a href="#" id="list_TABLE_dlg_srcButton" class="easyui-linkbutton c8" style="width:55px; height:22px">Search</a></td>
                </tr></table>
            </div>

        </div>
        <div data-options="region:'center'" border="false">
            <table id="list_TABLE_dlg_srcGridResult" class="easyui-datagrid"
                       data-options="fit:true,singleSelect:true,
                       onDblClickRow: function(index,row) {
						   list_TABLE_fn_Dialog_Select(ui,index,row);
					   },
                ">
                <thead><tr>
                        <th data-options="field:'TABLE_ID', width:80, hidden: true"><span style="font-size: 7.5pt">ID</span></th>
						<th data-options="field:'TABLE_NAME', width:300"><span style="font-size: 7.5pt">TABLE</span></th>
                </tr></thead>
            </table>
        </div>
    </div>
</div>


<script>
    function list_TABLE_fn_Dialog_Init(ui) {
        $('#list_TABLE_dlg_srcTextbox').textbox('textbox').bind('keydown', function(e) {
            if (e.keyCode==13) {
                list_TABLE_fn_Dialog_DoSearch(ui);
            }
        });

        $('#list_TABLE_dlg_srcButton').bind('click', function(){
            list_TABLE_fn_Dialog_DoSearch(ui);
        });
    }


    function list_TABLE_fn_Dialog_DoSearch(ui) {
        $('#list_TABLE_dlg_srcGridResult').datagrid('loading');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: FGTA_ServiceUrl(ui.NS, ui.CL,'ListTable'),
            data: {
                pageNumber: 1,
                pageSize: 30,
                param: [
                    {Name: ":SEARCH", Value: $('#list_TABLE_dlg_srcTextbox').textbox('getValue'), Checked: $('#list_TABLE_dlg_srcChk').is(':checked')},
                ]
            },
            success: function (result, status, xhr) {
                try {
                    var data = ui.ProcessAjaxJsonResult(result, status, xhr);
                    if (data == null) throw "invalid data";


                    $('#list_TABLE_dlg_srcGridResult').datagrid('loadData', data.records);
                    $('#list_TABLE_dlg_srcGridResult').datagrid('loaded');

                    if (data.records.length>0) {
                        $('#list_TABLE_dlg_srcGridResult').datagrid('selectRow', 0);
                    }

                }
                catch (err) {
                    $('#list_TABLE_dlg_srcGridResult').datagrid('loaded');
                    $.messager.alert("Load Data Error", err, "error").window({ shadow: false });
                }
            },
            error: function (xhr, status, error) {
                $('#list_TABLE_dlg_srcGridResult').datagrid('loaded');
                ui.ProcessErrorText("Webservice Load Data Error", xhr, status, error);
            },
        });
    }



    function list_TABLE_fn_Dialog_Select(ui,index,row) {
		var tabname = ui.list_TABLE_dlg.tabname;
		var dgv = ui.list_TABLE_dlg.dgv;

		$('#list_TABLE_dlg').dialog('close');
		switch(tabname) {
			case 'H' :
				$('#obj_txt_FGEN_TABLE').textbox('setValue', row.TABLE_NAME);
				$('#obj_txt_FGEN_PK').textbox('setValue', row.PRIMARY_KEY.trim());
				ui.list_TABLE_dlg.fn_load_table_field(tabname, ui.Editor.obj_txt_FGEN_TABLE.textbox('getValue'), dgv, undefined, function() {
				});
				break;

			default:
				var objname = '#obj_txt_FGEN_' + ui.list_TABLE_dlg.tabname + 'TABLE';
				var PK = $('#obj_txt_FGEN_PK').textbox('getValue');
				$(objname).textbox('setValue', row.TABLE_NAME);
				ui.list_TABLE_dlg.fn_load_table_field(tabname, row.TABLE_NAME, dgv, PK, function() {
				});
		}



    }



</script>


<!-- DIALOG END [list_TABLE] //-->
