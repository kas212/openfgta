<?php
if (!defined('__OPENFGTA__'))
	die('Cannot access file directly');


require_once dirname(__FILE__)."/FGTA_WebService.inc.php";
require_once dirname(__FILE__)."/FGTA_PageNavigation.inc.php";


class FGTA_Content extends FGTA_WebService
{
	//public $ROOT_DIR;
	//public $DEFAULT_DIR;
	public $TEMPLATE_DIR;
	public $TEMPLATE;
	public $TITLE;
	public $BYPASS_TEMPLATE_RENDERING;
	public $db;
	public $EXEC_PAGE;
	public $ISLOGIN;
	//public $USERNAME;
	public $USERFULLNAME;
	public $PAGECONFIGS;

	public $CurrentUser;



	public $Navis;
	public $Scripts;
	public $Styles;

	function __construct($ROOT_DIR, $DEFAULT_DIR) 	{
		$this->DEFAULT_DIR = $DEFAULT_DIR;
		$this->ROOT_DIR = $ROOT_DIR;

		$this->Scripts = new FGTA_PageScripts($ROOT_DIR, $DEFAULT_DIR);
		$this->Styles = new FGTA_PageStyles($ROOT_DIR, $DEFAULT_DIR);
		$this->Navis = new FGTA_PageNavigation();

		if (array_key_exists('USER_ID', $_SESSION))
			$this->CurrentUser = $_SESSION['USER_ID'];
	}


	public function GetRequestedPage() 	{
		global $_GET;

		if (array_key_exists('pg',  $_GET))
			$pg = $_GET['pg'];
		else
			$pg = "";

		return $pg;
	}


	public function LoadPage() 	{
		//test
	}


	public function setTemplate($templatefilename) 	{
		$this->TEMPLATE = $this->TEMPLATE_DIR . "/" . $templatefilename;
	}


	public function ParseTemplate($objApps) 	{
		foreach ($objApps as $name=>$value) {
			${$name} = $value;
		}

		if ($objApps->TEMPLATE!="")
			if (!is_file($objApps->TEMPLATE))
				echo "Template file '".$objApps->TEMPLATE."' is not found!";
			else
				require_once $objApps->TEMPLATE;
	}

	public function GetRedirectUrl($to, $params) 	{
		$p = array();
		foreach ($params as $key=>$value)
		{
			$p[] = "$key=$value";
		}
		$urlparams = implode("&", $p);

		$RedirectUrl = "http://"
		                       . $_SERVER['SERVER_NAME']
		                       . (($_SERVER["SERVER_PORT"]=="80") ? "" : ":" . $_SERVER["SERVER_PORT"])
		                       . "/" . $to
		                       . "?" . $urlparams;

		return $RedirectUrl;
	}

	public function Redirect($to, $params, $bypassrender=true) {
		global $_SERVER;




		foreach ($params as $key=>$value)
		{
			$p[] = "$key=$value";
		}
		$urlparams = implode("&", $p);


		$this->BYPASS_TEMPLATE_RENDERING = $bypassrender;
		$this->REDIRECT_PAGE = "http://"
		                       . $_SERVER['SERVER_NAME']
		                       . (($_SERVER["SERVER_PORT"]=="80") ? "" : ":" . $_SERVER["SERVER_PORT"])
		                       . "/" . $to
		                       . "?" . $urlparams;


		echo "Redirecting page, please click <a href=\"".$this->REDIRECT_PAGE."\">here</a> if this page is not redirected.<br>\n";
		echo "<script>\n";
		echo "location.href='".$this->REDIRECT_PAGE."'";
		echo "</script>\n";

	}

	public function GetResourceUrl($resourcepath) {
		return str_replace($this->ROOT_DIR.'/', '', $resourcepath);
	}


	public function get_fgta_toolbox() {
		return array(
			array('btnNew', 'icon-fgta-new'),
			array('btnEdit', 'icon-fgta-edit', 'options'=>"toggle: true"),
			//array('btnEditCancel', 'icon-fgta-edit-cancel'),
			array('btnSave', 'icon-fgta-save'),
			null,
			array('btnPrint', 'icon-fgta-print'),
			null,
			array('btnDelete', 'icon-fgta-delete'),
			null,
			array('btnLoad', 'icon-fgta-load', 'onclick'=>'ui.btnLoad_Click(0,0)'),
			null,
			array('btnRowadd', 'icon-fgta-rowadd'),
			array('btnRowremove', 'icon-fgta-rowremove'),
			null,
			array('btnRecFirst', 'icon-fgta-first', 'onclick'=>'ui.btnRecFirst_Click()'),
			array('btnRecPrev', 'icon-fgta-prev', 'onclick'=>'ui.btnRecPrev_Click()'),
			array('btnRecNext', 'icon-fgta-next', 'onclick'=>'ui.btnRecNext_Click()'),
			array('btnRecLast', 'icon-fgta-last', 'onclick'=>'ui.btnRecLast_Click()'),
		);
	}

	public function load_html_fgta_toolbox() {
		global $_SERVER;

		$tools = $this->get_fgta_toolbox();
		foreach ($tools as $data)
		{
			if ($data==null)
				echo "\t\t\t<img src=\"icon/fgta/sparator.png\" width=\"13\" height=\"16\" class=\"l-btn l-btn-small\" style=\"cursor:default; border: 1px transparent\">\r\n";
			else
				$this->print_html_fgta_button($data);
		}

		$ALLOW_DEVLAYOUT = $_SESSION['username'] == __LAYOUT_EDITOR_USER ? true : false;
		if ($ALLOW_DEVLAYOUT)
			echo "<span style=\"float:right\">[<a href=\"".$_SERVER['REQUEST_URI']."&devform=1\">visual form layout</a>]</span>";
	}

	public function load_html_fgta_search($Search, $devform=false) {
		$dat = array();
		$LAYOUTFILE = $this->ROOT_DIR . "/apps" . "/" . $this->NS . "/" . $this->CL . ".layoutsearch.php";
		if (is_file($LAYOUTFILE)) {
			require_once $LAYOUTFILE;
		} else {
			$top = 10;
			foreach ($Search as $c)
			{
				$classname = get_class($c);
				$dat[$c->textbox] = [$top, 0, 190];
				$top += 27;
			}

		}

		reset($Search);
		foreach ($Search as $s) {
			$name = $s->textbox;
			$LOCATIONLAYOUT = array_key_exists($name, $dat) ? $dat[$name] : null;
			$s->set_layout($LOCATIONLAYOUT);
			$s->GenerateHtml(['devform'=>$devform]);
		}
	}

	public function bind_search_param($Search) {
		foreach ($Search as $s) {
			$classname = get_class($s);
			switch ($classname) {
				case "FGTA_Control_ComboboxSearch":
					echo "{Name: \"".$s->name."\", Value: $('#".$s->textbox."').combobox('getValue'), Checked: $('#".$s->checkbox."').is(':checked')},\r\n";
					break;
				default:
					echo "{Name: \"".$s->name."\", Value: $('#".$s->textbox."').textbox('getValue'), Checked: $('#".$s->checkbox."').is(':checked')},\r\n";
			}
		}
	}


	public function init_search($Search) {
		foreach ($Search as $s) {
			$classname = get_class($s);
			switch ($classname) {
				case "FGTA_Control_ComboboxSearch":
					echo "$('#".$s->textbox."').combobox('setValue', '0');";
					break;
				default:
			}
		}
	}

	public function bind_dglist($dgv) {
		echo "
		ui.".$dgv->name." = $(\"#".$dgv->name."\");
		ui.".$dgv->name.".datagrid({
			onDblClickRow: function(index,row) { ui.dgvList_RowDblClick(index,row) },
			onSelect: function(index,row) { ui.dgvList_Select(index, row) }
		});\r\n
		";

		echo "
		ui.".$dgv->name.".datagrid('getPager').pagination({
			onSelectPage: function (pageNumber, pageSize) {
				ui.btnLoad_Click(pageNumber, pageSize);
			}
		});
		";

	}


	public function bind_editor($editor) {
		echo "ui.Editor.ui = ui;\r\n";


		echo "ui.Editor.add({\r\n";

		$datagrids = array();
		foreach ($editor as $c)
		{
			$classname = get_class($c);
			if ($classname != 'FGTA_Control_Datagrid') {
				$code = "%1\$s: ui.Editor.CreateEditorObject('%1\$s', $('#%1\$s'), '%2\$s', '%3\$s'), \r\n";
				echo sprintf($code, $c->name, $classname, $c->label);
			} else {
				$datagrids[] = "ui.".$c->name;
			}

		}
		echo "});\r\n";

		echo "ui.idfield = ui.Editor.".$this->FIELD_ID.";\r\n";
		echo "ui.idfield['isauto'] = ".(($this->FIELD_ID_ISAUTO) ? 'true' : 'false').";\r\n";
		echo "ui.idfield['mapping'] = '" . $this->FIELD_ID_MAPPING . "';\r\n";

		echo "ui.Editor.DataGrids = [".implode(", ", $datagrids)."];\r\n\r\n";
	}

	public function bind_datagrid($editor) {
		foreach ($editor as $c)
		{
			$classname = get_class($c);
			if ($classname == 'FGTA_Control_Datagrid')
			{
				echo  "ui.".$c->name." = $(\"#".$c->name."\");\r\n";
				echo  "ui.".$c->name.".name = '".$c->name."';\r\n";
				echo  "ui.".$c->name.".editIndex = undefined;\r\n";
				echo  "ui.".$c->name.".maxline = 0;\r\n";

				if ($c->dialog != null) {
					$c->dialog->dgvname = $c->name;
					$c->dialog->process_dialog($c->name);
					echo "ui.".$c->name.".dialogShow = function(opt) { ";
					echo "$('#".$c->dialog->dialog_id."').dialog({closed: false}); ";
				    echo "$('#".$c->dialog->objDgvSearchresult."').datagrid('loadData', []); ";
				    echo "$('#".$c->dialog->objSearchTextboxName."').textbox('setValue', ''); ";
				    echo "$('#".$c->dialog->objSearchTextboxName."').textbox('textbox').focus(); ";

					echo "if (opt!=undefined) { ";
					echo "ui.".$c->name.".opt = opt; ";
					echo "ui.".$c->name.".ev_onSelect = opt.onSelect; ";
					echo "} ";

					echo "}; \r\n";
				}

			}
		}
		echo "\r\n";
	}

	public function bind_datagrid_init($editor) {
		foreach ($editor as $c)
		{
			$classname = get_class($c);
			if ($classname == 'FGTA_Control_Datagrid')
			{
				if ($c->dialog != null) {
					$c->dialog->JSInit();
				}
			}
		}
	}

	public function bind_datagrid_dialog($editor) {
		foreach ($editor as $c)
		{
			$classname = get_class($c);
			if ($classname == 'FGTA_Control_Datagrid')
			{
				if ($c->dialog != null) {
					echo "<!-- DIALOG BEGIN [".$c->name."] //-->\r\n";
					$c->dialog->GenerateHtml();
					echo "<!-- DIALOG END [".$c->name."] //-->";
				}
			}
		}
	}

	public function bind_recordform() {
		echo "
		ui.obj_txt_recordcreateby = $(\"#obj_txt_recordcreateby\");
		ui.obj_txt_recordcreatedate = $(\"#obj_txt_recordcreatedate\");
		ui.obj_txt_recordmodifyby = $(\"#obj_txt_recordmodifyby\");
		ui.obj_txt_recordmodifydate = $(\"#obj_txt_recordmodifydate\");
		ui.obj_txt_recordrowid = $(\"#obj_txt_recordrowid\");
		";
	}


	public function load_html_control($editor, $devform=false) 	{
		$dat = array();

		$LAYOUTFILE = $this->ROOT_DIR . "/apps" . "/" . $this->NS . "/" . $this->CL . ".layoutform.php";
		if (defined('__USER_APPS_DIR'))
			if (is_file($this->ROOT_DIR . "/apps/" __USER_APPS_DIR . "/" . $this->NS . "/" . $this->CL . ".layoutform.php"))
				$LAYOUTFILE = $this->ROOT_DIR . "/apps/" __USER_APPS_DIR . "/" . $this->NS . "/" . $this->CL . ".layoutform.php"
		


		if (is_file($LAYOUTFILE)) {
			require_once $LAYOUTFILE;
		} else {
			$top = 10;
			foreach ($editor as $c)
			{
				$classname = get_class($c);
				if ($classname != 'FGTA_Control_Datagrid') {
					$dat[$c->name] = [$top, 20, 190];
					$top += 27;
				}
			}
		}


		reset($editor);
		foreach ($editor as $c)
		{
			$name = $c->name;
			$LOCATIONLAYOUT = array_key_exists($name, $dat) ? $dat[$name] : null;
			$classname = get_class($c);
			if ($classname != 'FGTA_Control_Datagrid') {
				$c->set_layout($LOCATIONLAYOUT);
				$c->GenerateHtml(['devform'=>$devform]);
			}
		}
	}


	public function load_html_datagrid($datagrids) 	{
		if (is_array($datagrids)) {
			foreach ($datagrids as $c)
			{
				$classname = get_class($c);
				if ($classname == 'FGTA_Control_Datagrid') {
					$dopts = "allowaddremove: " . (($c->allowaddremove==true) ? 'true' : 'false') ."" ;

					echo "<div title=\"".$c->label."\" data-options=\"$dopts\" style=\"padding: 10px 0 0 0\">";
					$c->GenerateHtml();
					echo "</div>";
				}
			}
		}
		else {
			$classname = get_class($datagrids);
			if ($classname != 'FGTA_Control_Datagrid')
				die("Error on load_html_datagrid: input bukan FGTA_Control_Datagrid.");

			$datagrids->GenerateHtml();
		}
	}



	public function load_html_form() 	{
		//echo "load_html_form belum diimplementasi,<br>buat fungsi tersebut di class anda untuk meng-include html form.";
		if (!array_key_exists('HTML_FORM_FILE', $this))
			echo "<b>HTML_FORM_FILE</b> belum didefinisikan dalam class!";
		else if (!is_file($this->HTML_FORM_FILE))
			echo "File (HTML_FORM_FILE) '".$this->HTML_FORM_FILE."' tidak ditemukan!";
		else
			include $this->HTML_FORM_FILE;
	}

	public function load_html_fgta_recordform() 	{
		$labelwidth = 70;
		$items = array(
			array('obj_txt_recordcreateby', 'Create By', 120, 40),
			array('obj_txt_recordcreatedate', 'Create Date', 160, 5),
			array('obj_txt_recordmodifyby', 'Modify By', 120, 10),
			array('obj_txt_recordmodifydate', 'Modify Date', 160, 5),
			array('obj_txt_recordrowid', 'rowid', 200, 10),
		);

		$last_y = 0;
		foreach ($items as $item) {
			$name = $item[0];
			$label = $item[1];
			$width = $item[2];
			$padtop = $item[3];

			$top = $last_y + $padtop;
			$totalwidth = $labelwidth + $width + 10;

			echo "
			<div class=\"fgta_field\" style=\"left:20px; top:".$top."px; width:".$totalwidth."px; \">
				<label class=\"fgta_label\" style=\"width:".$labelwidth."px;\">$label</label>
				<input class=\"easyui-textbox\" id=\"$name\" style=\"width:".$width."px;\" data-options=\"editable:false\">
			</div>
			";

			$last_y = $top + 22;
		}

	}

	public function print_html_fgta_button($data) 	{
		$options = "disabled: true";

		$id = $data[0];
		$icon = $data[1];
		$options .= array_key_exists('options', $data) ? ", " . $data['options'] : "";

		print "\t\t\t"."<a href=\"#\" id=\"$id\" class=\"easyui-linkbutton\" plain=\"true\" iconCls=\"$icon\" data-options=\"$options\"></a>\r\n";
	}

	public function bind_fgta_toolbox() 	{
		$tools = $this->get_fgta_toolbox();
		foreach ($tools as $data)
		{
			if ($data==null)
				continue;

			$id = $data[0];
			$clickeventhandler = array_key_exists('onclick', $data) ?  $data['onclick'] : '_' . $id . "_Click(ui)" ;

			print "\t\t\t"."ui.$id = \$(\"#$id\");\r\n";
			print "\t\t\t"."ui.$id.linkbutton({ onClick: function() { $clickeventhandler } });\r\n\r\n";
		}
	}



	public function Render($template_filename, $BODYTEXT_MESSAGE, $DATA) 	{
		global $_GET;


		if (!FGTA_PageNavigation::$__add_called)
			$this->Navis->Clear();


		if (!is_file($template_filename))
		{
			echo "Template Error<br />";
			echo "'$template_filename' does not exist!";
			return;
		}

		if ($this->BYPASS_TEMPLATE_RENDERING)
			if (!empty($this->REDIRECT_PAGE))
				header("location: " . $this->REDIRECT_PAGE);

		foreach ($DATA as $name=>$value) {
			${$name} = $value;
		}

		require_once $template_filename;

	}


	public function BlankRender($bodycontent, $objApps) 	{
		echo $bodycontent;
		$this->ParseTemplate($objApps);
	}


	public function Lookup($table, $idfieldname, $lookupfieldname, $value, $textifnotfound="") {

		$sql = "SELECT $lookupfieldname FROM $table WHERE $idfieldname = :$idfieldname";

		try {
			$row = null;

			$stmt = $this->db->prepare($sql);
			$stmt->execute(array(':'.$idfieldname => $value != null ? $value : ''));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row!=null)
				return $row[$lookupfieldname];
			else
				return $textifnotfound;
		} catch (Exception $ex) {
			throw new Exception('Error in Lookup data to '.$table.'.<br>' . $sql . '<br>' . $ex->getMessage());
		}

	}


	public function DoDefaultPreLoad($F) {
		if (isset($F))
			if (is_array($F)) {


				$ID = $F["ID"];
				$TEXT = $F["TEXT"];

				if (array_key_exists('SQL', $F)) {
					$SQL   = $F['SQL'];
					$PARAM = array_key_exists('PARAM', $F) ? $F['PARAM'] : array();
				} else {
					$TABLE = $F["TABLE"];
					$LIMIT = array_key_exists('LIMIT', $F) ? $F["LIMIT"] : "";
					$WHERE = array_key_exists('WHERE', $F) ? $F["WHERE"] : "";

					IF ($LIMIT!="")
						$LIMIT = " FIRST $LIMIT ";

					IF ($WHERE!="")
						$WHERE = " WHERE $WHERE ";

					$SQL = "SELECT $LIMIT $ID, $TEXT FROM $TABLE $WHERE ORDER BY $TEXT";
					$PARAM = array();

				}

				$stmt = $this->db->prepare($SQL);
				$stmt->execute($PARAM);
				$rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$i=0;
				foreach ($rows as $row)
				{
					$i++;
					echo "{\"id\":\"".$row[$ID]."\",\"text\":\"".$row[$TEXT]."\"}";
					echo ($i<count($rows)) ? "," : "";
				}

			}
	}

	public function GetPathLevel($path, $isgroup) {

		$p = explode("/", $path);
		$np = count($p) - 2;
		$np = $np < 0 ? 0 : $np;

		$obj = new stdClass;
		$obj->level = $np;
		$obj->isgroup = $isgroup;

		return json_encode($obj);
	}


	public function IsHasChild($table, $fieldid, $fieldparent, $value) {
		$sql = "SELECT COUNT($fieldid) AS N FROM $table WHERE  $fieldparent = :ID";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(
						':ID' => $value
				));
		$row  = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row != null)
			return (int)$row['N'];
		else
			return 0;
	}


	public function GetBgColor() {
		switch ($this->THEME_COLOR) {
			case "-red":
				return "#F8c9c9";

			case "-green":
				return "#E0F892";

			case "-orange":
				return "#eadfb2";

			case "-blue":
				return "#91b8e3";

			case "-gray":
				return "#eee";

			default:
				return "#eee";
		}
	}

	public function GetBorderColor() {
		switch ($this->THEME_COLOR) {
			case "-red":
				return "#f6c1bc";

			case "-green":
				return "#B1C242";

			case "-orange":
				return "#d4a375";

			case "-blue":
				return "#6a88a9";

			case "-gray":
				return "#abafb8";

			default:
				return "#ddd";
		}
	}

	public function GetButtonColor() {
		switch ($this->THEME_COLOR) {
			case "-red":
				return "c5";

			case "-green":
				return "c1";

			case "-orange":
				return "c7";

			case "-blue":
				return "c6";

			case "-gray":
				return "c2";

			default:
				return "c6";

		}
	}




}
