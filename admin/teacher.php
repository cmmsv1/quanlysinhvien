<?php
include('../class/School.php');
$school = new School();
$school->adminLoginStatus();
include('../inc/header.php');
?>
<title>Giảng viên</title>
<?php include('include_files.php'); ?>
<script src="../js/teacher.js"></script>
<?php include('../inc/container.php'); ?>
<div class="container-fluid">
	<?php include('side-menu.php');	?>
	<div class="content">
		<div class="container-fluid">
			<div>
				<a href="#"><strong><span class="ti-crown"></span> Giảng viên</strong></a>
				<hr>
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">
							<h3 class="panel-title"></h3>
						</div>
						<div class="col-md-2" align="right">
							<button type="button" name="add" id="addTeacher" class="btn btn-success btn-xs">Thêm giảng viên</button>
						</div>
					</div>
				</div>
				<table id="teacherList" class="table table-bordered table-striped" style="width: 100%;">
					<thead>
						<tr>
							<th>ID</th>
							<th>Họ và tên</th>
							<th>Lớp</th>
							<th>Môn học giảng dạy</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
				</table>

			</div>
		</div>
	</div>
</div>
<div id="teacherModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="teacherForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Sửa tên giảng viên</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="teacher" class="control-label">Tên giảng viên*</label>
						<input type="text" class="form-control" id="teacher_name" name="teacher_name" placeholder="Tên giảng viên" required>
					</div>
					<div class="form-group">
						<label for="mname" class="control-label">Lớp học phần*</label>
						<select name="classid" id="classid" class="form-control" required>
							<option value="">Chọn</option>
							<?php echo $school->classList(); ?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="teacherid" id="teacherid" />
					<input type="hidden" name="action" id="action" value="updateTeacher" />
					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include('../inc/footer.php'); ?>