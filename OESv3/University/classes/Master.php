<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_content(){
		extract($_POST);
		if(isset($content)){
			foreach($content as $k => $v){
				$save_file = file_put_contents(base_app.$k.".html", $v);
				if(!$save_file){
					break;
				}
			}
			if($save_file){
				$resp['status'] = "success";
				$resp['msg'] = "Content has been updated successfully";
			}else{
				$resp['status'] = "failed";
				$resp['msg'] = "Content has failed to update.";
			}
		}else{
			$resp['status'] = "failed";
			$resp['msg'] = "Content has failed to update.";
		}
		if($resp['status'] == 'success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}
	function save_contact(){
		extract($_POST);
		$allowed_fields = array_keys($_POST);
		$data = "";
		foreach($_POST as $k=>$v){
			if(!empty($data)) $data .= ", ";
			$data .= "('{$this->conn->real_escape_string($k)}','{$this->conn->real_escape_string($v)}')";
		}
		if(!empty($data)){
			$this->conn->query("DELETE * FROM `tbl_system_info` where meta_field in ('".(implode("','", $allowed_fields))."') ");
			$sql = "INSERT INTO `system_info` (`meta_field`, `meta_value`) VALUES {$data}";
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$resp['msg'] = " Contact Information successfully saved.";
				foreach($_POST as $k => $v){
					$this->settings->set_info($k, $v);
				}
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = " Contact Information has failed to update.";
				$resp['error'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Contact Information has failed to update.";
		}
		if($resp['status'] == 'success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);

	}
	function save_course(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		$uid = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		
		if(empty($id)){
			$sql = "INSERT INTO `tbl_course_list` set {$data} ";
		}else{
			$sql = "UPDATE `tbl_course_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Course successfully saved.";
			else
				$resp['msg'] = " Course successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_course(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `tbl_course_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Course successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_class(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		$uid = $this->settings->userdata('id');

		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `tbl_class_list` where `name` = '{$name}' and user_id = '{$uid}' and `course_id` = '{$course_id}' and user_id = '{$this->settings->userdata('id')}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Class already exists on the selected Course.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `tbl_class_list` set {$data} ";
		}else{
			$sql = "UPDATE `tbl_class_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Class successfully saved.";
			else
				$resp['msg'] = " Class successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function save_subject(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		$uid = $this->settings->userdata('id');

		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','subject_code'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}

		$check = $this->conn->query("SELECT * FROM `tbl_subjects` where `subject_code` = '{$subject_code}'  and `course_id` = '{$course_id}'  and delete_flag = 0 ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "subject already exists on the selected Course.";
			return json_encode($resp);
			exit;
		}
		else{
			$table_name_sub_code=$subject_code;
			if(!empty($data)) $data .=" , ";
			$data .= " `subject_code` = '{$table_name_sub_code}' ";
			$sql2 = "CREATE TABLE `$table_name_sub_code` (qs_id int(10) PRIMARY KEY  AUTO_INCREMENT, Question text(2000),answer_key text(2000),credit int(2),Q_Status tinyint(2))";
		
		
		$savea = $this->conn->query($sql2);
		if(empty($id)){
			$sql = "INSERT INTO `tbl_subjects` set {$data} ";
		}
		else{
			$sql = "UPDATE `tbl_subjects` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
	}
		if($save && $savea){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id)){
				$resp['msg'] = "New subject successfully saved.";}
			else{
				$resp['msg'] = " Subject successfully updated.";}
			}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
			$resp['err'] = $this->conn->error."[{$sql2}]";
		}
	
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}


	function delete_class(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `tbl_class_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Class successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_question_paper(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `tbl_question_paper_list` where `title` = '{$title}' and `class_id` = '{$class_id}' and user_id = '{$this->settings->userdata('id')}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Question Paper already exists on the selected Class.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `tbl_question_paper_list` set {$data} ";
		}else{
			$sql = "UPDATE `tbl_question_paper_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$qid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['qid'] = $qid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Question Paper successfully saved.";
			else
				$resp['msg'] = " Question Paper successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function create_table(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		
		$check = $this->conn->query("create table if not exists DBMS (qid int UNSIGNED AUTO_INCREMENT PRIMARY KEY, question TEXT(2000), Answerkey TEXT(2000), point TEXT(2000), Mark int");
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Table already created.";
			return json_encode($resp);
			exit;
		}
	}

	function save_college(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `tbl_registered_college` where `college_id` = '{$college_id}' and delete_flag = 0 ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "College detail already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `tbl_registered_college` set {$data} ";
		}else{
			$sql = "UPDATE `tbl_registered_college` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$qid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['qid'] = $qid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New College details successfully saved.";
			else
				$resp['msg'] = " College details successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_cargo_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `tbl_registered_user_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_subject(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `tbl_subjects` set `delete_flag` = 1 where sub_id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_question(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `tbl_question_list` set {$data} ";
		}else{
			$sql = "UPDATE `tbl_question_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$qid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['qid'] = $qid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Question Paper successfully saved.";
			else
				$resp['msg'] = " Question Paper successfully updated.";
			if(isset($choice)){
				$data = "";
				foreach($choice as $v){
					if(!empty($v)){
						if(!empty($data))  $data .=", ";
						$v = $this->conn->real_escape_string($v);
						$data .= "('{$qid}','{$v}')";
					}
				}
				if(!empty($data)){
					$this->conn->query("DELETE FROM `tbl_choice_list` where question_id = '{$qid}'");
					$sql2 = "INSERT INTO `tbl_choice_list` (`tbl_question_id`, `choice`) VALUES {$data}";
					$save2 = $this->conn->query($sql2);
					if(!$save2){
						$resp['status'] = 'failed';
						$resp['msg'] = "An error occurred while saving the data";
						$resp['erro'] = $this->conn->error;
						$resp['sql'] = $sql;
						if(empty($id)){
							$this->conn->query("DELETE FROM `tbl_question_list` where id = '{$qid}'");
						}
					}
				}
			}
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_question(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `tbl_question_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Question Paper successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_college(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `tbl_registered_college` where c_id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," college successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

}


$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_content':
		echo $Master->save_content();
	break;
	case 'save_contact':
		echo $Master->save_contact();
	break;
	case 'save_course':
		echo $Master->save_course();
	break;
	case 'delete_course':
		echo $Master->delete_course();
	break;
	case 'save_class':
		echo $Master->save_class();
	break;
	case 'delete_class':
		echo $Master->delete_class();
	break;
	case 'save_question_paper':
		echo $Master->save_question_paper();
	break;
	case 'save_college':
		echo $Master->save_college();
	break;
	case 'delete_question_paper':
		echo $Master->delete_question_paper();
	break;
	case 'save_question':
		echo $Master->save_question();
	break;
	case 'delete_question':
		echo $Master->delete_question();
	break;
	case 'delete_college':
		echo $Master->delete_college();
	break;
	case 'delete_cargo_type':
		echo $Master->delete_cargo_type();
	break;
	case 'save_subject':
		echo $Master->save_subject();
	break;
	case 'delete_subject':
		echo $Master->delete_subject();
	break;
	default:
		// echo $sysset->index();
		break;
}