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


        ui.getSearchParam = function() {
            return [
                <?php $this->bind_search_param($this->Search) ?>
        ]};
        <?php $this->init_search($this->Search) ?>

        ui.Init();
        <?php $this->bind_datagrid_init($this->Editor); ?>


        $('#btn_H_Get').bind('click', function(){
            if ($('#btn_H_Get').linkbutton('options').disabled) return;
            //alert($('#btn_H_Get').linkbutton('options').disabled);
            _load_table_field('H', ui.Editor.obj_txt_FGEN_TABLE.textbox('getValue'), ui.dgv_H);
        });



        $('#btn_D1_Get').bind('click', function(){
            if ($('#btn_H_Get').linkbutton('options').disabled) return;
            _load_table_field('D1', ui.Editor.obj_txt_FGEN_D1TABLE.textbox('getValue'), ui.dgv_D1, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btn_D2_Get').bind('click', function(){
            if ($('#btn_D2_Get').linkbutton('options').disabled) return;
            _load_table_field('D2', ui.Editor.obj_txt_FGEN_D2TABLE.textbox('getValue'), ui.dgv_D2, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btn_D3_Get').bind('click', function(){
            if ($('#btn_D3_Get').linkbutton('options').disabled) return;
            _load_table_field('D3', ui.Editor.obj_txt_FGEN_D3TABLE.textbox('getValue'), ui.dgv_D3, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btn_D4_Get').bind('click', function(){
            if ($('#btn_D4_Get').linkbutton('options').disabled) return;
            _load_table_field('D4', ui.Editor.obj_txt_FGEN_D4TABLE.textbox('getValue'), ui.dgv_D4, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btn_D5_Get').bind('click', function(){
            if ($('#btn_D5_Get').linkbutton('options').disabled) return;
            _load_table_field('D5', ui.Editor.obj_txt_FGEN_D5TABLE.textbox('getValue'), ui.dgv_D5, ui.Editor.obj_txt_FGEN_PK.textbox('getValue'));
        });

        $('#btnGenerate').bind('click', function(){
            if ($('#btnGenerate').linkbutton('options').disabled) return;
            _Generate();
        });

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
