<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
    <?php endif;?>
    <div class="card card-outline rounded-0 card-primary">
        <div class="card-header">
            <h3 class="card-title">List of Subjects</h3>
            <div class="card-tools">
                <a href="" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>Create New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
            <form action="file.php" id="type-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="course_id" class="control-label">Course</label>
			<select name="course_id" id="course_id" class="form-control form-control-sm rounded-0 select2" required>
				<option value="" disabled <?= !isset($course_id) ? 'selected' : "" ?>></option>
				<?php 
				$course = $conn->query("SELECT * FROM `tbl_course_list` where delete_flag = '0' and `status` = 1 and user_id = '{$_settings->userdata('id')}' ".(isset($course_id) ? " or id = '{$course_id}'" : "")."  order by `name` asc");
				while($row = $course->fetch_assoc()):
				?>
					<option value="<?= $row['id'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Subject Code</label>
			<input type="text" name="name" id="subject_code" class="form-control form-control-sm rounded-0" value="<?php echo isset($subject_code) ? $subject_code : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Subject Name</label>
			<input type="text" name="name" id="subject_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($subject_name) ? $subject_name : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Subject Credit</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>0</option>
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>1</option>
			<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>2</option>
			<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>3</option>
			<option value="4" <?php echo isset($status) && $status == 4 ? 'selected' : '' ?>>4</option>

			</select>
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Subject Status</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
			</select>
		</div>
	</form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.delete_subject').click(function(){
                _conf("Are you sure to delete this subject permanently?","delete_subject",[$(this).attr('data-id')])
            })
            $('#create_new').click(function(){
                uni_modal("<i class='fa fa-plus'></i> Add New ","subjects/manage_subject.php")
            })
            $('.view_data').click(function(){
                uni_modal("<i class='fa fa-eye'></i> Class Details","subjects/view_subject.php?id="+$(this).attr('data-id'))
            })
            $('.edit_data').click(function(){
                uni_modal("<i class='fa fa-edit'></i> Update Class Details","subjects/manage_subject.php?id="+$(this).attr('data-id'))
            })
            $('.table').dataTable({
                columnDefs: [
                        { orderable: false, targets: [4,5] }
                ],
                order:[0,'asc']
            });
            $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
        })
        </script>
    