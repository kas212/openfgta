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

	        <div style="float: right; padding: 0px 0px 0px 0px; margin: 10px 5px; width:30px;height:30px;border-radius:100px;overflow:hidden">
	            <img  src="service.json.php?ns=_default&cl=preference&sm=GetImage&username=<?=$_SESSION['username']?>" style="margin:0;width:100%;height:100%;">
	        </div>

			<div style="padding: 10px 0px 5px 0px;">

				<div style="margin: 10px 5px;">
					<big><b>Selamat Datang, <?=$_SESSION['userfullname']?></b></big>
				<div>


				<br><br>	
				<?=array_key_exists('WELCOME_ERROR_MESSAGE', $_SESSION) ? $_SESSION['WELCOME_ERROR_MESSAGE'] : ''?>


			</div>

		</div>
	</div>
