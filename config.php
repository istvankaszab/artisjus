<?
error_reporting(E_ALL);

require "functions.php";
require "Classes/DB.class.php";
require "Classes/Musor.class.php";

//     artisjus adatbazis csatlakozas
$db_host_main='localhost';
$db_name_main='artisjus';
$db_user_main='root';
$db_passwd_main='';

$conn_main=mysqli_connect($db_host_main, $db_user_main, $db_passwd_main, $db_name_main);
mysqli_query($conn_main, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'" );

$sorok_szama = 20;

?>
