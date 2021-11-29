<?php
include('../class/School.php');
$school = new School();
$school->userLoginStatus();
include('../inc/header.php');
?>
<title>Quản lý sinh viên</title>
<?php include('include_files.php'); ?>
<?php include('../inc/container.php'); ?>
<div class="container-fluid">
	<?php include('side-menu.php');	?>
	<div class="content">
		<div class="container-fluid">
			<div class="alert alert-success fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><span class="ti ti-announcement fa-2x"></span> </strong> <strong>&nbsp;&nbsp;Chào mừng bạn đến với trang cá nhân!</strong>.
			</div>
		</div>
	</div>
</div>
<?php include('../inc/footer.php'); ?>