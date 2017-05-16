<?
require "index.php";
echo "Hi";
?>

<h1>Adásnapló import</h1>


<form action="adas-upload-xls.php" method="post" enctype="multipart/form-data">
    Adásnapló fájl:&nbsp;&nbsp;&nbsp;
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Import" name="submit">
</form>













