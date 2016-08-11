<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'north'" style=" background: #cccccc; height: 60px;">
        <div style="background: #000000; height:25px; color: #ffffff; overflow: hidden; text-align: center">
            <b><big>FGTA Form Layout Editor</big></b>
        </div>
        <table width="100%">
            <tr>
                <td width="120px">
                    <a id="btnSave" class="easyui-linkbutton c6" data-options="iconCls:'icon-save'">Save Layout</a>
                </td>
                <td>
                    <?php
                    global $_GET;
                    $editormode = array_key_exists('editormode', $_GET) ? $_GET['editormode'] : '';
                    if ($editormode=='search') {
                    ?>
                    <b>Search Form</b> |
                    <a href="?mode=app&ns=<?=$_GET['ns']?>&cl=<?=$_GET['cl']?>&devform=1">Main Form</a>
                    <?php } else { ?>
                    <a href="?mode=app&ns=<?=$_GET['ns']?>&cl=<?=$_GET['cl']?>&devform=1&editormode=search">Search Form</a>
                    | <b>Main Form</b>
                    <?php } ?>
                </td>
                <td align="right">
                    <a href="?mode=app&ns=<?=$_GET['ns']?>&cl=<?=$_GET['cl']?>">Run</a>
                </td>
            </tr>
        </table>
    </div>

    <div data-options="region:'east'" title="Properties" style="width:200px;">
        <table>
            <tr>
                <td><small>Name</small></td>
                <td><small><span id='fgta_edited_obj_name'></span></small></td>
            </tr>
            <tr>
                <td><small>Width</small></td>
                <td><input class="easyui-numberbox" id="fgta_edited_obj_width" style="width: 60px"></td>
            </tr>
        </table>
        <a id="btnSetWidth" class="easyui-linkbutton c2" style="height: 22px">Apply</a>
    </div>

    <div id="layouteditor" data-options="region:'center'" border="false" style="background: url('img/bg_devform.png')">
        <form id="formMain">
            <?php
            if ($editormode=='search') {
                $this->load_html_fgta_search($this->Search, true);
            } else {
                $this->load_html_control($this->Editor, true);
            }
            ?>
        </form>
    </div>

</div>
<script>

    var EDITED_OBJ = undefined;

    $(document).ready(function () {
        ui = new FGTA_uiBase();

        $("#btnSetWidth").bind('click', function(){
            var obj = EDITED_OBJ;
            var currwidth = obj.width();
            var newwidth = $("#fgta_edited_obj_width").numberbox('getValue');
            var obj_name = obj.attr('fgta-id');

            var grow = newwidth>currwidth ? (newwidth-currwidth) : -(currwidth-newwidth);




            var currentinputwidth = obj.inputwidth; //$("#" + obj_name).width();
            var newinputwidth = currentinputwidth + grow;
            var newspanwidth = currentinputwidth + grow - 2;
            var labelwidth = currwidth - currentinputwidth;
            var mininalwidth = labelwidth + 13;

            if (newinputwidth < 13) {
                alert ('Minimal lebar field adalah ' + mininalwidth + '['+ newinputwidth +']');
            } else {
                obj.inputwidth = newinputwidth;
                obj.width(newwidth);
                obj.find("span[class='textbox']").width(newspanwidth);
                obj.find(".textbox.combo").width(newspanwidth);

                $("#" + obj_name).width(newinputwidth)
                                 .css('width', (newinputwidth) + 'px');
            }
        });


        $(".fgta_field").each(function( index ) {
            var obj = $(this);
            $(this).click(function() {
                EDITED_OBJ = obj;
                var obj_name = obj.attr('fgta-id');

                $(".fgta_field").each(function( index ) {
                    $(this).removeClass("edited-field");
                });

                obj.addClass("edited-field");

                $("#fgta_edited_obj_name").html('<b>' + obj_name + '</b>');
                $("#fgta_edited_obj_width").numberbox('setValue', obj.width());

                var inputwidth = $("#" + obj_name).css("width").replace('px', '');
                obj.inputwidth = Number(inputwidth);

            });
        });

        $("#btnSave").bind('click', function(){
            $('#layouteditor').mask('Saving Layout...');


            var fields = [];
            $(".fgta_field").each(function( index ) {
                var obj = $(this);
                var obj_name = obj.attr('fgta-id');
                var top = obj.css("top").replace('px', '');
                var left = obj.css("left").replace('px', '');
                var width = obj.css("width").replace('px', '');

                fields.push({
                    name: obj_name, top: top, left: left, width: width,
                });
            });


            $.ajax({
    			type: "POST",
    			dataType: "json",
    			url: "service.json.php?ns=_default&cl=devform&sm=SaveLayout",
    			data: {
                    fields: fields,
                    ns: '<?php global $_GET; echo array_key_exists('ns', $_GET) ? $_GET['ns'] : ''; ?>',
                    cl: '<?php global $_GET; echo array_key_exists('cl', $_GET) ? $_GET['cl'] : ''; ?>',
                    editormode: '<?php global $_GET; echo array_key_exists('editormode', $_GET) ? $_GET['editormode'] : ''; ?>'
                },

        		success: function(result,status,xhr) {
    				try {
    					var data = ui.ProcessAjaxJsonResult(result,status,xhr);
    					if (data==null) throw "Invalid Group Data";


                        $('#layouteditor').unmask();
                    }
    				catch (err)
    				{
    				    $('#layouteditor').unmask();
    				    $.messager.alert("Save Layout", err, "warning").window({ shadow: false });
    				}

    			},

    			error: function(xhr,status,error) {
    				$('#layouteditor').unmask();
    				ui.ProcessErrorText("Save Layout", xhr, status, error);
    			}

            });

        });

    });
</script>
