<?php 
if(isset($_GET['id']))
{
   $id= $_GET['id'];
	$user = $conn->query("SELECT * FROM tbl_registered_user_list where id ='".$_GET['id']."'");
	foreach($user->fetch_array() as $k =>$v){
		$$k = $v;
	}
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-body">

            <form method="post" action="mailer.php">
                <div class="container-fluid">
                    <div id="msg"></div>

                <div class="container-fluid">
                <table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>First Name</th>
                        <th>Last Name</th>
						<th>Email</th>
						<th>Password</th>
                        <th>User Name</th>
						
					</tr>
				</thead>
				<tbody>
                     <?php  
                    $s=mysqli_query($conn,"SELECT * FROM tbl_registered_user_list where id ='$id'");
                    $row=mysqli_fetch_assoc($s);
					?>
						<tr>
                        <td><input type="text"  name="fname" value="<?php echo $row['firstname'];?> "></td>
                        <td><input type="text"  name="lname" value="<?php echo $row['lastname'];?> "></td>
                        <td><input type="text"  name="email" value="<?php echo $row['email'];?> "></td>
                        <td><input type="text"  name="psw" value="<?php echo $row['password'];?> "></td>
                        <td><input type="text"  name="uname" value="<?php echo $row['uname'];?> "></td>
                        
                    <td><button class="btn btn-sm btn-primary" name="email">email</button></td>
						</tr>
					
				</tbody>
			    </table>
		     </div>
                

			</form>
		</div>
	</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>

