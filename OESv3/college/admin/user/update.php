
<?php
use SimpleExcel\SimpleExcel;

if(isset($_POST['import'])){

if(move_uploaded_file($_FILES['excel_file']['tmp_name'],$_FILES['excel_file']['name'])){
    require_once('SimpleExcel/SimpleExcel.php'); 
    
    $excel = new SimpleExcel('csv');                  
    
    $excel->parser->loadFile($_FILES['excel_file']['name']);           
    
    $foo = $excel->parser->getField(); 

    $count = 1;
    $db = mysqli_connect('localhost','root','','aqpg');

    while(count($foo)>$count){
        $firstname = $foo[$count][0];
        $lastname = $foo[$count][1];
        $username = $foo[$count][2];
        $password = $foo[$count][3];

        $query = "INSERT INTO  (firstname,lastname,username,password) ";
        $query.="VALUES ('$firstname','$lastname','$username','$password')";
        mysqli_query($db,$query);
        $count++;
    }

    echo "<script>window.location.href='index.php';</script>";
               
    
    
               
    
    
}
   
    
    
}
?>