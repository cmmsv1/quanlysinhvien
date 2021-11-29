<?php
session_start();
require('config.php');
class School extends Dbconfig
{
	protected $hostName;
	protected $userName;
	protected $password;
	protected $dbName;
	private $userTable = 'sms_user';
	private $studentTable = 'sms_students';
	private $classesTable = 'sms_classes';
	private $teacherTable = 'sms_teacher';
	private $subjectsTable = 'sms_subjects';
	private $dbConnect = false;
	public function __construct()
	{
		if (!$this->dbConnect) {
			$database = new dbConfig();
			$this->hostName = $database->serverName;
			$this->userName = $database->userName;
			$this->password = $database->password;
			$this->dbName = $database->dbName;
			$conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
			if ($conn->connect_error) {
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			} else {
				$this->dbConnect = $conn;
			}
		}
	}
	public function adminLoginStatus()
	{
		if (empty($_SESSION["adminUserid"])) {
			header("Location: ../login.php");
		}
	}
	public function userLoginStatus()
	{
		if (empty($_SESSION["userLogin"])) {
			header("Location: ../login.php");
		}
	}
	public function isLoggedin()
	{
		if (!empty($_SESSION["adminUserid"])) {
			return true;
		} elseif (!empty($_SESSION["userLogin"])) {
			return true;
		} else {
			return false;
		}
	}
	public function adminLogin()
	{
		$errorMessage = '';
		if (!empty($_POST["login"]) && $_POST["email"] != '' && $_POST["password"] != '') {
			$email = $_POST['email'];
			$password = $_POST['password'];
			$sqlQuery = "SELECT * FROM " . $this->userTable . " 
				WHERE email='" . $email . "' AND password='" . md5($password) . "' AND type = 'admin'";
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery) or die("error");
			$isValidLogin = mysqli_num_rows($resultSet);
			if ($isValidLogin) {
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION["adminUserid"] = $userDetails['id'];
				$_SESSION["admin"] = $userDetails['first_name'] . " " . $userDetails['last_name'];
				header("location: admin/dashboard.php");
			} else {
				$errorMessage = "Invalid login!";
			}
		} else if (!empty($_POST["login"])) {
			$errorMessage = "Enter Both user and password!";
		}
		return $errorMessage;
	}
	public function userLogin()
	{
		$errorMessage = '';
		if (!empty($_POST["login"]) && $_POST["email"] != '' && $_POST["password"] != '') {
			$email = $_POST['email'];
			$password = $_POST['password'];
			$sqlQuery = "SELECT * FROM " . $this->userTable . " 
				WHERE email='" . $email . "' AND password='" . md5($password) . "' AND type = 'user'";
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery) or die("error");
			$isValidLogin = mysqli_num_rows($resultSet);
			if ($isValidLogin) {
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION["userLogin"] = $userDetails['id'];
				$_SESSION["user"] = $userDetails['first_name'] . " " . $userDetails['last_name'];
				header("location: student/dashboard.php");
			} else {
				$errorMessage = "Invalid login!";
			}
		} else if (!empty($_POST["login"])) {
			$errorMessage = "Enter Both user and password!";
		}
		return $errorMessage;
	}


	/*****************Class methods****************/
	public function listClasses()
	{
		$sqlQuery = "SELECT c.id, c.class, t.subject , te.teacher 
			FROM " . $this->classesTable . " as c
			LEFT JOIN " . $this->subjectsTable . " as t ON c.subject_id = t.id
			LEFT JOIN " . $this->teacherTable . " as te ON c.id = te.class_id ";

		if ($_POST["length"] != -1) {
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$classesData = array();
		while ($classes = mysqli_fetch_assoc($result)) {
			$classesRows = array();
			$classesRows[] = $classes['id'];
			$classesRows[] = $classes['class'];
			$classesRows[] = $classes['subject'];
			$classesRows[] = $classes['teacher'];
			$classesRows[] = '<button type="button" name="update" id="' . $classes["id"] . '" class="btn btn-warning btn-xs update">Update</button>';
			$classesRows[] = '<button type="button" name="delete" id="' . $classes["id"] . '" class="btn btn-danger btn-xs delete" >Delete</button>';
			$classesData[] = $classesRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$classesData
		);
		echo json_encode($output);
	}
	public function classList()
	{
		$sqlQuery = "SELECT * FROM " . $this->classesTable;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$classHTML = '';
		while ($class = mysqli_fetch_assoc($result)) {
			$classHTML .= '<option value="' . $class["id"] . '">' . $class["class"] . '</option>';
		}
		return $classHTML;
	}
	public function addClass()
	{
		if ($_POST["cname"]) {
			$insertQuery = "INSERT INTO " . $this->classesTable . "(class, subject_id) 
				VALUES ('" . $_POST["cname"] . "', '" . $_POST["subjectid"] . "')";
			$userSaved = mysqli_query($this->dbConnect, $insertQuery);
		}
	}
	public function getClassesDetails()
	{
		$sqlQuery = "SELECT *
			FROM " . $this->classesTable . "
			WHERE id = '" . $_POST["classid"] . "' ";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	public function updateClass()
	{
		if ($_POST['classid']) {
			$updateQuery = "UPDATE " . $this->classesTable . " 
			SET class = '" . $_POST["cname"] . "', subject_id = '" . $_POST["subjectid"] . "'
			WHERE id ='" . $_POST["classid"] . "'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);
		}
	}
	public function deleteClass()
	{
		if ($_POST["classid"]) {
			$sqlUpdate = "
				DELETE FROM " . $this->classesTable . "
				WHERE id = '" . $_POST["classid"] . "'";
			mysqli_query($this->dbConnect, $sqlUpdate);
		}
	}
	/*****************Student methods****************/
	public function listStudent()
	{
		$sql = "SELECT s.id, s.name, s.email , s.mobile 
						FROM sms_user as s
						WHERE s.type = 'user' ";
		$totalQuery = mysqli_query($this->dbConnect, $sql);
		$total_all_rows = mysqli_num_rows($totalQuery);

		if ($_POST['length'] != -1) {
			$start = $_POST['start'];
			$length = $_POST['length'];
			$sql .= " LIMIT  " . $start . ", " . $length;
		}

		$query = mysqli_query($this->dbConnect, $sql);
		$count_rows = mysqli_num_rows($query);
		$data = array();
		while ($row = mysqli_fetch_assoc($query)) {
			$sub_array = array();
			$sub_array[] = $row['id'];
			$sub_array[] = $row['name'];
			$sub_array[] = $row['email'];
			$sub_array[] = $row['mobile'];
			$sub_array[] = '<button type="button" name="delete" id="' . $row["id"] . '" class="btn btn-danger btn-xs delete" >Delete</button>';
			$data[] = $sub_array;
		}
		$output = array(

			'recordsTotal' => $count_rows,
			'recordsFiltered' =>   $total_all_rows,
			'data' => $data,
		);
		echo  json_encode($output);
	}
	// public function getStudentDetails()
	// {
	// 	$sqlQuery = "SELECT s.id, s.name, s.photo, s.gender, s.mobile, s.email, s.current_address, s.class, s.section 
	// 		FROM " . $this->studentTable . " as s
	// 		LEFT JOIN " . $this->classesTable . " as c ON s.class = c.id 
	// 		WHERE s.id = '" . $_POST["studentid"] . "'";
	// 	$result = mysqli_query($this->dbConnect, $sqlQuery);
	// 	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	// 	echo json_encode($row);
	// }
	// public function updateStudent()
	// {
	// 	if ($_POST['studentid']) {
	// 		if ($_FILES["photo"]["name"]) {
	// 			$target_dir = "upload/";
	// 			$fileName = time() . $_FILES["photo"]["name"];
	// 			$targetFile = $target_dir . basename($fileName);
	// 			if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
	// 				echo "The file $fileName has been uploaded.";
	// 				$photoUpdate = ", photo = '$fileName'";
	// 			} else {
	// 				echo "Sorry, there was an error uploading your file.";
	// 			}
	// 		}
	// 		$updateQuery = "UPDATE " . $this->studentTable . " 
	// 		SET name = '" . $_POST["sname"] . "', email = '" . $_POST["email"] . "', mobile = '" . $_POST["mobile"] . "', gender = '" . $_POST["gender"] . "', current_address = '" . $_POST["address"] . "',  class = '" . $_POST["classid"] . "', section = '" . $_POST["sectionid"] . "',   $photoUpdate
	// 		WHERE id ='" . $_POST["studentid"] . "'";
	// 		echo $updateQuery;
	// 		$isUpdated = mysqli_query($this->dbConnect, $updateQuery);
	// 	}
	// }
	public function deleteStudent()
	{
		if ($_POST["studentid"]) {
			$sqlUpdate = "
				DELETE FROM " . $this->studentTable . "
				WHERE id = '" . $_POST["studentid"] . "'";
			mysqli_query($this->dbConnect, $sqlUpdate);
		}
	}

	/*****************Section methods****************/
	public function listTeacher()
	{
		$sqlQuery = "SELECT t.id, t.teacher, s.class , su.subject		
			FROM " . $this->teacherTable . " as t 
			LEFT JOIN " . $this->classesTable . " as s ON t.class_id = s.id 
			LEFT JOIN " . $this->subjectsTable . " as su ON s.subject_id = su.id ";
		if ($_POST["length"] != -1) {
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$teacherData = array();
		while ($teacher = mysqli_fetch_assoc($result)) {
			$teacherRows = array();
			$teacherRows[] = $teacher['id'];
			$teacherRows[] = $teacher['teacher'];
			$teacherRows[] = $teacher['class'];
			$teacherRows[] = $teacher['subject'];

			$teacherRows[] = '<button type="button" name="update" id="' . $teacher["id"] . '" class="btn btn-warning btn-xs update">Update</button>';
			$teacherRows[] = '<button type="button" name="delete" id="' . $teacher["id"] . '" class="btn btn-danger btn-xs delete" >Delete</button>';
			$teacherData[] = $teacherRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$teacherData
		);
		echo json_encode($output);
	}
	public function addTeacher()
	{
		if ($_POST["teacher_name"]) {
			$insertQuery = "INSERT INTO " . $this->teacherTable . "(teacher,class_id) 
				VALUES ('" . $_POST["teacher_name"] . "', '" . $_POST["classid"] . "')";
			$userSaved = mysqli_query($this->dbConnect, $insertQuery);
		}
	}
	public function getTeacher()
	{
		$sqlQuery = "
			SELECT * FROM " . $this->teacherTable . " 
			WHERE id = '" . $_POST["teacherid"] . "'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	public function getTeacherList()
	{
		$sqlQuery = "SELECT * FROM " . $this->teacherTable;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$teacherHTML = '';
		while ($teacher = mysqli_fetch_assoc($result)) {
			$teacherHTML .= '<option value="' . $teacher["teacher_id"] . '">' . $teacher["teacher"] . '</option>';
		}
		return $teacherHTML;
	}
	public function updateTeacher()
	{
		if ($_POST['teacherid']) {
			$updateQuery = "UPDATE " . $this->teacherTable . " 
			SET teacher = '" . $_POST["teacher_name"] . "', class_id = '" . $_POST["classid"] . "'
			WHERE id ='" . $_POST["teacherid"] . "'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);
		}
	}
	public function deleteTeacher()
	{
		if ($_POST["teacherid"]) {
			$sqlUpdate = "
				DELETE FROM " . $this->teacherTable . "
				WHERE id = '" . $_POST["teacherid"] . "'";
			mysqli_query($this->dbConnect, $sqlUpdate);
		}
	}
	/*****************Subject methods****************/
	public function listSubject()
	{
		$sqlQuery = "SELECT id, subject, type, code 
			FROM " . $this->subjectsTable . " ";
		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' WHERE (id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR subject LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR type LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR code LIKE "%' . $_POST["search"]["value"] . '%" ';
		}
		if (!empty($_POST["order"])) {
			$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		if ($_POST["length"] != -1) {
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$subjectData = array();
		while ($subject = mysqli_fetch_assoc($result)) {
			$subjectRows = array();
			$subjectRows[] = $subject['id'];
			$subjectRows[] = $subject['subject'];
			$subjectRows[] = $subject['code'];
			$subjectRows[] = $subject['type'];
			$subjectRows[] = '<button type="button" name="update" id="' . $subject["id"] . '" class="btn btn-warning btn-xs update">Update</button>';
			$subjectRows[] = '<button type="button" name="delete" id="' . $subject["id"] . '" class="btn btn-danger btn-xs delete" >Delete</button>';
			$subjectData[] = $subjectRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$subjectData
		);
		echo json_encode($output);
	}
	public function addSubject()
	{
		if ($_POST["subject"]) {
			$insertQuery = "INSERT INTO " . $this->subjectsTable . "(subject, type, code) 
				VALUES ('" . $_POST["subject"] . "', '" . $_POST["s_type"] . "', '" . $_POST["code"] . "')";
			$userSaved = mysqli_query($this->dbConnect, $insertQuery);
		}
	}
	public function getSubject()
	{
		$sqlQuery = "
			SELECT * FROM " . $this->subjectsTable . " 
			WHERE id = '" . $_POST["subjectid"] . "'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	public function getSubjectList()
	{
		$sqlQuery = "SELECT * FROM " . $this->subjectsTable;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$subjectHTML = '';
		while ($subject = mysqli_fetch_assoc($result)) {
			$subjectHTML .= '<option value="' . $subject["id"] . '">' . $subject["subject"] . '</option>';
		}
		return $subjectHTML;
	}
	public function updateSubject()
	{
		if ($_POST['subjectid']) {
			$updateQuery = "UPDATE " . $this->subjectsTable . " 
			SET subject = '" . $_POST["subject"] . "', type = '" . $_POST["s_type"] . "', code = '" . $_POST["code"] . "'
			WHERE id ='" . $_POST["subjectid"] . "'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);
		}
	}
	public function deleteSubject()
	{
		if ($_POST["subjectid"]) {
			$sqlUpdate = "
				DELETE FROM " . $this->subjectsTable . "
				WHERE id = '" . $_POST["subjectid"] . "'";
			mysqli_query($this->dbConnect, $sqlUpdate);
		}
	}

	// *************** edit user *******
	public function getInforUser()
	{
		$sqlQuery = "
			SELECT * FROM " . $this->userTable . " 
			WHERE id = '" . $_POST["userid"] . "'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	public function updateInforUser()
	{
		if ($_POST['userid']) {
			$updateQuery = "UPDATE " . $this->userTable . " 
			SET name = '" . $_POST["name"] . "', email = '" . $_POST["email"] . "', mobile = '" . $_POST["mobile"] . "'
			WHERE id ='" . $_POST["userid"] . "'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);
			$success = "Cập nhật thông tin thành công";
			echo json_encode($success);
		}
	}


	// ****************RegisterSubject**************
	public function listClassesRegister()
	{
		$sqlQuery = "SELECT c.id, c.class, t.subject , te.teacher 
			FROM " . $this->classesTable . " as c
			LEFT JOIN " . $this->subjectsTable . " as t ON c.subject_id = t.id
			LEFT JOIN " . $this->teacherTable . " as te ON c.id = te.class_id ";

		if ($_POST["length"] != -1) {
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$classesData = array();
		while ($classes = mysqli_fetch_assoc($result)) {
			$classesRows = array();
			$classesRows[] = $classes['id'];
			$classesRows[] = $classes['class'];
			$classesRows[] = $classes['subject'];
			$classesRows[] = $classes['teacher'];
			$classesRows[] = '<button type="button" name="register" id="' . $classes["id"] . '" class="btn btn-success btn-xs register">Đăng ký</button>';
			$classesData[] = $classesRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$classesData
		);
		echo json_encode($output);
	}
	public function insertStudentRegister()
	{
		if ($_POST['userid']) {
			$sqlQuery = "SELECT * FROM " . $this->studentTable . " 
				WHERE user_id='" . $_POST["userid"] . "' AND class_id='" . $_POST["classid"] . "' ";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			$isValidQuery = mysqli_num_rows($result);
			if ($isValidQuery) {
				$error = "Bạn đã đăng ký lớp này";
				echo json_encode($error);
			} else {
				$insertQuery = "INSERT " . $this->studentTable . " 
				SET user_id = '" . $_POST["userid"] . "', class_id = '" . $_POST["classid"] . "' ";
				$isUpdated = mysqli_query($this->dbConnect, $insertQuery);
				$success = "Đăng ký thành công";
				echo json_encode($success);
			}
		}
	}
	public function listClassesStudent()
	{
		if ($_POST['userid']) {
			$sqlQuery = "SELECT te.teacher, t.class, su.subject
			FROM " . $this->studentTable . " as s
			LEFT JOIN " . $this->classesTable . " as t ON s.class_id = t.id
			LEFT JOIN " . $this->subjectsTable . " as su ON t.subject_id = su.id
			LEFT JOIN " . $this->teacherTable . " as te ON s.class_id = te.class_id 
			WHERE s.user_id = '" . $_POST['userid'] . "'";

			if ($_POST["length"] != -1) {
				$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			$numRows = mysqli_num_rows($result);
			$classesData = array();
			while ($classes = mysqli_fetch_assoc($result)) {
				$classesRows = array();
				$classesRows[] = $classes['class'];
				$classesRows[] = $classes['subject'];
				$classesRows[] = $classes['teacher'];
				$classesData[] = $classesRows;
			}
			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"  	=>  $numRows,
				"recordsFiltered" 	=> 	$numRows,
				"data"    			=> 	$classesData
			);
			echo json_encode($output);
		}
	}
}
