<?
require "index.php";

?>
<script>
$(document).ready(function(){
    $(".buttonAssign").click(function(){
        $("#buttonAlert").html("Button clicked: " + this.id);
    });
});


</script>
<h1>Próba</h1>
<button type="button" id="button1" class="btn btn-success buttonAssign" >1</button>
<br />
<button type="button" id="button2" class="btn btn-success buttonAssign" >2</button>
<div id="buttonAlert">próba...</div>