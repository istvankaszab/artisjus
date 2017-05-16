<?
	require "index.php";
	
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$strHiba = "";
	$dataAdasmenet = array();
	$dataMusor = array();
	$dataSor = array();
	$musorSor = array();
	$prevMusorOut = "";
	$tombMusorID = array();
	$tombNewMusor = array();
	$newMusor = array();
	$sorAdasmenet = array();
	$datumFull = "";
	$query_adasmenet_insert = "";
	$sorIgazi = 0;
	$i = 0;
	
	echo "<pre>";
	
	if(isset($_POST["submit"])) {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "Fájl feltöltve: ". basename( $_FILES["fileToUpload"]["name"]) . "<br />";
			
			$query_musorID = 'select musor_id from musor';
			$result_musorID = mysqli_query($conn_main, $query_musorID);
			//		$tombMusorID = mysqli_fetch_all($result_musorID, MYSQLI_NUM);
			
			while (list($musor_id)=mysqli_fetch_row($result_musorID)) {
				array_push($tombMusorID, $musor_id);
			}
			
			//echo "<table>";
			
			$adasnaplofile = fopen($target_file, "r");
			$sor = 1;
			
			while(!feof($adasnaplofile)){
				$dataSor = array();
				$musorSor = array();
				$line = fgets($adasnaplofile);
				
				if(strlen($line) > 20) {
					$fieldsAdas = explode ("\t", $line);
					
					//			echo $fieldsAdas[0] . " - " . $fieldsAdas[1] . "<br />";
					//echo "<tr>";
					//datum ellenorzes
					if(preg_match("/\d{4}.\d{2}.\d{2}/", $fieldsAdas[0])){
						//mező tömbbe írás
						array_push($dataSor, $fieldsAdas[0]);
					}
					else {
						$strHiba = $strHiba . "Dátum nem stimmel: " . $sor . ". sor<br />";
					}
					//műsor IN ellenőrzés
					if(preg_match("/\d{1,2}:\d{2}:\d{2}/", $fieldsAdas[1])){
						//mező tömbbe írás
						array_push($dataSor, $fieldsAdas[1]);
					}
					else {
						$strHiba = $strHiba . "Műsor IN nem stimmel: " . $sor . ". sor<br />";
					}
					
					//műsor IN és előző OUT ellenőrzés
					if($sor > 1 and $sorIgazi == 1) {
						if(strcmp($fieldsAdas[1], $prevMusorOut) != 0) {
							$strHiba = $strHiba . "Műsor IN és előző OUT nem stimmel: " . $sor . ". sor<br />";
						}
					}
					
					//műsor OUT ellenőrzés
					if(preg_match("/\d{1,2}:\d{2}:\d{2}/", $fieldsAdas[2])){
						//mező tömbbe írás
						array_push($dataSor, $fieldsAdas[2]);
						$prevMusorOut = $fieldsAdas[2];
					}
					else {
						$strHiba = $strHiba . "Műsor OUT nem stimmel: " . $sor . ". sor<br />";
					}
					
					
					//műsor ID ellenőrzés
					if(strlen($fieldsAdas[4]) > 0){
						//mező tömbbe írás
						array_push($dataSor, $fieldsAdas[4]);
					}
					else {
						$strHiba = $strHiba . "Műsor ID nem stimmel: " . $sor . ". sor<br />";
					}
					
					//vetítési azonosító ellenőrzés
					if($fieldsAdas[9] == "" or preg_match("/^[0-9]*$/", $fieldsAdas[9])){
						//mező tömbbe írás
						if($fieldsAdas[9] == "") {
							array_push($dataSor, "1");
						}
						else {
							array_push($dataSor, $fieldsAdas[9]);
						}
					}
					else {
						$strHiba = $strHiba . "Vetítési azonosító nem stimmel: " . $sor . ". sor<br />";
					}
					
					//új műsor
					if(!in_array($fieldsAdas[4], $tombMusorID)) {
						//musor_id [0]
						array_push($musorSor, $fieldsAdas[4]);
						array_push($tombMusorID, $fieldsAdas[4]);
						
						//musor_eredeti_cim [1] és musor_forditott_cim [2]
						//ellenőrzés: van-e cím
						if(strlen($fieldsAdas[5]) > 0){
							//ellenőrzés: van-e eredeti
							if(strlen($fieldsAdas[7]) == 0){
								array_push($musorSor, $fieldsAdas[5]);
								array_push($musorSor, "");
							}
							else {
								array_push($musorSor, $fieldsAdas[7]);
								array_push($musorSor, $fieldsAdas[5]);
							}
						}
						else {
							$strHiba = $strHiba . "Műsor CÍM nem stimmel: " . $sor . ". sor<br />";
						}
						
						//musor_epizod_szam 10
						array_push($musorSor, $fieldsAdas[10]);
					
						//musor_epizod_eredeti_cim 8
						//musor_epizod_forditott_cim 9
						if(strlen($fieldsAdas[9]) == 0){
							array_push($musorSor, $fieldsAdas[8]);
							array_push($musorSor, "");
						}
						else {
							array_push($musorSor, $fieldsAdas[9]);
							array_push($musorSor, $fieldsAdas[8]);
						}
						
						//musor_gyartas_ev (jelenleg nincs az excel fajlban)
						array_push($musorSor, "");
						
						//nemzetiseg_1 13
						array_push($musorSor, $fieldsAdas[13]);
						//nemzetiseg_2
						array_push($musorSor, $fieldsAdas[14]);
						//nemzetiseg_3
						array_push($musorSor, $fieldsAdas[15]);
						//nemzetiseg_4
						array_push($musorSor, $fieldsAdas[16]);
						//musor_rendezo_1
						array_push($musorSor, $fieldsAdas[12]);
						//musor_megjegyzes
						array_push($musorSor, "");
						//produkcio
						array_push($musorSor, $fieldsAdas[6]);					
						
					}
					//új műsor VÉGE
					
					
					
					
					if($strHiba == "") {
						array_push($dataAdasmenet, $dataSor);
						if(!empty($musorSor)) {
							array_push($tombNewMusor, $musorSor);
						}
					}
					$sorIgazi = 1;
				}
				
				$sor++;
				unset($dataSor);
				unset($musorSor);
			}
			
			if($strHiba == "") {
				echo "Adásmenet feltöltve: $sor sor<br />";

				//adásmenet adatbázisba írása
				foreach($dataAdasmenet as $sorAdasmenet) {
					$datumFull = str_replace(".", "-", $sorAdasmenet[0]);
					$datumInsert = date('Y-m-d', strtotime($datumFull));
					$query_adasmenet_insert = $query_adasmenet_insert . "insert into adasmenet "
					. "(datum, musor_in, musor_out, musor_id, vetites_azonosito) values "
					. "('$datumFull', '$sorAdasmenet[1]', '$sorAdasmenet[2]', '$sorAdasmenet[3]', $sorAdasmenet[4]);\r\n";
				}
				if(strlen($query_adasmenet_insert) > 0) {
					//echo $query_adasmenet_insert;
					//mysqli_multi_query($conn_main, $query_adasmenet_insert);
					unset($query_adasmenet_insert);
				}
				
				if(!empty($tombNewMusor)) {
					//új műsorok adatbázisba írása
					$query_musor_insert = "";
					foreach($tombNewMusor as $dataMusor) {
						

						
						$query_musor_insert = $query_musor_insert . "insert into musor "
							. "(musor_id, musor_eredeti_cim, musor_forditott_cim, musor_epizod_szam, "
							. "musor_epizod_eredeti_cim, musor_epizod_forditott_cim, musor_gyartas_ev, "
							. "nemzetiseg_1, nemzetiseg_2, nemzetiseg_3, nemzetiseg_4, musor_rendezo_1, "
							. "musor_megjegyzes, produkcio) "
							. "values (";
						for($i=0;$i<13;$i++) {
							$query_musor_insert = $query_musor_insert . "'"	. mb_convert_encoding(str_replace("'", "", $dataMusor[$i]), "UTF-8") . "', ";
						}						
						$query_musor_insert = $query_musor_insert . "'"	. mb_convert_encoding(str_replace("'", "", $dataMusor[13]), "UTF-8") . "');\r\n";
					}
					if(strlen($query_musor_insert) > 0) {
						echo $query_musor_insert;
						mysqli_multi_query($conn_main, $query_musor_insert);
						unset($query_musor_insert);
					}

				}
				
				
			}
			else {
				echo $strHiba;
			}
		} 
		else {
			echo "Fájl feltöltés nem sikerült.";
		}
	}
	echo "</pre>";
?>		