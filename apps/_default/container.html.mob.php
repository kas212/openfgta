<script>

    $(document).ready(function () {
        document.getElementById('content').style.height = (window.innerHeight-40-20)+"px";
        document.getElementById('content').style.width = (window.innerWidth)+"px";
        document.getElementById('mnu_program').style.height = (window.innerHeight-265)+"px";


		$("#obj_cbo_group").bind( "change", function(event, ui) {
			var group_id = $("#obj_cbo_group option:selected").val();
			if (group_id==null)
				return;

			OpenData_Group(	group_id);

		});

		LoadData_Group();
    });

	$( document ).on( "pagecreate", "#maincontent", function() {
		$( document ).on( "swipeleft swiperight", "#maincontent", function( e ) {
			// We check if there is no open panel on the page because otherwise
			// a swipe to close the left panel would also open the right panel (and v.v.).
			// We do this by checking the data that the framework stores on the page element (panel: open).
			if ( $( ".ui-page-active" ).jqmData( "panel" ) !== "open" ) {
				if ( e.type === "swipeleft" ) {
					$( "#right-panel" ).panel( "open" );
				} else if ( e.type === "swiperight" ) {
					$( "#left-panel" ).panel( "open" );
				}
			}
		});
	});


    $( window ).resize(function() {
        document.getElementById('content').style.height = (window.innerHeight-40-20)+"px";
        document.getElementById('content').style.width = (window.innerWidth)+"px";
        document.getElementById('mnu_program').style.height = (window.innerHeight-265)+"px";
    });

    function openiframe(o, loc) {
        //alert('test');
        $('#left-panel').mask();
        $('#maincontent').mask('Loading...');

        var program = {};
        program.url = loc; //'container.mob.php?mode=app&ns=cobafgta&cl=halo';
        program.title = o.title;

        $('#content').attr('src', program.url);
        $('#content').attr('title', program.title);



    }


    function iframeloaded() {
        $('#contenttitle').html($('#content').attr('title'));
        $("#left-panel" ).panel( "close" );
        $('#maincontent').unmask();
        $('#left-panel').unmask();
    }

	function LoadData_Group() {

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "service.json.php?ns=_default&cl=group&sm=LoadGroupMobile",
			data: {},
			success: function(result,status,xhr) {
				try
				{
					var groups = result.Result.groups;

					if (groups.length==0)
						return;

					var options = '';
					for (var i=0; i < groups.length; i++) {
						options += '<option value="'+ groups[i].group_id +'">'+ groups[i].group_name +'</option>';
					}
					$("#obj_cbo_group").html(options).selectmenu('refresh', true);

					OpenData_Group(groups[0].group_id);
				}
				catch (err)
				{
				    //$.messager.alert("_ComboboxGroup_LoadData", err, "warning").window({ shadow: false });
					alert('LoadData_Group: ' + err);
				}
			},

			error: function(xhr,status,error) {
				//ui.ProcessErrorText("_ComboboxGroup_LoadData", xhr, status, error);
				alert('LoadData_Group Webservice: ' + err);
			}
		});

	}

	function OpenData_Group(group_id) {
		// $(".mySelect option:selected").val()

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "service.json.php?ns=_default&cl=program&sm=LoadGroupProgramMobile",
			data: {
				group_id : group_id
			},
			success: function(result,status,xhr) {
				try
				{
					var programs = result.Result.programs;

					if (programs.length==0)
						return;

					var li = '';
					for (var i=0; i < programs.length; i++) {
						li += CreateProgramLi(programs[i].title, programs[i].url);
					}

					$("#mnu_program").html(li).listview('refresh', true);

				}
				catch (err)
				{
				    //$.messager.alert("_ComboboxGroup_LoadData", err, "warning").window({ shadow: false });
					alert('OpenData_Group: ' + err);
				}
			},

			error: function(xhr,status,error) {
				//ui.ProcessErrorText("_ComboboxGroup_LoadData", xhr, status, error);
				alert('OpenData_Group Webservice: ' + err);
			}
		});
	}

	function CreateProgramLi(title, url) {
		return "<li><a href=\"javascript:void(0)\" onclick=\"openiframe(this, '"+ url +"')\" title='"+ title +"'>"+ title +"</a></li>";
	}


</script>

<style>
.list-view {
            height: 100px;
            top: 0px;
            overflow: auto;
            -webkit-overflow-scrolling:touch;
           }
</style>


<div id="maincontent" data-role="page"  data-url="maincontent">
    <div data-role="header"  >
        <h1 id="contenttitle"></h1>
        <a href="#left-panel" style="background-color: #bbb" data-theme="a" data-icon="bars" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-nodisc-icon">Open left panel</a>
    </div>
    <div role="main" class="ui-content">
        <iframe id="content" frameborder="0" src="?mode=app&ns=_default&cl=welcome" onload="javascript:iframeloaded()" title="Welcome"></iframe>
    </div>
    <div  id="left-panel" data-role="panel"  data-display="overlay" data-theme="a">
    <!-- LEFT PANEL -->
            <div style="margin:0px auto;width:100px;height:100px;border-radius:100px;overflow:hidden">
                <img  src="service.json.php?ns=_default&cl=preference&sm=GetImage&username=<?=$_SESSION['username']?>" style="margin:0;width:100%;height:100%;">
            </div>

            <center><b><?=$USERFULLNAME?></b></center><br>


            <select name="obj_cbo_group" id="obj_cbo_group">
            </select>

            <ul id="mnu_program" data-role="listview"  class="list-view"  data-inset="true">
            </ul>

            <a href="javascript:location.href='?mode=logout'">Logout</a>


    <!-- END LEFT PANEL -->
    </div>

    <div data-role="footer" data-position="fixed" style="font-size: 8px">
        <center><?=__FG_FOOTER_CREDIT?></center>
    </div>
</div>
