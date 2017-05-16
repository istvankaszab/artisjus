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
	$fileTypeOK = 0;
	
	/** Include path **/
//set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include 'Classes/PHPExcel/IOFactory.php';


	echo "<pre>";
	
	if(isset($_POST["submit"])) {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "Fájl feltöltve: ". basename( $_FILES["fileToUpload"]["name"]) . "<br />";
			
			$query_musorID = 'select musor_id from musor';
			$result_musorID = mysqli_query($conn_main, $query_musorID);
		
			while (list($musor_id)=mysqli_fetch_row($result_musorID)) {
				array_push($tombMusorID, $musor_id);
			}
			
			if(substr($target_file, -4) == ".xls") {
				$inputFileType = 'Excel5';
				$fileTypeOK = 1;
			}
			elseif(substr($target_file, -5) == ".xlsx") {
				$inputFileType = 'Excel2007';
				$fileTypeOK = 1;
			}

			if(!$fileTypeOK) {
				echo "Nem megfelelő fájlformátum (.xls vagy .xlsx)";
			} else {

				//$inputFileType = 'Excel5';
				//	$inputFileType = 'Excel2007';
				//	$inputFileType = 'Excel2003XML';
				//	$inputFileType = 'OOCalc';
				//	$inputFileType = 'Gnumeric';
				$inputFileName = $target_file;

				//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory with a defined reader type of ',$inputFileType,'<br />';
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				//echo 'Turning Formatting off for Load<br />';
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($inputFileName);

				//echo '<hr />';

				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				
				echo date_from_integer($sheetData[2]['A']);

				//print_r($sheetData[2]['A']);
				//var_dump($sheetData);
			}
		}
	}
	

	
?>