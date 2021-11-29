<?php
include('../class/School.php');
$school = new School();
$school->adminLoginStatus();
include('../inc/header.php');
?>
<title>Môn học</title>
<?php include('include_files.php'); ?>
<script src="../js/subjects.js"></script>
<?php include('../inc/container.php'); ?>
<div class="container-fluid">
	<?php include('side-menu.php');	?>
	<div class="content">
		<div class="container-fluid">
			<div>
				<a href="#"><strong><span class="ti-crown"></span> Môn học</strong></a>
				<hr>
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">
							<h3 class="panel-title"></h3>
						</div>
						<div class="col-md-2" align="right">
							<button type="button" name="add" id="addSubject" class="btn btn-success btn-xs">Thêm học phần</button>
						</div>
					</div>
				</div>
				<table id="subjectList" class="table table-bordered table-striped" style="width: 100%;">
					<thead>
						<tr>
							<th>ID</th>
							<th>Tên học phần</th>
							<th>Mã</th>
							<th>Hình thức học</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
				</table>

			</div>
		</div>
	</div>
</div>
<div id="subjectModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="subjectForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Sửa học phần</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="teacher" class="control-label">Tên học phần*</label>
						<input type="text" class="form-control" id="subject" name="subject" placeholder="Tên học phần" required>
					</div>
					<div class="form-group">
						<label for="s_type" class="control-label">Hình thức học</label><br>
						<label class="radio-inline">
							<input type="radio" name="s_type" id="theory" value="Lý thuyết" required>Lý thuyết
						</label>
						<label class="radio-inline">
							<input type="radio" name="s_type" id="practical" value="Thực tế" required>Thực tế
						</label>
					</div>
					<div class="form-group">
						<label for="code" class="control-label">Mã*</label>
						<input type="text" class="form-control" id="code" name="code" placeholder="Mã..." required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="subjectid" id="subjectid" />
					<input type="hidden" name="action" id="action" value="updateSubject" />
					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>