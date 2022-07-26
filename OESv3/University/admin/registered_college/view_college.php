<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php
$id=$_GET['id'];
$sql="SELECT * FROM `tbl_registered_college` where c_id = '$id' and delete_flag = 0 ";
$result= $conn->query($sql);

    if($result->num_rows > 0){
    while($row=$result->fetch_assoc()){

?>

<div class="card card-outline rounded-0 card-primary">
	<div class="card-body">
        <div class="container-fluid">
        <div class="container-fluid">
	<dl>
        <dt class="text-muted">College ID : <?php echo $row['college_id']  ?></dt>
        <dt class="text-muted">College Name : <?php echo $row['College_name']  ?> </dt>
        <dt class="text-muted">College Address : <?php echo $row['College_address']  ?> </dt>
        <dt class="text-muted">College Phone No : <?php echo $row['College_phno']  ?> </dt>
        <dt class="text-muted">College Email : <?php echo $row['College_email']  ?> </dt>
        <dt class="text-muted">College Website : <?php echo $row['College_website']  ?> </dt>
        <dt class="text-muted">Manager : <?php echo $row['Manager']  ?> </dt>
        <dt class="text-muted">Manager Email ID : <?php echo $row['Manager_email']  ?> </dt>

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