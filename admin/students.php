<?php
include('../class/School.php');
$school = new School();
$school->adminLoginStatus();
include('../inc/header.php');
?>
<title>Sinh viên</title>
<?php include('include_files.php'); ?>
<script src="../js/students.js"></script>
<?php include('../inc/container.php'); ?>
<div class="container-fluid">
	<?php include('side-menu.php');	?>
	<div class="content">
		<div class="container-fluid">
			<div>
				<a href="#"><strong><span class="ti-crown"></span> Sinh viên</strong></a>
				<hr>
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">
							<h3 class="panel-title"></h3>
						</div>
					</div>
				</div>
				<h4 class="text-center">Danh sách sinh viên</h4>
				<table id="studentList" class="table table-bordered table-striped" style="width: 100%;">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

<?php include('../inc/footer.php'); ?>