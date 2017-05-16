<? 
require "config.php";

foreach($_GET as $key=>$value) {
    $parameters[] = $key;
    $parameters[] = $value;
}

$musor = new Musor($parameters[1]);
if($parameters[2] == "feldolgozva") {
    $musor->setFeldolgozva($parameters[3]);
    $musor->storeFeldolgozva();
}




/*
    assignMZ, musor_id, zene_id
    deleteMZ, musorzene_id
    modifyMZ, musorzene_id, parameter, value
    modifyM, musor_id, parameter, value

*/
/*
$funcToDo = "assignMZ";
if($funcToDo == "assignMZ") {

}
elseif($funcToDo =="deleteMZ") {

}
elseif($funcToDo == "modifyMZ") {

}
elseif($funcToDo == "modifyM") {
    $query_musor_modify = "update musor set feldolgozva = ".$_GET["feldolgozva"]
        ." where musor_id = '".$_GET["musor_id"]."'";
    mysqli_query($conn_main, $query_musor_modify);
}
*/

?>