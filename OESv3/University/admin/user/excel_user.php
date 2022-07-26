<?php 
require_once("./../../config.php");
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
}
?>
<div class="container-fluid">
    <div id="msg"></div>
    <form action="update.php" method="post" enctype="multipart/form-data">	
        <div class="form-group">
            <label for="" class="control-label">Choose Excel File</label>
            <div class="custom-file">
            <input type="file" name="excel_file" accept=".csv">
            <input type="submit" name="import" value="Import">
            </div>
        </div>
       
    </form>
</div>

