<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Classes</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Course</th>
						<th>Stream</th>
						<th>Semester</th>
						<th>Subject Code</th>
						<th>Subject Name</th>
						<th>Subject Credit</th>
						<th>Description</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT c.*,cc.name as `course`, cc.stream as `stream`,ccc.* from `tbl_class_list` c inner join `tbl_course_list` cc on c.course_id = cc.id  INNER join `tbl_subjects` ccc on c.course_id = ccc.course_id where c.delete_flag = 0 and ccc.delete_flag = 0  and ccc.subject_status = 1 order by cc.`name` asc,c.`name` asc;");
					while($row = $qry->fetch_assoc()):

					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['course'] ?></td>
							<td><?php echo $row['stream'] ?></td>
							<td><?php echo $row['sub_semester'] ?></td>
							<td><?php echo $row['subject_code'] ?></td>
							<td><?php echo $row['sub_name'] ?></td>
							<td><?php echo $row['subject_credit'] ?></td>

							<td ><p class="m-0 truncate-1"><?= $row['description'] ?></p></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="./?page=subjects/view_subject&sub_id=<?php echo $row['sub_id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item upload_data" href="./?page=subjects/upload_subjects&sub_id=<?php echo $row['sub_id'] ?>"><span class="fa fa-eye text-dark"></span> Upload Syllabus</a>

				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_subject" href="javascript:void(0)" data-id="<?php echo $row['sub_id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_subject').click(function(){
			_conf("Are you sure to delete this subject permanently?","delete_subject",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add New subject ","subjects/manage_subject.php")
		})
		$('.view_data').click(function(){
			uni_modal("<i class='fa fa-eye'></i> Subject Details","subject/view_subject.php?sub_id="+$(this).attr('data-id'))
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Update Subject Details","subjects/manage_subject.php?sub_id="+$(this).attr('data-id'))
		})
		$('.upload_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Upload syllabus","subjects/upload_subjects.php?sub_id="+$(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4,5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_subject($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_subject",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>