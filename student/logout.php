<?php
session_start();
unset($_SESSION['userLogin']);
unset($_SESSION['user']);
header("Location:../index.php");
