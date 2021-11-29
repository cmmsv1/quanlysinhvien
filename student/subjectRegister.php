<?php
include('../class/School.php');
$school = new School();
$school->userLoginStatus();
include('../inc/header.php');
?>
<title>Đăng ký môn học</title>
<?php include('include_files.php'); ?>
<script src="../js/subjectRegister.js"></script>
<?php
if (!empty($_SESSION["userLogin"])) {
    $id = $_SESSION["userLogin"];
}
?>
<?php include('../inc/container.php'); ?>
<div class="container-fluid">
    <?php include('side-menu.php');    ?>
    <div class="content">
        <input type="hidden" id="userid" name="userid" value="<?php echo $id ?>">
        <div class="container-fluid">
            <div>
                <a href="#"><strong><span class="ti-crown"></span> Đăng ký môn học</strong></a>
                <hr>
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="panel-title"></h3>
                        </div>
                    </div>
                </div>
                <table id="classList" class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên lớp</th>
                            <th>Học phần</th>
                            <th>Giảng viên</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>
<?php include('../inc/footer.php'); ?>