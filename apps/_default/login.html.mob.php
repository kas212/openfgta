<script>
    var RedirectTo = '<?=$RedirectTo?>';
    var ui;

    $(document).ready(function () {
        ui = new LoginClass();

        ui.obj_username = $('#obj_txt_username');
        ui.obj_password = $('#obj_txt_password');

        // baca data dari cookie
        var isremember = getCookie("isremember");
        if (isremember==1) {
            $('#obj_chk_remember').prop('checked', true).checkboxradio('refresh');
            ui.obj_username.val(getCookie("username"));
            ui.obj_password.val(getCookie("userpass"));
        }

        ui.getUsername = function() {
			return ui.obj_username.val();
		}

        ui.getPassword = function() {
			return ui.obj_password.val();
		}


    });

</script>


<div id="maincontent" data-role="page">
    <div data-role="header">
        <h1>Login to System</h1>
    </div>

    <div data-role="main" class="ui-content">
        <div style="padding: 7px">
        <input type="text" name="obj_txt_username" id="obj_txt_username" placeholder="Username">
        <input type="password" name="obj_txt_password" id="obj_txt_password" placeholder="Password">

        <input type="checkbox" name="obj_chk_remember" id="obj_chk_remember">
        <label for="obj_chk_remember" style="border:0; background:#fff;">Remember Me</label>


        <button class="ui-btn" style="background-color:#2984a4; border-color:#1f637b; color: #fff; text-shadow: none" onclick="javascript: ui.doLogin()">Login</button>

        <div style="font-size: 10px" align="center">
            <a href="javascript:location.href='container.des.php?'">Desktop Version</a>
        </div>

        </div>
    </div>



    <div data-role="footer" data-position="fixed">
    </div>
</div>

<style>
    .ui-checkbox { display: flex }
</style>
