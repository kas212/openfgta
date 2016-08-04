<script>
    var ui;

    $(document).ready(function () {
        ui = new TestdevClass();
        ui.canvas = $("#maincontent");




        ui.Init();
    });

</script>
<div id="maincontent" class="easyui-layout" data-options="fit:true">
    <a id="btnTestPrint" class="easyui-linkbutton c6" onclick="javascript: _TestPrint()">Test Print</a>
</div>
