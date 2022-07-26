
<?php
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
require('../../config.php');

if(isset($_POST['Submit'])){


    $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
    if(in_array($_FILES["file"]["type"],$mimes)){
  
  
      $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
      move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
  
  
      $Reader = new SpreadsheetReader($uploadFilePath);
  
  
      $totalSheet = count($Reader->sheets());
  
  
      echo "You have total ".$totalSheet." sheets".
  
  
      $html="<table border='1'>";
      $html.="<tr><th>College_id</th><th>College_name</th></tr>";
  
  
      /* For Loop for all sheets */
      for($i=0;$i<$totalSheet;$i++){
  
  
        $Reader->ChangeSheet($i);
  
  
        foreach ($Reader as $Row)
        {
          $html.="<tr>";
          $college_id = isset($Row[0]) ? $Row[0] : '';
          $College_name = isset($Row[1]) ? $Row[1] : '';
          $html.="<td>".$college_id."</td>";
          $html.="<td>".$College_name."</td>";
          $html.="</tr>";
  
  
          $query = "insert into items(title,description) values('".$college_id."','".$College_name."')";
  
  
          $mysqli->query($query);
         }
  
  
      }
  
  
      $html.="</table>";
      echo $html;
      echo "<br />Data Inserted in dababase";
  
  
    }else { 
      die("<br/>Sorry, File type is not allowed. Only Excel file."); 
    }
  
  
  }
  
  
  ?>

<div class="card card-outline rounded-0 card-primary">
	<div class="card-body">
        <form method='POST' action='' enctype='multipart/form-data'>
        <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Avatar</label>
							<div class="custom-file">
								<input type="file" class="custom-file-input rounded-circle" id="file" name="file" onchange="javascript:updateList()" >
								<label class="custom-file-label" for="file">Choose file</label>
							</div>
                            <br/> Selected file:
                            <div id="fileList"></div>
						</div>
					</div>
				</div>
                <input type= "submit" value="import" name="import">
    </form>
	</div>
</div>
<script>
    updateList = function() {
  var input = document.getElementById('file');
  var output = document.getElementById('fileList');

  output.innerHTML = '<ul>';
  for (var i = 0; i < input.files.length; ++i) {
    output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
  }
  output.innerHTML += '</ul>';
}
    </script>