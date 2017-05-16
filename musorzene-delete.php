<? 
require "config.php";
require "functions.php";

$query_music_delete = "delete from musorzene where musorzene_azonosito = " . $_GET["musorzene_azonosito"];
$result_music_delete = mysqli_query($conn_main, $query_music_delete);

?>
