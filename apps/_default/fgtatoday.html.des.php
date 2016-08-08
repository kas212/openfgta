<script>
    var ui;

	$(document).ready(function () {


	});
</script>

<div id="maincontent" class="easyui-layout" data-options="fit:true">

	<div data-options="region:'south'" border="false"

	     style="height:18px;
				text-align: right;
				-moz-user-select: text;
				-khtml-user-select: text;
				-webkit-user-select: text;
				-ms-user-select: text;
				user-select: text;
	">
		<small>sessid : <?=session_id()?></small>
	</div>

	<div data-options="region:'center'" border="false"
        style="padding: 0px 10px 5px 10px;
                -moz-user-select: none;
                -khtml-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
                user-select: none;
        ">



        <div class="easyui-layout" data-options="fit:true">

            <div data-options="region:'north'" border="false" style="height: 100px">
                <div style="float: right; padding: 0px 0px 0px 0px; margin: 10px 5px; width:80px;height:80px;border-radius:100px;overflow:hidden">
                    <img  src="service.json.php?ns=_default&cl=preference&sm=GetImage&username=<?=$_SESSION['username']?>" style="margin:0;width:100%;height:100%;">
                </div>
                <div style="padding: 10px 0px 5px 0px;">
        			<div>
        				<big><big><b><?=__PAGE_TITLE?> Today!</b></big></big><br>
                        <div style="padding: 10px 0px 5px 0px;">Welcome, <?=$_SESSION['userfullname']?></div>
        			</div>
        		</div>
            </div>

            <div data-options="region:'east'" border="false" style="width: 300px">
                <div class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'north'" border="false" style="height: 200px">
                        Event
                    </div>
                    <div data-options="region:'center'" border="false">
                        Article
                    </div>
                </div>
            </div>

            <div data-options="region:'center'" border="false">
                news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>
                news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>
                news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>
                news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>
                news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>
                news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>news<br>
            </div>

        </div>


	</div>
</div>
