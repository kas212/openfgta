<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$TITLE?></title>

    <?php if (defined('__MPAGE_STATE_LOGIN') || defined('__MPAGE_STATE_APP') ) { ?>
    <link rel="stylesheet" type="text/css" href="<?=__EASYUI_PATH?>/themes/metro/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?=__EASYUI_PATH?>/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?=__EASYUI_PATH?>/themes/color.css">
    <?php } ?>
    <?php if (!defined('__MPAGE_STATE_APP')) { ?><link rel="stylesheet" type="text/css" href="<?=__JQUERYMOBILE_CSS?>"><?php } ?>
    <style>
        .messager-button .l-btn { background: #ccc; }
        .messager-window { background: #ccc; }

        .loadmask { z-index: 1000; position: absolute; top:0; left:0; -moz-opacity: 0.5; opacity: .50; filter: alpha(opacity=50); background-color: #CCC; width: 100%; height: 100%; zoom: 1; }
		.loadmask-msg { z-index: 20001; position: absolute; top: 0; left: 0; border:1px solid #079358; background: #000000; padding:2px; }
		.loadmask-msg div { padding:5px 10px 5px 25px; background: #fbfbfb url('img/loading-2.gif') no-repeat 5px 5px;	line-height: 16px; border:1px solid #a3bad9; color:#222; font:normal 11px tahoma, arial, helvetica, sans-serif; cursor:wait; }
		.masked { overflow: hidden !important; }
		.masked-relative { position: relative !important; }
		.masked-hidden { visibility: hidden !important; }


        <?php if (!defined('__MPAGE_STATE_APP') && !defined('__MPAGE_STATE_LOGIN')) { ?>
        /* agar iframe di container bisa mepet */
        html,body{overflow-y:hidden}
        .frame { height: 100% ; width: 100% ; border: 0  ; background-color: green ; }
        .content { height: 100%; width: 100%; overflow-y: hidden; }
        .ui-content { margin: 0 !important; padding: 0 !important; border: 0 !important; outline: 0 !important; height: 100%; overflow: hidden; }
        <?php } ?>

    </style>
	<!-- BEGIN DYNAMIC STYLE -->
	<?php foreach ($Styles->data as $style) { ?><link rel="stylesheet" href="<?=$this->GetResourceUrl($style)?>" type="text/css" />
	<?php } ?><!-- END DYNAMIC STYLE -->


    <script type="text/javascript" src="<?=__JQUERY?>"></script>
    <?php if (!defined('__MPAGE_STATE_APP')) { ?><script type="text/javascript" src="<?=__JQUERYMOBILE_JS?>"></script><?php } ?>
    <?php if (defined('__MPAGE_STATE_LOGIN') || defined('__MPAGE_STATE_APP')) { ?><script type="text/javascript" src="<?=__EASYUI_PATH?>/jquery.easyui.min.js"></script><?php } ?>

    <script type="text/javascript" src="js/jquery-loadmask.js"></script>


	<script>

    	function Relogin() { location.href = "container.mob.php"; }

        function FGTA_ServiceUrl(ns,cl,sm,param) {
            p = (param==undefined || param==null) ? '' : '&' + param;
            return 'service.json.php?dev=mob&ns=' + ns + '&cl=' + cl +'&sm='+ sm + p
        }

    	function setCookie(cname, cvalue, exdays) {
    	    var d = new Date();
    	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    	    var expires = "expires="+d.toUTCString();
    	    document.cookie = cname + "=" + cvalue + "; " + expires;
    	}

    	function getCookie(cname) {
    	    var name = cname + "=";
    	    var ca = document.cookie.split(';');
    	    for(var i = 0; i < ca.length; i++) {
    	        var c = ca[i];
    	        while (c.charAt(0) == ' ') {
    	            c = c.substring(1);
    	        }
    	        if (c.indexOf(name) == 0) {
    	            return c.substring(name.length, c.length);
    	        }
    	    }
    	    return "";
    	}


		function ProcessAjaxJsonResult(result,status,xhr) {
			if (xhr.responseText==null || xhr.responseText=='null' || xhr.responseText==undefined)
			{
				var querystring = xhr.getResponseHeader('QueryString');
				$.messager.alert("WebMethodException",  "WebMethod doesn't return WebResponse datatype.<br><br>" + "QueryString:<br><i>" + querystring + "</i>", 'error');
			}

			var WebResult = jQuery.parseJSON(xhr.responseText);
			return WebResult.Result;

		};


		function ProcessErrorMessage(title, message, xhr, status, error) {
			this.ProcessErrorText(title, xhr, status, error, undefined, message);
		};

		function ProcessErrorText(title, xhr, status, error, service_url, hmessage) {

			if (xhr.responseText.substring(0, 12)=="[SESSIONEND]") {
				if (window.self !== window.top) {
					parent.Relogin();
				} else {
					location.href = "container.des.php";
				}
				return;
			}


			if (xhr.responseText.substring(0, 11)=="_DEBUGTEXT:" || xhr.responseText.substring(0, 13) == "WEBEXCEPTION:")
			{

				var pattern1 = /\[(.*?)\]/g;
				var pattern2 = /Exception](.*)/;

				var match;
				var textdata;
				var dialogtitle;
				var dialogmessage;


				if (xhr.responseText.substring(0, 11)=="_DEBUGTEXT:")
				{
					textdata = xhr.responseText.replace("_DEBUGTEXT:", "");
					dialogtitle = "DEBUG";
					dialogmessage = textdata;
				}
				else
				{
					textdata = xhr.responseText.replace("WEBEXCEPTION:", "");


					match = pattern1.exec(textdata);
					dialogtitle = title + " - " + match[1];

					match = pattern2.exec(textdata);
					dialogmessage = match[1];

					if (service_url!=undefined)
						dialogmessage = match[1] + '\\r\\n' + service_url;
					else
						dialogmessage = match[1];

				}

				hmessage = hmessage==undefined? '' : hmessage + '<br><br>';

				$.messager.alert({
					title: dialogtitle,
					msg: '<div style="height:100px">'+ hmessage + textdata.replace("\\r", '').replace("\\n", '<br />') +'</div>',
					icon: 'error',
					shadow: false,
					width: 600
				});

			}
			else
			{
				var querystring = xhr.getResponseHeader('QueryString');
				$('#cnt_messagebox').dialog({
					content: "<table style='-moz-user-select: text;-khtml-user-select: all;-webkit-user-select: all;-ms-user-select: all;user-select: all;'><tr><td><i>" + querystring + "</i></td></tr><tr><td>" + xhr.responseText + "<hr>" + error + "</td></tr></table>",
					title: 'Response Text',
					headerCls: 'messager-window',
					shadow: false
				});
				$('#cnt_messagebox').parent().css( "background-color", "#ccc" );
				$('#cnt_messagebox').dialog('center');
				$('#cnt_messagebox').dialog('open');
			}
		};

        <?php if (defined('__MPAGE_STATE_APP')) { ?>

        <?php } ?>

	</script>

    <script type="text/javascript" src="js/fgta_object.js"></script>
	<script type="text/javascript" src="js/fgta_formdata.js"></script>
    <script type="text/javascript" src="js/fgta_editor.js"></script>
	<script type="text/javascript" src="js/fgta_uibase.js"></script>

	<!-- BEGIN DYNAMIC SCRIPT -->
	<?php foreach ($Scripts->data as $script) { ?><script type="text/javascript" src="<?=$this->GetResourceUrl($script)?>"></script>
	<?php } ?><!-- END DYNAMIC SCRIPT -->


</head>
<body>

    <?=$BODYTEXT_MESSAGE?>
    <?php
    if (!$this->BYPASS_TEMPLATE_RENDERING) {
        require_once $TEMPLATE;
    }
    ?>

	<div id="cnt_messagebox" class="easyui-dialog" style="width:500px;height:300px;" data-options="resizable:true,modal:true,closed:true"></div>
</body>
</html>
