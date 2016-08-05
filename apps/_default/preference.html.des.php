<script>

	var ui;
    var WELCOMEPAGE = [{id:'_default/fgtatoday', text:'FGTA_Today'}];

	var PreferenceClass = function () {
		$.extend(this, new FGTA_uiBase());
		ui = this;
		ui.NS = '_default';
		ui.CL = 'preference';

		this.Init = function () {
			var username = '<?=$_SESSION['username']?>';
			var disable = (username=='root') ? 'disable' : 'enable';

			ui.obj_txt_PASSOLD.textbox(disable);
			ui.obj_txt_PASS1.textbox(disable);
			ui.obj_txt_PASS2.textbox(disable);
			ui.obj_cbo_WELCOME.combobox(disable);

			ui.obj_Profile.prop('disabled', (username=='root') ? true : false);
			ui.btnSave.linkbutton(disable);

			OpenData(username);

		};
	}

	$(document).ready(function () {
		ui = new PreferenceClass();
        ui.canvas = $("#maincontent");
		ui.obj_txt_USERNAME = $("#obj_txt_USERNAME");
		ui.obj_txt_FULLNAME = $("#obj_txt_FULLNAME");
		ui.obj_txt_PASSOLD = $("#obj_txt_PASSOLD");
		ui.obj_txt_PASS1 = $("#obj_txt_PASS1");
		ui.obj_txt_PASS2 = $("#obj_txt_PASS2");
		ui.obj_cbo_WELCOME = $("#obj_cbo_WELCOME");
		ui.obj_Profile = $("#obj_Profile");
		ui.btnSave = $("#btnSave");

		ui.Init();

		$("#obj_Profile").on('change',function(e){
			var f = e.target.files[0];
			var reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					//alert(e.target.result);
					//var img = new Image;
					$("#image").prop("src", e.target.result);
				}
			})(f);
			reader.readAsDataURL(f);
		});
	});


	function OpenData(username) {
		ui.canvas.mask('Loading data for ' + username);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: FGTA_ServiceUrl(ui.NS,ui.CL,'GetPrefData'),
			data: {
				username: username
			},
			success: function(result, status, xhr) {
				try {
					var data = ui.ProcessAjaxJsonResult(result, status, xhr);
					if (data == null) throw "invalid data";

					ui.obj_txt_USERNAME.textbox('setValue', username);
					ui.obj_txt_FULLNAME.textbox('setValue', data.fullname);
					ui.obj_cbo_WELCOME.combobox('setValue', '_default/fgtatoday');

					$("#image").prop("src", FGTA_ServiceUrl(ui.NS,ui.CL,'GetImage')+"&username=" + username);
					$("#obj_Profile").val('');

					ui.canvas.unmask();
				}
				catch (err) {
					ui.canvas.unmask();
					$.messager.alert("OpenData", err.replace("\\r", '').replace("\\n", '<br />'), "error").window({shadow:false});
				}
			},
			error: function(xhr,status,error) {
				ui.canvas.unmask();
				ui.ProcessErrorText("Webservice GetPrefData Error", xhr, status, error);
			}
		});
	}


	function Save() {
		ui.canvas.mask('Saving Preference');

		$.ajax({
			type: "POST",
			dataType: "json",
			url: FGTA_ServiceUrl(ui.NS,ui.CL,'SavePrefData'),
			data: {data:{
				username: ui.obj_txt_USERNAME.textbox('getValue'),
				passold: ui.obj_txt_PASSOLD.textbox('getValue'),
				pass1: ui.obj_txt_PASS1.textbox('getValue'),
				pass2: ui.obj_txt_PASS2.textbox('getValue')
			}},
			success: function(result, status, xhr) {
				try {
					var data = ui.ProcessAjaxJsonResult(result, status, xhr);
					if (data == null) throw "invalid data";
					if (data.success != true) throw 'Error on save';

					var username = data.username;
					var pic = document.getElementById("obj_Profile");
					var file = pic.files[0];

					ui.obj_txt_PASSOLD.textbox('clear');
					ui.obj_txt_PASS1.textbox('clear');
					ui.obj_txt_PASS2.textbox('clear');



					if (file!=undefined) {
						var xhr = new XMLHttpRequest();
						(xhr.upload || xhr).addEventListener('progress', function(e) {
						        var done = e.loaded
						        var total = e.total;
								var percent = Math.round(done/total*100) + '%';
								ui.canvas.mask('Uploading File... (' + percent + ')');
						});

						xhr.addEventListener('load', function(e) {
						   //console.log('xhr upload complete' , e, this.responseText);
						   if (this.responseText!='ok') {
							   $.messager.alert("Upload Image Error", this.responseText.replace("\\r", '').replace("\\n", '<br />'), "error");
						   } else {
							   $.messager.alert("Preference", "Changed has been saved." , "info").window({shadow:false});
						   }
						   ui.canvas.unmask();
					   	});

						var postdata = new FormData;

						xhr.open('post', FGTA_ServiceUrl(ui.NS,ui.CL,'UploadImage'), true);
						postdata.append('file', file);
						postdata.append('username',  ui.obj_txt_USERNAME.textbox('getValue'));
						xhr.send(postdata);


					}
					else
					{
						$.messager.alert("Preference", "Changed has been saved." , "info").window({shadow:false});
						ui.canvas.unmask();
					}
				}
				catch (err) {
					ui.canvas.unmask();
					$.messager.alert("Save Error", err.replace("\\r", '').replace("\\n", '<br />'), "error").window({shadow:false});
				}
			},
			error: function(xhr,status,error) {
				ui.canvas.unmask();
				ui.ProcessErrorText("Webservice SavePrefData Error", xhr, status, error);
			}
		});
	}

</script>

<div id="maincontent" class="easyui-layout" data-options="fit:true">
	<div data-options="region:'center'" border="false" style="padding: 0px 10px 5px 10px">
		<form id="formMain">

	        <?php
	        new FGTA_Control_Textbox(['name'=>'obj_txt_USERNAME', 'label'=>'Username', 'directrender'=>true, 'location'=>[30, 40, 200], 'options'=>'disabled:true' ]);
	        new FGTA_Control_Textbox(['name'=>'obj_txt_FULLNAME', 'label'=>'Full Name', 'directrender'=>true, 'location'=>[60, 40, 350], 'options'=>'disabled:true' ]);

	        new FGTA_Control_Textbox(['name'=>'obj_txt_PASSOLD', 'label'=>'Password', 'password'=>true, 'directrender'=>true, 'location'=>[130, 40, 200], 'options'=>"" ]);
	        new FGTA_Control_Textbox(['name'=>'obj_txt_PASS1', 'label'=>'New', 'password'=>true, 'directrender'=>true, 'location'=>[160, 40, 200], 'options'=>"" ]);
	        new FGTA_Control_Textbox(['name'=>'obj_txt_PASS2', 'label'=>'Re-Enter', 'password'=>true, 'directrender'=>true, 'location'=>[190, 40, 200], 'options'=>"" ]);

	        new FGTA_Control_Combobox(['name'=>'obj_cbo_WELCOME', 'label'=>'1stPage', 'directrender'=>true, 'location'=>[240, 40, 400], 'options'=>"editable:false,valueField:'id',textField:'text',data:WELCOMEPAGE " ]);
	        ?>


	        <div style="position:absolute; top:100px; left:40px; font-size: 8pt">
	            Untuk mengganti password, isikan password lama<br>
	            dan password baru berikut:
	        </div>


			<div class="fgta_field" style="top:10px; left:450px; width:250px; border: 0px ">
				<img id="image" height="300" width="300"/>
				<input id="obj_Profile" type="file">
			</div>

	        <div style="position:absolute; top:300px; left:40px; font-size: 8pt">
	            <a id="btnSave" class="easyui-linkbutton c2" href="javascript:Save()">Simpan Perubahan</a>
	        </div>

		</form>
	</div>
</div>
