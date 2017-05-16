<? 
require "config.php";

$strMusorZene = "";

//hozzarendelt zenek adatai
$query_hozzarendelt_zene = "select musorzene_azonosito, zene_eredeti_cim, zene_forditott_cim, zene_szerzo, zene_szovegiro, zene_eloado, zene_kiado, 
	 musorzene_hossz, musorzene_jelleg from musorzene left join zene on musorzene.zene_id = zene.zene_id where musor_id = '".$_GET["musor_id"]."'";
$result_hozzarendelt_zene = mysqli_query($conn_main, $query_hozzarendelt_zene);
while($hozzarendelt_zene=mysqli_fetch_array($result_hozzarendelt_zene)) {

	$strMusorZene .= '<tr>
		<td><button type="submit" onclick="deleteMusorZene(\'' . $hozzarendelt_zene['musorzene_azonosito'] . '\');"'		
		. ' class="btn btn-danger" value="X" data-toggle="tooltip" title="Töröl">X</button>&nbsp;&nbsp;'
		. $hozzarendelt_zene["zene_eredeti_cim"]
		. '</td>'
		. '<td>' . $hozzarendelt_zene["zene_forditott_cim"] . '</td>'
		. '<td>' . $hozzarendelt_zene["zene_szerzo"] . '</td>'
		. '<td>' . $hozzarendelt_zene["zene_szovegiro"] . '</td>'
		. '<td>' . $hozzarendelt_zene["zene_eloado"] . '</td>'
		. '<td>' . $hozzarendelt_zene["zene_kiado"] . '</td>'
		. '<td><input type="text" size="2" maxlength="2" id="zenehossz_min__'
		. $hozzarendelt_zene['musorzene_azonosito'] . '" value="'
		. substr($hozzarendelt_zene["musorzene_hossz"], 3, 2) . '" />&nbsp;:&nbsp;'
		. '<input type="text" size="2" maxlength="2" id="zenehossz_sec__'
		. $hozzarendelt_zene['musorzene_azonosito'] .'" value="'
		. substr($hozzarendelt_zene["musorzene_hossz"], 6, 2) . '" /></td>'
		. '<td><input type="text" size="1" maxlength="1" id="zenejelleg__'
		. $hozzarendelt_zene['musorzene_azonosito'] . '" value="'
		. $hozzarendelt_zene["musorzene_jelleg"] . '" /></td>'
		. '<td><button type="button" onclick="modifyMusorZene('
		. $hozzarendelt_zene['musorzene_azonosito']	. ')"' 
		. ' class="btn btn-primary" data-toggle="tooltip" title="OK">&#10004;</button></td></tr>';

}

if($strMusorZene == "") $strMusorZene = "<tr><td colspan='9'>Nincs zene hozzárendelve</td></tr>";
echo $strMusorZene;

?>