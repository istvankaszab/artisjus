<?
require "index.php";

?>

<h1>Adásnapló import</h1>
A fájl előkészítése:<br />
<ul>
<li>Excel: Mentés másként -> Szöveg (tabulátorral tagolt)</li>
<li>Notepad++</li>
<li>fejlécet nem tartalmazhat</li>
<li>az első sor tartalma ez legyen: adásmenet</li>
<li>további üres sorokat nem tartalmazhat</li>
<li>kódolás átállítása erre: UTF-8</li>
<li>mentés</li>
</ul>

<form action="adas-upload.php" method="post" enctype="multipart/form-data">
    Adásnapló fájl:&nbsp;&nbsp;&nbsp;
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Import" name="submit">
</form>













