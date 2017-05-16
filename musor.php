<?
require "index.php";
?>

<script>

function modifyMZ() {
	   request= new XMLHttpRequest()

    request.open("POST", "JSON_Handler.php", true)

    request.setRequestHeader("Content-type", "application/json")

    request.send(str_json)
}

function showMusorZene() {
  var xhttp; 

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
			$("#table_musorzene").html(this.responseText);
    }
  };
  xhttp.open("GET", "musorzene.php?musor_id=<? echo $_GET["id"]; ?>", true);
  xhttp.send();
}

function assignMusorZene(musor_id, zene_id) {
  var xhttp; 

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		showMusorZene();
    }
  };
  xhttp.open("GET", "musorzene-assign.php?musor_id=" + musor_id + "&zene_id=" + zene_id, true);
  xhttp.send();
}

function modifyMusorZene(mz_id) {
	var xhttp;
	var mz_jelleg, mz_min, mz_sec;

	mz_jelleg = document.getElementById("zenejelleg__" + mz_id).value;
	mz_min = document.getElementById("zenehossz_min__" + mz_id).value;
	mz_sec = document.getElementById("zenehossz_sec__" + mz_id).value;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			showMusorZene();
		}
	};
	xhttp.open("GET", "musorzene-modify.php?mz_id=" + mz_id + "&mz_jelleg=" + mz_jelleg + "&mz_min=" + mz_min + "&mz_sec=" + mz_sec, true);
	xhttp.send();
}

function deleteMusorZene(str) {
  var xhttp; 

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		showMusorZene();
    }
  };
  xhttp.open("GET", "musorzene-delete.php?musorzene_azonosito="+str, true);
  xhttp.send();
}

//oldalbetolteskor
showMusor("<? echo $_GET["id"]; ?>");
showMusorZene();

</script>

<h2><?echo $_GET["id"] ?></h2>

<?

?>
	<div class="jumbotron">
		<h4>Műsor adatai</h4>
		<div id="musor_adatok"></div>
		<table class="table table-condensed table-bordered table-striped">
			<tr>
				<th>Műsor ID</th>
				<th>Eredeti cím</th>
				<th>Fordított cím</th>
				<th>Epizód szám</th>
				<th>Epizód cím</th>
				<th>Gyártás éve</th>
				<th>Rendező</th>
			</tr>
			<tr>
				<td id="musor_id"></td>
				<td id="musor_eredeti_cim"></td>
				<td id="musor_forditott_cim"></td>
				<td id="musor_epizod_szam"></td>
				<td id="musor_epizod_eredeti_cim"></td>
				<td id="musor_rendezo_1"></td>
				<td id="musor_gyartas_ev"></td>
			</tr>
		</table>

		<table class="table table-condensed table-bordered table-striped">
			<tr>
				<th>Nemzetiség 1</th>
				<th>Nemzetiség 2</th>
				<th>Nemzetiség 3</th>
				<th>Nemzetiség 4</th>
				<th>Megjegyzés</th>
				<th>Produkció</th>
				<th>Feldolgozva</th>
			</tr>
			<tr>
				<td id="nemzetiseg_1"></td>
				<td id="nemzetiseg_2"></td>
				<td id="nemzetiseg_3"></td>
				<td id="nemzetiseg_4"></td>
				<td id="musor_megjegyzes"></td>
				<td id="produkcio"></td>
				<td><input type="checkbox" onchange="modifyMusor('<?echo $_GET["id"] ?>', 'feldolgozva', this.checked)" id="feldolgozva" /></td>
			</tr>
		</table>
	</div>

	<div class="jumbotron">
	<h4>Hozzárendelt zenék</h4>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th>Eredeti cím</th>
				<th>Fordított cím</th>
				<th>Szerző</th>
				<th>Szövegíró</th>
				<th>Előadó</th>
				<th>Kiadó</th>
				<th>Hossz</th>
				<th>Jelleg</th>
				<th>OK</th>
			</tr>
		</thead>
		<tbody id="table_musorzene"><tr><td colspan="9">Betöltés folyamatban...</td></tr></tbody>
	</table>
	</div>

	<div class="jumbotron">
	<h4>Zenék</h4>
<?
/*		<h4>Szűrés</h4>
		<div class="form-group">
			<label for="filter_zene_eredeti_cim">Eredeti cím:</label>
			<input type="text" name="zene_eredeti_cim" id="filter_zene_eredeti_cim" class="fejlec-filter form-control" onchange="javascript: document.getElementById('zenelista').submit();" <?if(isset($_POST["zene_eredeti_cim"])) echo ' value="'.$_POST["zene_eredeti_cim"].'"'; ?>/>
		</div>
*/
?>
	<table class="table table-condensed table-hover table-striped table-bordered">

		<tr>
			<th>Eredeti cím</th>
			<th>Fordított cím</th>
			<th>Szerző</th>
			<th>Szövegíró</th>
			<th>Előadó</th>
			<th>Kiadó</th>
			<th>Mihez</th>
			<th>Hossz</th>
		</tr>
<?	
$feltetel_zene = '';
//zenek adatai
if(isset($_POST["zene_eredeti_cim"])) {
//	$feltetel_zene = " where lcase(zene_eredeti_cim) like '%".strtolower($_POST["zene_eredeti_cim"])."%'"." collate utf8_bin";
	$feltetel_zene = " where lcase(zene_eredeti_cim) like '%".$_POST["zene_eredeti_cim"]."%'";
}
$query_zene= "select zene_id, zene_eredeti_cim, zene_forditott_cim, zene_szerzo, zene_szovegiro, zene_eloado, zene_kiado, zene_mihez, zene_hossz from zene".$feltetel_zene;
$result_zene = mysqli_query($conn_main, $query_zene);
while($zene=mysqli_fetch_array($result_zene)) {
?>
	<tr>
		<td>
			<button type="button" onclick="assignMusorZene('<?echo $_GET["id"] ?>', <? echo $zene["zene_id"]; ?>) " class="btn btn-success" data-toggle="tooltip" title="Hozzárendel">&#65291;</button>
			&nbsp;&nbsp;<? echo $zene["zene_eredeti_cim"]; ?></td>
		<td><? echo $zene["zene_forditott_cim"]; ?></td>
		<td><? echo $zene["zene_szerzo"]; ?></td>
		<td><? echo $zene["zene_szovegiro"]; ?></td>
		<td><? echo $zene["zene_eloado"]; ?></td>
		<td><? echo $zene["zene_kiado"]; ?></td>
		<td><? echo $zene["zene_mihez"]; ?></td>
		<td><? echo substr($zene["zene_hossz"], 3, 2); ?>:<? echo substr($zene["zene_hossz"], 6, 2); ?></td>
		</tr>
<?
}
?>
	</table>
	</div>

<?

require "footer.php"
?>