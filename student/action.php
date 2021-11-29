<?php
include('../class/School.php');
$school = new School();

if (!empty($_POST['action']) && $_POST['action'] == 'getInforUser') {
	$school->getInforUser();
}
if (!empty($_POST['action']) && $_POST['action'] == 'updateInforUser') {
	$school->updateInforUser();
}
if (!empty($_POST['action']) && $_POST['action'] == 'listClassesRegister') {
	$school->listClassesRegister();
}
if (!empty($_POST['action']) && $_POST['action'] == 'insertStudentRegister') {
	$school->insertStudentRegister();
}
if (!empty($_POST['action']) && $_POST['action'] == 'listClassesStudent') {
	$school->listClassesStudent();
}
