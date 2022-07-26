<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php
$id=$_GET['sub_id'];
$sql="SELECT c.*,cc.name as `course`, cc.stream as `stream`,ccc.* from `tbl_class_list` c inner join `tbl_course_list` cc on c.course_id = cc.id INNER join `tbl_subjects` ccc on c.course_id = ccc.course_id where c.delete_flag = 0 and ccc.delete_flag=0 and ccc.sub_id='$id' ";
$result= $conn->query($sql);

    if($result->num_rows > 0){
    while($row=$result->fetch_assoc()){

?>

<div class="card card-outline rounded-0 card-primary">
	<div class="card-body">
        <div class="container-fluid">
        <div class="container-fluid">
	<dl>
        <dt class="text-muted">Course : <?php echo $row['name']  ?></dt>
        <dt class="text-muted">Stream : <?php echo $row['course']  ?> </dt>
        <dt class="text-muted">Subject Code : <?php echo $row['subject_code']  ?> </dt>
        <dt class="text-muted">Subject Name : <?php echo $row['sub_name']  ?> </dt>
        <dt class="text-muted">Status :   <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?></dt>
    </dl>
</div>
			
		</div>
	</div>
</div>
<?php
    }}
?>