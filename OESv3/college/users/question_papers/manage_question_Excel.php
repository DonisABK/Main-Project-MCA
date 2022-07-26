<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `question_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="type-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name ="question_paper_id" value="<?php echo isset($_GET['qid']) ? $_GET['qid'] : (isset($question_paper_id) ? $question_paper_id : '') ?>">
        <div class="row">
              <input type="file" id="myFile" name="filename">

        </div>
		
	</form>
</div>
<noscript id="choice-clone">
<div class="d-flex w-100 choice-item my-3">
    <div class="col-10">
        <textarea type="text" class="form-control form-control-sm rounded-0" name="choice[]"></textarea>
    </div>
    <div class="col-2 text-center">
        <button class="btn btn-sm btn-outline-danger btn-flat rem-choice"><i class="fa fa-times"></i></button>
    </div>
</div>
</noscript>
