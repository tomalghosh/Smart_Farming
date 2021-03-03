<?php 
	session_start();

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'smart_farming');

	// variable declaration
	$username = "";
	$email    = "";
	$errors   = array(); 

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
	}

	if (isset($_POST['editUser_btn'])) {
		editUser();
	}

    /*
    if (isset($_POST['editHod_btn'])) {
		editHod();
	*/

	// call the login() function if login_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: login.php");
	}

	if (isset($_POST['newEvent_btn'])) {
		newEvent();
	}

	if (isset($_POST['editEvent_btn'])) {
		editEvent();
	}

	if (isset($_POST['editCerti_btn'])) {
		editCerti();
	}

	// REGISTER USER
	function register(){
		global $db, $errors;

		// receive all input values from the form
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);
		
		
		$duplicate=mysqli_query($db,"select * from users where user_email='$email'");
	
			// form validation: ensure that the form is correctly filled
			if (mysqli_num_rows($duplicate)>0){
				array_push($errors, "Email ID already exists.");
			}
			if (empty($username)) { 
				array_push($errors, "Name is required"); 
			}
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				if (empty($email)) { 
					array_push($errors, "Email is required"); 
				}
				else{
					array_push($errors, "Invalid Email format");
				}
			}
			
			if (empty($password_1)) { 
				array_push($errors, "Password is required"); 
			}
			if ($password_1 != $password_2) {
				array_push($errors, "The two passwords do not match");
			}

			// register user if there are no errors in the form
			if (count($errors) == 0) {
				$password = md5($password_1);//encrypt the password before saving in the database

				if (isset($_POST['user_type'])) {
					$user_type=e($_POST['user_type']);
					$query = "INSERT INTO users (user_name, user_email,  user_password,user_type) 
							VALUES('$username', '$email', '$password', '$user_type')";
					mysqli_query($db, $query);
					$_SESSION['success']  = "New user successfully created!!";
					header('location: admin.php');
				}else{
					$query = "INSERT INTO users (user_name, user_email,  user_password,user_type) 
							VALUES('$username', '$email', '$password', 'user')";
					mysqli_query($db, $query);

					// get id of the created user
					$logged_in_user_id = mysqli_insert_id($db);

					$_SESSION['id'] = $logged_in_user_id;
					$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
					$_SESSION['success']  = "You are now logged in";
					header('location: login.php');				
				}

			}
		
	}

	//EDIT USER
	function editUser(){
		global $db, $errors;

		// receive all input values from the form
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);
		$id 		 =  e($_POST['userId']);

		$duplicate=mysqli_query($db,"SELECT * from users where email='$email' AND id<>'$id'");

			// form validation: ensure that the form is correctly filled
			if (mysqli_num_rows($duplicate)>0){
				array_push($errors, "Email ID already exists.");
			}
			if (empty($username)) { 
				array_push($errors, "Username is required"); 
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				if (empty($email)) { 
					array_push($errors, "Email is required"); 
				}
				else{
					array_push($errors, "Invalid Email format");
				}
			}

			if ($password_1 == NULL){
				if (!empty($password_2)){
					array_push($errors, "Password is missing");
				}
				
			}
	
			if ($password_2 == NULL){
				if (!empty($password_1)){
					array_push($errors, "Confirm Password is missing");
				}
			}

			
			if (!empty($password_1) && !empty($password_2) && $password_1 != $password_2) {
				array_push($errors, "The two passwords do not match");
			}

			// register user if there are no errors in the form
			if (count($errors) == 0) {
				$password = md5($password_1);//encrypt the password before saving in the database

				// if (isset($_POST['user_type'])) {
				// 	$user_type = e($_POST['user_type']);
				// 	$query = "UPDATE users SET username='$username', email='$email', user_type='admin', password='$password' WHERE id=$id";
				// 	mysqli_query($db, $query);
				// 	$_SESSION['success']  = "User Edited Successfully created!!";
				// 	header('location: view_users.php');
				// }
				// else{
					if(!empty($password_1)){
						$query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id=$id";
						mysqli_query($db, $query);
					}
					else{
						$query = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
						mysqli_query($db, $query);
					}
					

					$_SESSION['message'] = "User Updated Successfully";
					header('location: view_users.php');	
					
				//}

			}
		
	}

	//EDIT HOD
	function editHod(){
		global $db, $errors;

		// receive all input values from the form
		$hodname    =  e($_POST['hodname']);
		$hoddept	=  e($_POST['hoddept']);
		$hoddeptfull=  e($_POST['hoddeptfull']);
		$id 		 =  e($_POST['hodId']);

		$duplicate=mysqli_query($db,"SELECT * from hod where hod_name='$hodname' AND hod_id<>'$id'");

			// form validation: ensure that the form is correctly filled
			if (mysqli_num_rows($duplicate)>0){
				array_push($errors, "HOD Name already exists.");
			}
			if (empty($hodname)) { 
				array_push($errors, "Name is required"); 
			}
			

			// register user if there are no errors in the form
			if (count($errors) == 0) {
				//$password = md5($password_1);//encrypt the password before saving in the database

				// if (isset($_POST['user_type'])) {
				// 	$user_type = e($_POST['user_type']);
				// 	$query = "UPDATE users SET username='$username', email='$email', user_type='admin', password='$password' WHERE id=$id";
				// 	mysqli_query($db, $query);
				// 	$_SESSION['success']  = "User Edited Successfully created!!";
				// 	header('location: view_users.php');
				// }
				// else{
					$query = "UPDATE hod SET hod_name='$hodname' WHERE hod_id=$id";
					mysqli_query($db, $query);

					// // get id of the created user
					$logged_in_user_id = mysqli_insert_id($db);

					//$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
					if($hoddept=='PRIN' or $hoddept=='VPRIN'){
						$_SESSION['message'] = "Name of $hoddeptfull Updated Successfully";
					}else{
						$_SESSION['message'] = "Name of HOD of $hoddeptfull Department Updated Successfully";
					}
					header('location: view_faculty.php');				
				//}

			}
		
	}



	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	// LOGIN USER
	function login(){
		global $db, $email, $errors;

		// grap form values
		$email = e($_POST['email']);
		$password = e($_POST['password']);

		$pass= e($_POST['password']);

		// make sure form is filled properly
		if (empty($email)) {
			array_push($errors, "Email ID is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);
			

			if (mysqli_num_rows($results) == 1) { // user found

				$_SESSION['email']= $email;
				$_SESSION['pass']=$pass;

				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				$_SESSION['admin_username']=$logged_in_user['user_name'];
				if ($logged_in_user['user_type'] == 'admin') {

					$_SESSION['id'] = $logged_in_user['farmer_id'];
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: admin.php');		  
				}else{
					$_SESSION['id'] = $logged_in_user['farmer_id'];
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location: dashboard.php');
				}
			}else {
				array_push($errors, "Wrong Email / Password combination");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}

	// escape string
	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

	function newEvent(){
		global $db, $errors;
		
		$eventName = e($_POST['eventName']);
		$eventDesc = e($_POST['eventDesc']);
		$eventFees = e($_POST['eventFees']);
		$eventDate = e($_POST['eventDate']);
		$eventDateEnd = e($_POST['eventDateEnd']);
		$eventTime = e($_POST['eventTime']);
		$eventLocation = e($_POST['eventLocation']);
		$eventIncharge = e($_POST['eventIncharge']);
		$eventCoord = e($_POST['eventCoord']);
		$eventCoordDesg = e($_POST['eventCoordDesg']);
		if (isset($_POST['eventDepartment'])){
			$eventDepartment= e($_POST['eventDepartment']);
		}

		if (empty($eventName)) { 
			array_push($errors, "Event name is required"); 
		}

		if (empty($eventDesc)) { 
			array_push($errors, "Event description is required"); 
		}

		if (empty(pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME))) { 
			array_push($errors, "Image is required"); 
		}

		if (empty(pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME))) { 
			array_push($errors, "Image is required"); 
		}

		if (empty($eventFees)) { 
			array_push($errors, "Event fees is required"); 
		}

		if (empty($eventDate)) { 
			array_push($errors, "Start Date is required"); 
		}
			else{
				if(!empty($eventDateEnd)){
					if ($eventDate > $eventDateEnd) { 
					array_push($errors, "Start Date cannot be less than End Date"); 
					}
				}
				elseif ($eventDate == $eventDateEnd) { 
					array_push($errors, "Start Date and End Date cannot be equal"); 
				}
			}
		

		if (empty($eventLocation)) { 
			array_push($errors, "Location is required"); 
		}

		if (empty($eventIncharge)) { 
			array_push($errors, "Incharge name is required"); 
		}

		if ($eventCoord === NULL){
			if (!empty($eventCoordDesg)){
				array_push($errors, "Both Co-Ordinator and its Designation has to Filled or Empty");
			}
		}

		if ($eventCoordDesg === NULL){
			if (!empty($eventCoord)){
				array_push($errors, "Both Co-Ordinator and its Designation has to Filled or Empty");
			}
		}

		if (empty($eventDepartment)) { 
			array_push($errors, "Select a department"); 
		}

		

		if (count($errors) == 0) {

			if(empty($eventDateEnd)){

				// For Event Image
				$filename = pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME);
				$extension = pathinfo($_FILES["eventImage"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore= $filename.'_'.time().'.'.$extension;
				
				$eventImage_dir = "img/event_img/";
				$eventImage = $eventImage_dir . $fileNameToStore;
				move_uploaded_file($_FILES['eventImage']['tmp_name'], $eventImage);

				// For Certificate Image
				$filename = pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME);
				$extension = pathinfo($_FILES["backImage"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore= $filename.'_'.time().'.'.$extension;
				
				$backImage_dir = "img/event_bg/";
				$backImage = $backImage_dir . $fileNameToStore;
				move_uploaded_file($_FILES['backImage']['tmp_name'], $backImage);
				
				$query = "INSERT INTO event (event_name, event_desc, event_img, event_bg, event_fee, event_date, event_date_end, event_time, event_location, event_inchg, event_coord, event_coord_desg, event_dept ) 
										VALUES('$eventName', '$eventDesc', '$eventImage', '$backImage', '$eventFees', '$eventDate', NULL, '$eventTime', '$eventLocation', '$eventIncharge', '$eventCoord', '$eventCoordDesg', '$eventDepartment')";
				mysqli_query($db, $query);

				$last_id = $db->insert_id;
				$accr = "NAAC Accredited Institute with 'A' Grade
				NBA Accredited 3 Programs (Computer Engineering, Electronics & Telecommunication Engineering and Electronics Engineering)
				Permanently Affiliated to University of Mumbai";
				$sql = "INSERT INTO certificate (event_id, certi_lheader_img, certi_rheader_img, clgname_header, clgaccred_header, certi_title, certi_bg1, certi_bg2, certi_bg3, event_inchg_desg, coord_footer, event_inchg_footer, hod_footer, vprin_footer, bgimg_trans)
										Values ('$last_id', 'img/event_bg/svv_(2)_1587733693_1587735681.png', 'img/event_bg/hqdefault_1587733526_1587735681.jpg', 'K. J. Somaiya Institute of Engineering and Information Technology, Sion, Mumbai', '$accr', 'Certificate', 'This is to certify that', 'organized by department of', 'under incharge of', 'Event Incharge', '1', '1', '1', '0.5')";
				mysqli_query($db, $sql);
					$_SESSION['message'] = "New event added";
					header('location: view_events.php');
			}

			else{
				
				// For Event Image
				$filename = pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME);
				$extension = pathinfo($_FILES["eventImage"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore= $filename.'_'.time().'.'.$extension;
				
				$eventImage_dir = "img/event_img/";
				$eventImage = $eventImage_dir . $fileNameToStore;
				move_uploaded_file($_FILES['eventImage']['tmp_name'], $eventImage);

				// For Certificate Image
				$filename = pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME);
				$extension = pathinfo($_FILES["backImage"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore= $filename.'_'.time().'.'.$extension;
				
				$backImage_dir = "img/event_bg/";
				$backImage = $backImage_dir . $fileNameToStore;
				move_uploaded_file($_FILES['backImage']['tmp_name'], $backImage);
				
				$query = "INSERT INTO event (event_name, event_desc, event_img, event_bg, event_fee, event_date, event_date_end, event_time, event_location, event_inchg, event_coord, event_coord_desg, event_dept ) 
										VALUES('$eventName', '$eventDesc', '$eventImage', '$backImage', '$eventFees', '$eventDate', '$eventDateEnd', '$eventTime', '$eventLocation', '$eventIncharge', '$eventCoord', '$eventCoordDesg', '$eventDepartment')";
				mysqli_query($db, $query);

				$last_id = $db->insert_id;
				$accr = "NAAC Accredited Institute with 'A' Grade
				NBA Accredited 3 Programs (Computer Engineering, Electronics & Telecommunication Engineering and Electronics Engineering)
				Permanently Affiliated to University of Mumbai";

				$sql = "INSERT INTO certificate (event_id, certi_lheader_img, certi_rheader_img, clgname_header, clgaccred_header, certi_title, event_inchg_desg, coord_footer, event_inchg_footer, hod_footer, vprin_footer, bgimg_trans)
										Values ('$last_id', 'img/event_bg/svv_(2)_1587733693_1587735681.png', 'img/event_bg/hqdefault_1587733526_1587735681.jpg', 'K. J. Somaiya Institute of Engineering and Information Technology, Sion, Mumbai', '$accr', 'Certificate', 'Event Incharge', '1', '1', '1', '0.5')";
				mysqli_query($db, $sql);
					$_SESSION['message'] = "New event added";
					header('location: view_events.php');
			}

		
		}
		
	}

	function editEvent(){
		global $db, $errors;
		
		$eventName = e($_POST['eventName']);
		$eventDesc = e($_POST['eventDesc']);
		$eventFees = e($_POST['eventFees']);
		$eventDate = e($_POST['eventDate']);
		$eventDateEnd = e($_POST['eventDateEnd']);
		$eventTime = e($_POST['eventTime']);
		$eventLocation = e($_POST['eventLocation']);
		$eventIncharge = e($_POST['eventIncharge']);
		$eventCoord = e($_POST['eventCoord']);
		$eventCoordDesg = e($_POST['eventCoordDesg']);
		if (isset($_POST['eventDepartment'])){
			$eventDepartment= e($_POST['eventDepartment']);
		}
		$id = e($_POST['eventId']);
		// echo($id);

		if (empty($eventName)) { 
			array_push($errors, "EventName is required"); 
		}

		if (empty($eventDesc)) { 
			array_push($errors, "EventDescription is required"); 
		}

		if (empty($eventFees)) { 
			array_push($errors, "EventFees is required"); 
		}

		if (empty($eventDate)) { 
			array_push($errors, "Start Date is required"); 
		}
			else{
				if(!empty($eventDateEnd)){
					if ($eventDate > $eventDateEnd) { 
					array_push($errors, "Start Date cannot be less than End Date"); 
					}
				}
				elseif ($eventDate == $eventDateEnd) { 
					array_push($errors, "Start Date and End Date cannot be equal"); 
				}
			}

		if (empty($eventLocation)) { 
			array_push($errors, "Location is required"); 
		}

		if (empty($eventIncharge)) { 
			array_push($errors, "Incharge is required"); 
		}

		if ($eventCoord == NULL){
			if (!empty($eventCoordDesg)){
				array_push($errors, "Both Co-Ordinator and its Designation has to Filled or Empty");
			}
			
		}

		if ($eventCoordDesg == NULL){
			if (!empty($eventCoord)){
				array_push($errors, "Both Co-Ordinator and its Designation has to Filled or Empty");
			}
		}

		if (empty($eventDepartment)) { 
			array_push($errors, "Department is required"); 
		}

		if (count($errors) == 0) {

			if($eventCoord == NULL && $eventCoordDesg == NULL){
				$query = "UPDATE `certificate` SET coord_footer='0' WHERE event_id=$id";
				mysqli_query($db, $query);
			}

			if(empty($eventDateEnd)){
				
				if(!empty(pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME)) && !empty(pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME))){

					// For Event Image
					$filename = pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["eventImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$eventImage_dir = "img/event_img/";
					$eventImage = $eventImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['eventImage']['tmp_name'], $eventImage);
		
					// For Certificate Image
					$filename = pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["backImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$backImage_dir = "img/event_bg/";
					$backImage = $backImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['backImage']['tmp_name'], $backImage);
		
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_img='$eventImage', event_bg='$backImage',  event_fee='$eventFees', event_date='$eventDate', event_date_end= NULL, event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
					
		
				}
				
				elseif (!empty(pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME))) { 
					// For Event Image
					$filename = pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["eventImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$eventImage_dir = "img/event_img/";
					$eventImage = $eventImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['eventImage']['tmp_name'], $eventImage);
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_img='$eventImage', event_fee='$eventFees', event_date='$eventDate', event_date_end= NULL, event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
				}
				elseif (!empty(pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME))) { 
					// For Certificate Image
					$filename = pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["backImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$backImage_dir = "img/event_bg/";
					$backImage = $backImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['backImage']['tmp_name'], $backImage);
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_bg='$backImage', event_fee='$eventFees', event_date='$eventDate', event_date_end= NULL, event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
				}
				else{
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_fee='$eventFees', event_date='$eventDate', event_date_end= NULL, event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
				}
			}
			
			else{
				
				if(!empty(pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME)) && !empty(pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME))){

					// For Event Image
					$filename = pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["eventImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$eventImage_dir = "img/event_img/";
					$eventImage = $eventImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['eventImage']['tmp_name'], $eventImage);
		
					// For Certificate Image
					$filename = pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["backImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$backImage_dir = "img/event_bg/";
					$backImage = $backImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['backImage']['tmp_name'], $backImage);
		
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_img='$eventImage', event_bg='$backImage',  event_fee='$eventFees', event_date='$eventDate', event_date_end='$eventDateEnd', event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
		
				}
				
				elseif (!empty(pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME))) { 
					// For Event Image
					$filename = pathinfo($_FILES["eventImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["eventImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$eventImage_dir = "img/event_img/";
					$eventImage = $eventImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['eventImage']['tmp_name'], $eventImage);
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_img='$eventImage', event_fee='$eventFees', event_date='$eventDate', event_date_end='$eventDateEnd', event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
				}
				elseif (!empty(pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME))) { 
					// For Certificate Image
					$filename = pathinfo($_FILES["backImage"]["name"], PATHINFO_FILENAME);
					$extension = pathinfo($_FILES["backImage"]["name"], PATHINFO_EXTENSION);
					$fileNameToStore= $filename.'_'.time().'.'.$extension;
					
					$backImage_dir = "img/event_bg/";
					$backImage = $backImage_dir . $fileNameToStore;
					move_uploaded_file($_FILES['backImage']['tmp_name'], $backImage);
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_bg='$backImage', event_fee='$eventFees', event_date='$eventDate', event_date_end='$eventDateEnd', event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
				}
				else{
					$query = "UPDATE `event` SET event_name='$eventName', event_desc='$eventDesc', event_fee='$eventFees', event_date='$eventDate', event_date_end='$eventDateEnd', event_time='$eventTime', event_location='$eventLocation', event_inchg='$eventIncharge', event_coord='$eventCoord', event_coord_desg='$eventCoordDesg', event_dept='$eventDepartment' WHERE event_id=$id";
					mysqli_query($db, $query);
				}
			}

		
		
			$_SESSION['message'] = "Event Updated Successfully";
			header('location: view_events.php');
		}
	}

	function editCerti(){
		global $db, $errors;
		
		$clgName = e($_POST['clgName']);
		$clgAccred = e($_POST['clgAccred']);
		$certiStyle = e($_POST['certiStyle']);
		$trans=e($_POST['bgimg_trans']);
		$eventInchgDesg = e($_POST['eventInchgDesg']);
		$certibg1 = e($_POST['certibg1']);
		$certibg2 = e($_POST['certibg2']);
		$certibg3 = e($_POST['certibg3']);
		
		
		if (isset($_POST['coordFoot'])){
			$coordFoot= e($_POST['coordFoot']=='1' ? 1 : 0);
		}
			if (isset($_POST['coordFoot'])){
				$checked1=array($coordFoot);
			} 
			else{
				$checked1=array('');
			}


		if (isset($_POST['eventInchgFoot'])){
			$eventInchgFoot= e($_POST['eventInchgFoot']=='1' ? 1 : 0);
		}
			if (isset($_POST['eventInchgFoot'])){
				$checked2=array($eventInchgFoot);
			} 
			else{
				$checked2=array('');
			}
		

		if (isset($_POST['hodFoot'])){
			$hodFoot= e($_POST['hodFoot']=='1' ? 1 : 0);
		}
			if (isset($_POST['hodFoot'])){
				$checked3=array($hodFoot);
			} 
			else{
				$checked3=array('');
			}
		
			
		if (isset($_POST['vprinFoot'])){
			$vprinFoot= e($_POST['vprinFoot']=='1' ? 1 : 0);
		}
			if (isset($_POST['vprinFoot'])){
				$checked4=array($vprinFoot);
			} 
			else{
				$checked4=array('');
			}
		

		$id = e($_POST['eventId']);
		// echo($id);
		
		$checked = array_merge($checked1,$checked2,$checked3,$checked4);
		$tom=array_filter($checked);
		$count = count($tom);

		if ($count<2){
			array_push($errors,"Check atleast 2 boxes for signatures in footer");
		}

		if (empty($clgName)) { 
			array_push($errors, "College Name is required"); 
		}

		if (empty($clgAccred)) { 
			array_push($errors, "College Accreditaton is required"); 
		}

		if (empty($certiStyle)) { 
			array_push($errors, "Certificate Heading is required"); 
		}

		if (empty($trans)) { 
			array_push($errors, "Background Image Transparency is required"); 
		}

		if (empty($eventInchgDesg)) { 
			array_push($errors, "Event Incharge Designation is required"); 
		}

		if (count($errors) == 0) {
			if (!empty(pathinfo($_FILES["certi_lheader_img"]["name"], PATHINFO_FILENAME)) && !empty(pathinfo($_FILES["certi_rheader_img"]["name"], PATHINFO_FILENAME))){
				
				$filename1 = pathinfo($_FILES["certi_lheader_img"]["name"], PATHINFO_FILENAME);
				$extension1 = pathinfo($_FILES["certi_lheader_img"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore1= $filename1.'_'.time().'.'.$extension1;
				
				$lheaderImage_dir = "img/event_bg/";
				$lheaderImage = $lheaderImage_dir . $fileNameToStore1;
				move_uploaded_file($_FILES['certi_lheader_img']['tmp_name'], $lheaderImage);


				$filename2 = pathinfo($_FILES["certi_rheader_img"]["name"], PATHINFO_FILENAME);
				$extension2 = pathinfo($_FILES["certi_rheader_img"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore2= $filename2.'_'.time().'.'.$extension2;
				
				$rheaderImage_dir = "img/event_bg/";
				$rheaderImage = $rheaderImage_dir . $fileNameToStore2;
				move_uploaded_file($_FILES['certi_rheader_img']['tmp_name'], $rheaderImage);

				$query = "UPDATE certificate SET clgname_header='$clgName', clgaccred_header='$clgAccred', certi_title='$certiStyle', certi_bg1='$certibg1', certi_bg2='$certibg2', certi_bg3='$certibg3', certi_lheader_img='$lheaderImage', certi_rheader_img='$rheaderImage', bgimg_trans='$trans', event_inchg_desg='$eventInchgDesg', coord_footer='$coordFoot', event_inchg_footer='$eventInchgFoot', hod_footer='$hodFoot', vprin_footer='$vprinFoot'  WHERE certi_id=$id";
				mysqli_query($db, $query);

			}
			elseif (!empty(pathinfo($_FILES["certi_lheader_img"]["name"], PATHINFO_FILENAME))) { 
				// For Event Image
				$filename1 = pathinfo($_FILES["certi_lheader_img"]["name"], PATHINFO_FILENAME);
				$extension1 = pathinfo($_FILES["certi_lheader_img"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore1= $filename1.'_'.time().'.'.$extension1;
				
				$lheaderImage_dir = "img/event_bg/";
				$lheaderImage = $lheaderImage_dir . $fileNameToStore1;
				move_uploaded_file($_FILES['certi_lheader_img']['tmp_name'], $lheaderImage);
				$query = "UPDATE certificate SET clgname_header='$clgName', clgaccred_header='$clgAccred', certi_lheader_img='$lheaderImage', certi_title='$certiStyle', certi_bg1='$certibg1', certi_bg2='$certibg2', certi_bg3='$certibg3', bgimg_trans='$trans', event_inchg_desg='$eventInchgDesg', coord_footer='$coordFoot', event_inchg_footer='$eventInchgFoot', hod_footer='$hodFoot', vprin_footer='$vprinFoot' WHERE certi_id=$id";
				mysqli_query($db, $query);
			}
			elseif (!empty(pathinfo($_FILES["certi_rheader_img"]["name"], PATHINFO_FILENAME))) { 
				// For Certificate Image
				$filename2 = pathinfo($_FILES["certi_rheader_img"]["name"], PATHINFO_FILENAME);
				$extension2 = pathinfo($_FILES["certi_rheader_img"]["name"], PATHINFO_EXTENSION);
				$fileNameToStore2= $filename2.'_'.time().'.'.$extension2;
				
				$rheaderImage_dir = "img/event_bg/";
				$rheaderImage = $rheaderImage_dir . $fileNameToStore2;
				move_uploaded_file($_FILES['certi_rheader_img']['tmp_name'], $rheaderImage);
				$query = "UPDATE certificate SET clgname_header='$clgName', clgaccred_header='$clgAccred', certi_rheader_img='$rheaderImage', certi_title='$certiStyle', certi_bg1='$certibg1', certi_bg2='$certibg2', certi_bg3='$certibg3', bgimg_trans='$trans', event_inchg_desg='$eventInchgDesg', coord_footer='$coordFoot', event_inchg_footer='$eventInchgFoot', hod_footer='$hodFoot', vprin_footer='$vprinFoot' WHERE certi_id=$id";
				mysqli_query($db, $query);
			}
			else{
				$query = "UPDATE certificate SET clgname_header='$clgName', clgaccred_header='$clgAccred', certi_title='$certiStyle', certi_bg1='$certibg1', certi_bg2='$certibg2', certi_bg3='$certibg3', bgimg_trans='$trans', event_inchg_desg='$eventInchgDesg', coord_footer='$coordFoot', event_inchg_footer='$eventInchgFoot', hod_footer='$hodFoot', vprin_footer='$vprinFoot' WHERE certi_id=$id";
				mysqli_query($db, $query);
			}
			$_SESSION['success'] = "Certificate Content Updated Successfully";
			header('location: admin.php');
		}
	}
?>