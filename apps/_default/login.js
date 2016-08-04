
	var LoginClass = function()
	{
		$.extend(this, new FGTA_uiBase());
		var ui = this;

		this.getUsername = function() {
			return this.obj_username.textbox('getText');
		}

		this.getPassword = function() {
			return this.obj_password.textbox('getText');
		}


		this.doLogin = function() {
			$('#maincontent').mask('Wait...<br>Trying to log on to system...');

			$.ajax({
				type: "POST",
				dataType: "json",
				url: "service.json.php?ns=_default&cl=login&sm=dologin",
				data: {
					username: ui.getUsername(),
					password: ui.getPassword(),
				},
				success: function(result,status,xhr) {
					try
					{
						var data = ui.ProcessAjaxJsonResult(result,status,xhr);
						if (data==null) throw "invalid user";

						if ($('#obj_chk_remember').is(':checked')) {
							//remember login
							setCookie("isremember", 1, 7);
							setCookie("username", ui.getUsername(), 7);
							setCookie("userpass", ui.getPassword(), 7);
						} else {
							setCookie("isremember", 0, 1);
							setCookie("username", "", 1);
							setCookie("userpass", "", 1);
						}

						$('#maincontent').mask('redirecting to main page....');
						location.href = RedirectTo;

					}
					catch (err)
					{
						$('#maincontent').unmask();
						$.messager.alert("Login", err, "warning").window({shadow: false});
					}

				},

				error: function(xhr,status,error) {
					$('#maincontent').unmask();
					ui.ProcessErrorText("Login Error", xhr, status, error);
				},
			});




		}
	};
