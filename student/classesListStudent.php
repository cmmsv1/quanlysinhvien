<?php
include('../class/School.php');
$school = new School();
$school->userLoginStatus();
include('../inc/header.php');
?>
<title>Danh sách lớp</title>
<?php include('include_files.php'); ?>
<script src="../js/classesListStudent.js"></script>
<?php
if (!empty($_SESSION["userLogin"])) {
    $id = $_SESSION["userLogin"];
}
?>
<?php include('../inc/container.php'); ?>
<div class="container-fluid">
    <?php include('side-menu.php');    ?>
    <div class="content">
        <div class="container-fluid">
            <div>
                <input type="hidden" id="userid" name="userid" value="<?php echo $id ?>">
                <a href="#"><strong><span class="ti-crown"></span> Danh sách lớp</strong></a>
                <hr>
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="panel-title"></h3>
                        </div>
                    </div>
                </div>
                <h4 class="text-center">Các học phần bạn đã đăng ký</h4>
                <table id="classList" class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Tên lớp</th>
                            <th>Học phần</th>
                            <th>Giảng viên</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>
<?php include('../inc/footer.php'); ?>