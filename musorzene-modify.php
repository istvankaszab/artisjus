<? 
require "config.php";
require "functions.php";

$query_music_modify = "update musorzene set musorzene_hossz = '00:".$_GET["mz_min"].":".$_GET["mz_sec"]
    ."', musorzene_jelleg = '".$_GET["mz_jelleg"]."' where musorzene_azonosito = ".$_GET["mz_id"];
$result_music_modify = mysqli_query($conn_main, $query_music_modify);


?>
