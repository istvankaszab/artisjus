

function showMusor(musor_id) {
    $.get("musor-show.php?musor_id=" + musor_id, function(responseText, status){
			var musor = JSON.parse(responseText);

			for(var musor_key in musor) $("#" + musor_key).html(musor[musor_key]);
			if(musor.feldolgozva == "1") $("#feldolgozva").prop('checked', true);
				else $("#feldolgozva").prop('checked', false);
    });
}

function modifyMusor() {
  var strReq;
  var musor_id = arguments[0];
  var parName = arguments[1];
  var parValue = arguments[2];

   $.get("musor-modify.php?musor_id=" + musor_id + "&" + parName + "=" + parValue, function(responseText, status) {
     showMusor(musor_id);
   });
}

