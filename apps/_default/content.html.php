<script>
    var ui;
    var DATA = {
            };

    $(document).ready(function () {
        ui = new contentClass();
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
							<div title="Content" data-options="allowaddremove:false" style="padding-top: 10px">
                                <input id="obj_txt_CONTENT_TEXT" class="easyui-textbox" maxlength="65535" data-options="fit:true,multiline:true, onChange: function(newvalue, oldvalue) { ui.Editor.setDataChanges(); }" >
                            </div>
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
