<script>
    var ui;
    $(document).ready(function () {
        ui = new GroupClass();
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

    });
</script>

<div id="maincontent" class="easyui-layout" data-options="fit:true">
    <div data-options="region:'north'" border="false" style="padding: 2px 10px 2px 10px">
        <?php $this->load_html_fgta_toolbox(); ?>
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
                    <div data-options="region:'north'" border="false" style="height:120px;">
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



<div id="d_select_user" class="easyui-dialog" title="Select User"
    style="width:400px;height:500px;padding:10px;"
    data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true" >
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'north'" border="false" style="height:40px;">
            <?php
            new FGTA_Control_TextboxSearch(['name'=>':SEARCH', 'label'=>'Search', 'directrender'=>true, 'button'=>'dlg_src_btn_SEARCHUSER' ,'checkbox'=>'dlg_src_chk_SEARCHUSER', 'textbox'=>'dlg_src_txt_SEARCHUSER', 'location'=>[5,0,300], 'mandatory'=>true ])
            ?>
        </div>
        <div data-options="region:'center'" border="false">
            <table id="dgv_select_user" class="easyui-datagrid"
                       data-options="fit:true,singleSelect:true,
                       onDblClickRow: function(index,row) { _UserDialog_Select(ui,index,row) },
                ">
                <thead><tr>
                        <th data-options="field:'USER_ID', width:80"><span style="font-size: 7.5pt">ID</span></th>
                        <th data-options="field:'USER_NAME', width:300"><span style="font-size: 7.5pt">USER</span></th>
                </tr></thead>
            </table>
        </div>
    </div>
</div>


<div id="d_select_program" class="easyui-dialog" title="Select Program"
    style="width:400px;height:500px;padding:10px;"
    data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true" >
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'north'" border="false" style="height:40px;">
            <?php
            new FGTA_Control_TextboxSearch(['name'=>':SEARCH', 'label'=>'Search', 'directrender'=>true, 'button'=>'dlg_src_btn_SEARCHPROGRAM' ,'checkbox'=>'dlg_src_chk_SEARCHPROGRAM', 'textbox'=>'dlg_src_txt_SEARCHPROGRAM', 'location'=>[5,0,300], 'mandatory'=>true ])
            ?>
        </div>
        <div data-options="region:'center'" border="false">
            <table id="dgv_select_program" class="easyui-datagrid"
                       data-options="fit:true,singleSelect:true,
                       onDblClickRow: function(index,row) { _ProgramDialog_Select(ui,index,row) },
                ">
                <thead><tr>
                        <th data-options="field:'PROGRAM_ID', width:80"><span style="font-size: 7.5pt">ID</span></th>
                        <th data-options="field:'PROGRAM_NAME', width:300"><span style="font-size: 7.5pt">PROGRAM</span></th>
                </tr></thead>
            </table>
        </div>
    </div>
</div>


<?php $this->bind_datagrid_dialog($this->Editor); ?>
