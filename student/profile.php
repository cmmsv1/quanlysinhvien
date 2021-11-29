<?php
include('../class/School.php');
$school = new School();
$school->userLoginStatus();
include('../inc/header.php');
?>
<title>Trang cá nhân</title>
<?php include('include_files.php'); ?>
<?php include('../inc/container.php'); ?>
<script src="../js/profile.js"></script>
<?php
if (!empty($_SESSION["userLogin"])) {
    $id = $_SESSION["userLogin"];
}
?>
<div class="container-fluid">
    <?php include('side-menu.php');    ?>
    <div class="content">
        <div class="container-fluid">
            <div>
                <a href="#"><strong><span class="ti-crown"></span> Thông tin cá nhân</strong></a>
                <hr>
                <div class="container">
                    <h4 class="text-center">Thông tin cá nhân</h4>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="">Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="mobile">
                    </div>
                    <input type="hidden" id="userid" name="userid" value="<?php echo $id ?>">
                    <input type="hidden" name="action" id="action" value="updateInforUser" />
                    <button type="submit" class="btn btn-success" id="updateData">Lưu</button>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include('../inc/footer.php'); ?>