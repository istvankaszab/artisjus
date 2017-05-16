<? 
require "config.php";
require "functions.php";


$query_music_to_assign = "select zene_jelleg, zene_hossz from zene where zene_id = ".$_GET["zene_id"];
$result_music_to_assign = mysqli_query($conn_main, $query_music_to_assign);
$music_to_assign=mysqli_fetch_array($result_music_to_assign);

$query_music_assign = "insert into musorzene (musor_id, zene_id, musorzene_jelleg, musorzene_hossz) 
    values ('".$_GET["musor_id"]."', ".$_GET["zene_id"].", '".$music_to_assign["zene_jelleg"]."', '".$music_to_assign["zene_hossz"]."')";
$result_music_assign = mysqli_query($conn_main, $query_music_assign);


?>