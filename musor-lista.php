
<?
require "index.php";

$sor_tipus = 0;
$str_cond = array();
$str_h1 = 'Műsorok listája';
$feltetel = '';
//print_r($_GET);
//print_r($_POST);

	if(isset($_POST["chkFeldolg"])) {
		$feltetel = 'where feldolgozva = 1';
	}
	else {
		$feltetel ='where feldolgozva = 0';	
	}	
	
	$query_numrows = 'select count(*) from musor '.$feltetel;
	$result_numrows = mysqli_query($conn_main, $query_numrows);
	list($numrows) = mysqli_fetch_row($result_numrows);

	$query_musor = 'select musor_id, musor_eredeti_cim, musor_forditott_cim, musor_megjegyzes, produkcio from musor '.$feltetel;
	$result_musor = mysqli_query($conn_main, $query_musor);
?>
<h1><?=$str_h1?></h1>
<form id="frmFeldolg" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
Feldolgozva: <input type="checkbox" name="chkFeldolg" onclick="javascript: document.getElementById('frmFeldolg').submit();" <?if(isset($_POST["chkFeldolg"])) echo "checked";?>/>
</form>
<?	
//	echo $numrows;
?>
<table class="table table-condensed table-hover table-striped table-bordered">
	<tr>
		<th>Műsor ID</th>
		<th>Eredeti cím</th>
		<th>Fordított cím</th>
		<th>Megjegyzés</th>
		<th>Produkció</th>
	</tr>

<?      
	$i = 1;
	while (list($musor_id, $musor_eredeti_cim, $musor_forditott_cim, $musor_megjegyzes, $produkcio)=mysqli_fetch_row($result_musor)) {
		echo "<tr>
			<td><a href='musor.php?id=$musor_id'>$musor_id</a></td>
			<td>$musor_eredeti_cim</td>
			<td>$musor_forditott_cim</td>
			<td>$musor_megjegyzes</td>
			<td>$produkcio</td>
			</tr>";			
	}

    echo "</table>";


require "footer.php"
?>


