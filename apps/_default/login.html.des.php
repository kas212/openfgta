	<script>


		var RedirectTo = '<?=$RedirectTo?>';
		var ui;
		$(document).ready(function () {
			ui = new LoginClass();

			ui.obj_username = $('#obj_txt_username');
			ui.obj_password = $('#obj_txt_password');

			ui.obj_username.textbox('textbox').bind('keydown', function(e) {
				if (e.keyCode==13) {
					ui.obj_password.textbox('textbox').focus();
				}
			});

			ui.obj_password.textbox('textbox').bind('keydown', function(e) {
				if (e.keyCode==13) {
					ui.doLogin();
				}
			});



			// baca data dari cookie
			var isremember = getCookie("isremember");
			if (isremember==1) {
				$('#obj_chk_remember').prop('checked', true);
				ui.obj_username.textbox('setText', getCookie("username"));
				ui.obj_password.textbox('setText', getCookie("userpass"));
			}


		});

	</script>


	<div id="maincontent" data-options="region:'center'" style="background-color: #000000">
		<div style="margin:100px 0;"></div>
		<div id ="loginbox" class="easyui-panel" title="Login to system" headerCls="bpanelheader" bodyCls="bpanelbody" data-options="style:{margin:'0 auto'}" style="width:400px; height:300px; padding:30px 70px 0px 70px; background: <?=$this->GetBgColor()?> ">
			<div style="margin-bottom:10px">
				<input id="obj_txt_username" class="easyui-textbox" style="width:100%;height:40px;padding:12px" data-options="prompt:'Username',iconCls:'icon-man',iconWidth:38">
			</div>
			<div style="margin-bottom:20px">
				<input id="obj_txt_password" class="easyui-textbox" type="password" style="width:100%;height:40px;padding:12px" data-options="prompt:'Password',iconCls:'icon-lock',iconWidth:38">
			</div>
			<div style="margin-bottom:20px">
				<input id="obj_chk_remember" type="checkbox">
				<span><label for="obj_chk_remember">Remember Me</label></span>
			</div>
			<div style="padding-bottom: 10px; width:100%;">
				<a class="easyui-linkbutton <?=$this->GetButtonColor()?>" style="padding:5px 0px;width:100%;" onclick="javascript: ui.doLogin()">
					<span style="font-size:14px;">Login</span>
				</a><br>
			</div>
			<div style="font-size:10px; text-align: center;" >
				<a href="javascript:location.href='container.mob.php?'">Mobile Version</a>
			</div>
		</div>
	</div>
