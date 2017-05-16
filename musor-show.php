<? 
require "config.php";

//musor adatai
$query_musor = 'select * from musor where musor_id = \''.$_GET["musor_id"].'\'';
$result_musor = mysqli_query($conn_main, $query_musor);
$musor=mysqli_fetch_assoc($result_musor);

echo json_encode($musor);

?>
