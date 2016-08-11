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
                    <a href="javascript:parent._Preference_Open();"><img  src="service.json.php?ns=_default&cl=preference&sm=GetImage&username=<?=$_SESSION['username']?>" style="margin:0;width:100%;height:100%;"></a>
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
                    <div data-options="region:'north'" border="false" style="height: 200px;">
                        <div style="height: 25px"><b>:: Pengumuman</b></div>
                        <div  class="easyui-panel" data-options="fit:true" style="border: 0px; border-left: 1px #CCCCCC solid">
                            <div style="border-left: 2px #CCCCCC solid; padding-left: 5px">
								<?php

				                    $rows = $this->GetTodayContent('EVENT', 3);
				                    foreach ($rows as $row) {
				                ?>
			                    <b><?=$row['CONTENT_TITLE']?></b><br>
			                    <?=substr($row['CONTENT_TEXT'],0,30)?>
								<hr style="border-top: dashed 1px; color: #DDDDDD" />
				                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <div data-options="region:'center'" border="false" style="padding-top: 20px">
                        <div style="height: 25px"><b>:: Article</b></div>
                        <div  class="easyui-panel" data-options="fit:true" style="border: 0px; border-left: 1px #CCCCCC solid">

							<?php
								$rows = $this->GetTodayContent('ARTICLE', 10);
								foreach ($rows as $row) {
							?>
							<div style="border-left: 2px #CCCCCC solid; padding-left: 5px">
                                <b><?=$row['CONTENT_TITLE']?></b><br>
                                <span style="color: #999999"><small>9 Juni 2019</small></span><br>
                                <?=substr($row['CONTENT_TEXT'],0,30)?>
                                <hr style="border-top: dashed 1px; color: #DDDDDD" />
                            </div>

							<?php } ?>


                        </div>
                    </div>
                </div>
            </div>

            <div data-options="region:'center'" border="false">
                <?php
                    $rows = $this->GetTodayContent('NEWS');
                    foreach ($rows as $row) {
                ?>
                <div style="border-left: 2px #CCCCCC solid; padding-left: 5px; margin-bottom: 15px; margin-right: 10px">
                    <b><?=$row['CONTENT_TITLE']?></b><br>
                    <span style="color: #999999"><small>9 Juni 2019</small></span><br>
                    <?=substr($row['CONTENT_TEXT'],0,200)?>
                </div>
                <?php } ?>

            </div>

        </div>


	</div>
</div>
