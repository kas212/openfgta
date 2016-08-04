<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
    <title><?=$TITLE?></title>
    <link rel="stylesheet" type="text/css" href="<?=__EASYUI_PATH?>/themes/metro/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?=__EASYUI_PATH?>/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?=__EASYUI_PATH?>/themes/color.css">

	<link rel="stylesheet" type="text/css" href="css/icon.css">
    <link rel="stylesheet" type="text/css" href="css/checkbox.css">


    <style>
		html,body{
			margin:0;
			padding:0;
	    }

		body{
		    font-family:verdana,helvetica,arial,sans-serif;
			background:#fff;
			text-align:center;
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
		}



		.loadmask {
			z-index: 1000;
			position: absolute;
			top:0;
			left:0;
			-moz-opacity: 0.5;
			opacity: .50;
			filter: alpha(opacity=50);
			background-color: #CCC;
			width: 100%;
			height: 100%;
			zoom: 1;
		}
		.loadmask-msg {
			z-index: 20001;
			position: absolute;
			top: 0;
			left: 0;
			border:1px solid #079358;
			background: #000000;
			padding:2px;
		}
		.loadmask-msg div {
			padding:5px 10px 5px 25px;
			background: #fbfbfb url('img/loading-2.gif') no-repeat 5px 5px;
			line-height: 16px;
			border:1px solid #a3bad9;
			color:#222;
			font:normal 11px tahoma, arial, helvetica, sans-serif;
			cursor:wait;
		}
		.masked {
			overflow: hidden !important;
		}
		.masked-relative {
			position: relative !important;
		}
		.masked-hidden {
			visibility: hidden !important;
		}

        #main_tabs .tabs-header { background: #ccc; }

        .bpanelheader { background: #ccc; }
		.bpanelbody { background: #eee; }
        .fgta_field { position: absolute; height: 21px; border-bottom: 1px solid #dddddd }
        .fgta_label { width: 60px; float:left; font-size: 8pt; text-align: right; padding: 5px 10px 0px 0px }
        .messager-button .l-btn { background: #ccc; }
		.messager-window { background: #ccc; }
        .window { background-color: #ccc; }
		.layout-split-west { border-right: 5px solid #ccc; }
		.layout-expand-west { background: #ccc; }
		.tabs li a.tabs-inner { background: #eee; }
		.l-btn-disabled, .l-btn-disabled:hover { opacity: 0.3; }
        .datagrid-header-row { background: #888; color: #fff; font-weight: bold; }
        .datagrid-row-over { cursor: pointer; }
        .datagrid-row-selected { background: #338FFF; color: #FFFFFF }

        .datagrid-header { background: #aaa; }
        .panel-body { background: #f6f6f6 }
        .tabs li.tabs-selected a.tabs-inner { background: #f6f6f6; border-bottom: 1px solid #f6f6f6; }
        .datagrid-body { background: #ffffff }
        .datagrid-pager {  background: rgb(221, 221, 221) none repeat scroll 0% 0% }

        .edited-field { border: 1px dashed #0000FF }

		.fgta-icon-folder{
			background:url('icon/folder.png') no-repeat center center;
		}

        <?php
        global $_GET;
        if (array_key_exists('mode', $_GET))
        if ($_GET['mode']=='app') {  ?>
        .fgta-textbox-text-readandwrite { background: #FFE095; }
        .fgta-textbox-text-readonly { background: #f9f9f9; }
        .textbox-text-noneditable { background: #eee; }
        .numberbox .textbox-text{ text-align: right; }

        <?php }  ?>


		<?php
		// hanya di container
		if (!array_key_exists('mode', $_GET)) {
			if ($dh = opendir(dirname(__FILE__).'/icon/program')){
			    while (($file = readdir($dh)) !== false) {
					if ($file=='.' || $file=='..')
						continue;

					$filename = str_replace('.png', '', $file);
					$filename = str_replace('.', '-', $filename);

					echo "        .icon-mnutree-$filename { background:url('icon/program/$file') no-repeat center center; }\n";
			    }
			    closedir($dh);
			}
		}
		?>

    </style>
	<!-- BEGIN DYNAMIC STYLE -->
	<?php foreach ($Styles->data as $style) { ?><link rel="stylesheet" href="<?=$this->GetResourceUrl($style)?>" type="text/css" />
	<?php } ?><!-- END DYNAMIC STYLE -->



    <script type="text/javascript" src="<?=__JQUERY?>"></script>
    <script type="text/javascript" src="<?=__EASYUI_PATH?>/jquery.easyui.min.js"></script>
	<!--<script type="text/javascript" src="<?=__EASYUI_PATH?>/jquery.easyui.patch.js"></script>-->
    <script type="text/javascript" src="js/jquery-loadmask.js"></script>

    <!-- TEMPLATE SCRIPT -->
    <script>

	function Relogin() {
		location.href = "container.des.php";
	}

    function FGTA_ServiceUrl(ns,cl,sm,param) {
        p = (param==undefined || param==null) ? '' : '&' + param;
        return 'service.json.php?dev=des&ns=' + ns + '&cl=' + cl +'&sm='+ sm + p
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

    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    </script>


    <?php
    global $_GET;
    if (array_key_exists('mode', $_GET))
    if ($_GET['mode']=='app') {  ?>
    <!-- PAGE ONLY SCRIPT -->
    <script>



    /*
    history.pushState(null, null, 'no-back-button');
    window.addEventListener('popstate', function(event) {
      history.pushState(null, null, 'no-back-button');
    });
    */
    $(document).unbind('keydown').bind('keydown', function (event) {
        var doPrevent = false;
        if (event.keyCode === 8) {
            var d = event.srcElement || event.target;
            if ((d.tagName.toUpperCase() === 'INPUT' &&
                 (
                     d.type.toUpperCase() === 'TEXT' ||
                     d.type.toUpperCase() === 'PASSWORD' ||
                     d.type.toUpperCase() === 'FILE' ||
                     d.type.toUpperCase() === 'SEARCH' ||
                     d.type.toUpperCase() === 'EMAIL' ||
                     d.type.toUpperCase() === 'NUMBER' ||
                     d.type.toUpperCase() === 'DATE' )
                 ) ||
                 d.tagName.toUpperCase() === 'TEXTAREA') {
                doPrevent = d.readOnly || d.disabled;
            }
            else {
                doPrevent = true;
            }
        }

        if (doPrevent) {
            event.defaultPrevented();
        }
    });


    (function($){
    	var plugin = $.fn.textbox;
    	$.fn.textbox = function(options, param){
    		if (typeof options == 'string'){
    			return plugin.call(this, options, param);
    		} else {
    			return this.each(function(){
    				plugin.call($(this), options, param);
    				var opts = $(this).textbox('options');
    				$(this).textbox('textbox').removeClass('textbox-text-noneditable').addClass(!opts.editable ? 'textbox-text-noneditable' : '');
    			});
    		}
    	};
    	$.fn.textbox.defaults = plugin.defaults;
    	$.fn.textbox.parseOptions = plugin.parseOptions;
    	$.fn.textbox.methods = plugin.methods;
    })(jQuery);

    function getStyleRuleValue(style, selector, sheet) {
        var sheets = typeof sheet !== 'undefined' ? [sheet] : document.styleSheets;
        for (var i = 0, l = sheets.length; i < l; i++) {
            var sheet = sheets[i];
            if( !sheet.cssRules ) { continue; }
            for (var j = 0, k = sheet.cssRules.length; j < k; j++) {
                var rule = sheet.cssRules[j];
                if (rule.selectorText && rule.selectorText.split(',').indexOf(selector) !== -1) {
                    return rule.style[style];
                }
            }
        }
        return null;
    }



    function changeCss(className, classValue) {
        // we need invisible container to store additional css definitions
        var cssMainContainer = $('#css-modifier-container');
        if (cssMainContainer.length == 0) {
            var cssMainContainer = $('<div id="css-modifier-container"></div>');
            cssMainContainer.hide();
            cssMainContainer.appendTo($('body'));
        }

        // and we need one div for each class
        classContainer = cssMainContainer.find('div[data-class="' + className + '"]');
        if (classContainer.length == 0) {
            classContainer = $('<div data-class="' + className + '"></div>');
            classContainer.appendTo(cssMainContainer);
        }

        // append additional style
        classContainer.html('<style>' + className + ' {' + classValue + '}</style>');
    }


    function DgvPathColumnFormater(value,row,index) {
        if (row.PATHLEVEL==undefined || row.PATHLEVEL==null)
            return value;

        var data = jQuery.parseJSON(row.PATHLEVEL);

        if (data.level==undefined || data.level==null)
            return value;

        var font_weight;
        if (data.isgroup==undefined || data.isgroup==null) {
            font_weight = 'normal';
        } else {
            font_weight = (data.isgroup == '1') ? 'bold' : 'normal';
        }

        var padding_left = 10 * data.level;
        return '<span style="padding-left: '+ padding_left +'px; font-weight: '+ font_weight  +'">' + value + '</span>';
    }

	function inIframe () {
	    try {
	        return window.self !== window.top;
	    } catch (e) {
	        return true;
	    }
	}


    $.fn.datebox.defaults.formatter = function(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return (d < 10 ? '0' + d : d) + '/' + (m < 10 ? '0' + m : m) + '/' + y;
    };

    $.fn.datebox.defaults.parser = function(s) {
        if (s) {
            var a = s.split('/');
            var d = new Number(a[0]);
            var m = new Number(a[1]);
            var y = new Number(a[2]);
            var dd = new Date(y, m-1, d);
            return dd;
        } else {
            return new Date();
        }
    };

    $.extend($.fn.validatebox.defaults.rules, {
        FGTA_ID: {
            validator: function(value, param){
                return value.match(/^[A-Z0-9\-]*$/);
            },
            message: 'hanya diperbolehkan menggunakan huruf KAPITAL dan atau ANGKA.'
        },

        FGTA_CBO: {
            validator: function(value, param) {
                var cbo_value = param[0].combobox('getValue');
                if (cbo_value=='0')
                    return false;
                else
                    return true;
            },
            message: 'Harus dipilih'
        }
    });



    </script>
    <?php
    } //
    ?>

    <script type="text/javascript" src="js/fgta_object.js"></script>
    <script type="text/javascript" src="js/fgta_formdata.js"></script>
    <script type="text/javascript" src="js/fgta_editor.js"></script>
    <script type="text/javascript" src="js/fgta_uibase.js"></script>

	<!-- BEGIN DYNAMIC SCRIPT -->
	<?php foreach ($Scripts->data as $script) { ?><script type="text/javascript" src="<?=$this->GetResourceUrl($script)?>"></script>
	<?php } ?><!-- END DYNAMIC SCRIPT -->

</head>
<body id="main-layout" class="easyui-layout" >
	<div id="cnt_messagebox" class="easyui-dialog" style="width:500px;height:300px;" data-options="resizable:true,modal:true,closed:true"></div>

	<?=$BODYTEXT_MESSAGE?>
	<?php
	if (!$this->BYPASS_TEMPLATE_RENDERING) {
        if (array_key_exists('devform', $_GET)) {
            require_once dirname(__FILE__).'/_devform.html.php';
        } else {
            require_once $TEMPLATE;
        }
	}
	?>

</body>
</html>
