<script>
    var ui;

    $(document).ready(function () {
        ui = new TestdlgClass();
        ui.canvas = $("#maincontent");


        <?php
        $this->bind_editor($this->Editor);
        ?>

        ui.Init();
    });

</script>
<div id="maincontent" class="easyui-layout" data-options="fit:true">
    <div data-options="region:'center'" border="false" style="padding: 0px 10px 5px 10px">
        <?php $this->load_html_control($this->Editor); ?>
    </div>
</div>
