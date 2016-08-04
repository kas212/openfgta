var TestdevClass = function () {
	$.extend(this, new FGTA_uiBase());
	var ui = this;


	this.Init = function () {
		ui.NS = '_default';
		ui.CL = 'testdev';

	};
}



function _TestPrint() {

    $.ajax({
		type: "POST",
		dataType: "json",
		url: FGTA_ServiceUrl(ui.NS,ui.CL,'TestPrint'),
		data: {
		},
		success: function (result, status, xhr) {
			try {
				var data = ui.ProcessAjaxJsonResult(result, status, xhr);
				if (data == null) throw "invalid data";


				ui.canvas.unmask();
			}
			catch (err) {
				ui.canvas.unmask();
				$.messager.alert("_load_table_field Error", err, "error").window({ shadow: false });
			}
		},
		error: function (xhr, status, error) {
			ui.canvas.unmask();
			ui.ProcessErrorText("Webservice LoadTableField on _load_table_field Error", xhr, status, error);
		},
	});

}
