<?php

require_once('../../config.php');

?>
<div class="container-fluid">
	<form action="" id="type-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
		<div class="col-md-4">
						<div class="form-group">
							<label for="college_id" class="control-label text-sm">College ID</label>
							<input type="text" name="college_id" id="college_id" class="form-control form-control-sm form-control-border" value="<?= isset($college_id) ? $college_id : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
<div class="row">
		<div class="col-md-4">
						<div class="form-group">
							<label for="College_name" class="control-label text-sm">College Name</label>
							<input type="text" name="College_name" id="College_name" class="form-control form-control-sm form-control-border" value="<?= isset($College_name) ? $College_name : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
<div class="row">
		<div class="col-md-6">
						<div class="form-group">
							<label for="College_address" class="control-label text-sm">College Address</label>
							<input type="text" name="College_address" id="College_address" class="form-control form-control-sm form-control-border" value="<?= isset($College_address) ? $College_address : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="College_phno" class="control-label text-sm">Phone Number</label>
							<input type="text" name="College_phno" id="College_phno" class="form-control form-control-sm form-control-border" value="<?= isset($College_phno) ? $College_phno : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="College_email" class="control-label text-sm">Email</label>
							<input type="text" name="College_email" id="College_email" class="form-control form-control-sm form-control-border" value="<?= isset($College_email) ? $College_email : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="College_website" class="control-label text-sm">Website</label>
							<input type="text" name="College_website" id="College_website" class="form-control form-control-sm form-control-border" value="<?= isset($College_website) ? $College_website : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Manager" class="control-label text-sm">Manager</label>
							<input type="text" name="Manager" id="Manager" class="form-control form-control-sm form-control-border" value="<?= isset($Manager) ? $Manager : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Manager_email" class="control-label text-sm">Manager Email</label>
							<input type="text" name="Manager_email" id="Manager_email" class="form-control form-control-sm form-control-border" value="<?= isset($Manager_email) ? $Manager_email : '' ?>" placefolder="optional">
						</div>
					</div>
</div>
		
		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
			</select>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#uni_modal').on("shown.bs.modal",function(){
			$('.select2').select2({
				placeholder:"Please Select Here",
				width:"100%",
				dropdownParent:$('#uni_modal')
			})
		})
		$('#type-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_college",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = ("./?page=registered_college/view_college&id="+resp.qid)
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>