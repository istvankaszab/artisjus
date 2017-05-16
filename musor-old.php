<?
require "index.php";
?>
<?

//echo "hello";
//print_r($_GET);
//echo "ID = ".$_GET["id"];
//$musor = array();

//fejlec
$sor_tipus = 0;

foreach(array_keys($_POST) as $post_key) {
	
	//zene hozzárendelés
	if(strpos($post_key, 'music-assign__') !== false) {
		$post_key = str_replace('music-assign__', '', $post_key);
		
		$query_music_to_assign = "select zene_jelleg, zene_hossz from zene where zene_id = ".$post_key;
		$result_music_to_assign = mysqli_query($conn_main, $query_music_to_assign);
		$music_to_assign=mysqli_fetch_array($result_music_to_assign);
		
		$query_music_assign = "insert into musorzene (musor_id, zene_id, musorzene_jelleg, musorzene_hossz) 
			values ('".$_GET["id"]."', ".$post_key.", '".$music_to_assign["zene_jelleg"]."', '".$music_to_assign["zene_hossz"]."')";
		$result_music_assign = mysqli_query($conn_main, $query_music_assign);
	}
	//zene hozzárendelés END
	
	//hozzárendelt zene törlése
	if(strpos($post_key, 'music-delete__') !== false) {
		$post_key = str_replace('music-delete__', '', $post_key);
		
		$query_music_to_assign = "delete from musorzene where musorzene_azonosito = ".$post_key;
		$result_music_to_assign = mysqli_query($conn_main, $query_music_to_assign);
	}
	//hozzárendelt zene törlése END
	
	//hozzárendelt zene módosítása
	if(strpos($post_key, 'music-ok__') !== false) {
		$post_key = str_replace('music-ok__', '', $post_key);
		$mz_hossz = '00:'.$_POST['zenehossz_min__'.$post_key].':'.$_POST['zenehossz_sec__'.$post_key];
		$query_music_to_assign = "update musorzene set musorzene_hossz = '".$mz_hossz."', musorzene_jelleg = '"
			.$_POST['zenejelleg__'.$post_key]."' where musorzene_azonosito = ".$post_key;
		$result_music_to_assign = mysqli_query($conn_main, $query_music_to_assign);
	}
	//hozzárendelt zene módosítása END
	
	//print_r(array_keys($_POST));
}


?>

<h1><?echo $_GET["id"] ?></h1>

<?
//musor adatai
$query_musor = 'select * from musor where musor_id = \''.$_GET["id"].'\'';
$result_musor = mysqli_query($conn_main, $query_musor);
$musor=mysqli_fetch_array($result_musor);
?>
	<div class="jumbotron">
		<h3>Műsor adatai</h3>
		<table class="table table-condensed table-bordered table-striped">
			<tr>
				<th>Műsor ID</th>
				<th>Eredeti cím</th>
				<th>Fordított cím</th>
				<th>Epizód szám</th>
				<th>Epizód cím</th>
				<th>Gyártás éve</th>
			</tr>
			<tr>
				<td><?echo $musor["musor_id"]?></td>
				<td><?echo $musor["musor_eredeti_cim"]?></td>
				<td><?echo $musor["musor_forditott_cim"]?></td>
				<td><?echo $musor["musor_epizod_szam"]?></td>
				<td><?echo $musor["musor_epizod_eredeti_cim"]?></td>
				<td><?echo $musor["musor_gyartas_ev"]?></td>
			</tr>
		</table>

		<table class="table table-condensed table-bordered table-striped">
			<tr>
				<th>Nemzetiség 1</th>
				<th>Nemzetiség 2</th>
				<th>Nemzetiség 3</th>
				<th>Nemzetiség 4</th>
			</tr>
			<tr>
				<td><?echo $musor["nemzetiseg_1"]?></td>
				<td><?echo $musor["nemzetiseg_2"]?></td>
				<td><?echo $musor["nemzetiseg_3"]?></td>
				<td><?echo $musor["nemzetiseg_4"]?>&nbsp;</td>
			</tr>
		</table>
		<table class="table table-condensed table-bordered table-striped">
			<tr>
				<th>Rendező</th>
				<th>Megjegyzés</th>
				<th>Produkció</th>
				<th>Feldolgozva</th>
			</tr>
			<tr>
				<td><?echo $musor["musor_rendezo_1"]?></td>
				<td><?echo $musor["musor_megjegyzes"]?></td>
				<td><?echo $musor["produkcio"]?></td>
				<td><input type="checkbox" <?if($musor["feldolgozva"]) echo "checked";?> /></td>
			</tr>
		</table>
	</div>

	<div class="jumbotron">
	<h3>Hozzárendelt zenék</h3>
	<form id="hozzarendelt_zenelista" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
	<table class="table table-condensed table-bordered table-striped">
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
<?	

//hozzarendelt zenek adatai
$query_hozzarendelt_zene = "select musorzene_azonosito, zene_eredeti_cim, zene_forditott_cim, zene_szerzo, zene_szovegiro, zene_eloado, zene_kiado, 
	 musorzene_hossz, musorzene_jelleg from musorzene left join zene on musorzene.zene_id = zene.zene_id where musor_id = '".$_GET["id"]."'";
$result_hozzarendelt_zene = mysqli_query($conn_main, $query_hozzarendelt_zene);
while($hozzarendelt_zene=mysqli_fetch_array($result_hozzarendelt_zene)) {
?>
	<tr>
		<td><button type="submit" name="music-delete__<?echo $hozzarendelt_zene['musorzene_azonosito'];?>" class="btn-danger" value="X" data-toggle="tooltip" title="Töröl">X</button>&nbsp;&nbsp;<?echo $hozzarendelt_zene["zene_eredeti_cim"];?></td>
		<td><?echo $hozzarendelt_zene["zene_forditott_cim"];?></td>
		<td><?echo $hozzarendelt_zene["zene_szerzo"];?></td>
		<td><?echo $hozzarendelt_zene["zene_szovegiro"];?></td>
		<td><?echo $hozzarendelt_zene["zene_eloado"];?></td>
		<td><?echo $hozzarendelt_zene["zene_kiado"];?></td>
		<td>
		<input type="text" size="2" maxlength="2" name="zenehossz_min__<?echo $hozzarendelt_zene['musorzene_azonosito'];?>" value="<?echo substr($hozzarendelt_zene["musorzene_hossz"], 3, 2)?>" />&nbsp;:&nbsp;
		<input type="text" size="2" maxlength="2" name="zenehossz_sec__<?echo $hozzarendelt_zene['musorzene_azonosito'];?>" value="<?echo substr($hozzarendelt_zene["musorzene_hossz"], 6, 2)?>" />
		</td>
		<td><input type="text" size="1" maxlength="1" name="zenejelleg__<?echo $hozzarendelt_zene['musorzene_azonosito'];?>" value="<?echo $hozzarendelt_zene["musorzene_jelleg"];?>" /></td>
		<td><button type="submit" name="music-ok__<?echo $hozzarendelt_zene['musorzene_azonosito'];?>" class="btn-primary" data-toggle="tooltip" title="OK">&#10004;</button></td>
	</tr>
<?
}
?>
	</table>
	</form>
	</div>

	<div class="jumbotron">	<p>&nbsp;</p>
	<h3>Zenék</h3>
	<form class="form-inline" id="zenelista" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">

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
		<td><input type="submit" name="music-assign__<? echo $zene["zene_id"]; ?>" class="btn-success" value="&#65291;" data-toggle="tooltip" title="Hozzárendel" />&nbsp;&nbsp;<? echo $zene["zene_eredeti_cim"]; ?></td>
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
	</form>
	</div>


<?

require "footer.php"
?>