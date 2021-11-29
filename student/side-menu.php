<div class="wrapper">
    <div class="sidebar" data-background-color="black" data-active-color="danger">
        <div class="sidebar-wrapper" id="sideLinks">
            <div class="logo">
                <a href="admin.php" class="simple-text">
                    Quản lý sinh viên
                </a>
            </div>
            <ul class="nav">
                <li class="" id="dashboard">
                    <a href="dashboard.php" class="menu-link">
                        <i class="ti-dashboard"></i>
                        <p>Bảng điều khiển</p>
                    </a>
                </li>
                <li id="profile">
                    <a href="profile.php" class="menu-link">
                        <i class="ti-user"></i>
                        <p>Thông tin cá nhân</p>
                    </a>
                </li>
                <li id="subjectRegister">
                    <a href="subjectRegister.php" class="menu-link">
                        <i class="ti-crown"></i>
                        <p>Đăng ký môn học</p>
                    </a>
                </li>
                <li id="classesListStudent">
                    <a href="classesListStudent.php" class="menu-link">
                        <i class="ti-home"></i>
                        <p>Danh sách lớp</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">Hệ thống quản lý sinh viên</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-user"></i>
                                <p class="notification"></p>
                                <p><strong><?php echo $_SESSION["user"]; ?></strong></p>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="settings.php"><i class="fa fa-cog"></i> <strong>Cài đặt</strong></a>
                                </li>
                                <li>
                                    <a href="logout.php"><i class="fa fa-power-off"></i> <strong>Đăng xuất</strong></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>