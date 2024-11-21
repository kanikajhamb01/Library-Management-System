<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Issue Book</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
  	<script type="text/javascript">
  		function alertMsg(){
  			alert(Book added successfully...);
  			window.location.href = "admin_dashboard.php";
  		}
  	</script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font>
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></font>
		    <ul class="nav navbar-nav navbar-right">
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile </a>
	        	<div class="dropdown-menu">
	        		<a class="dropdown-item" href="">View Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="#">Edit Profile</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="change_password.php">Change Password</a>
	        	</div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="../logout.php">Logout</a>
		      </li>
		    </ul>
		</div>
	</nav><br>
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd">
		<div class="container-fluid">
			
		    <ul class="nav navbar-nav navbar-center">
		      <li class="nav-item">
		        <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
		      </li>
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">Books </a>
	        	<div class="dropdown-menu">
	        		<a class="dropdown-item" href="add_book.php">Add New Book</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="manage_book.php">Manage Books</a>
	        	</div>
		      </li>
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">Category </a>
	        	<div class="dropdown-menu">
	        		<a class="dropdown-item" href="add_cat.php">Add New Category</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="manage_cat.php">Manage Category</a>
	        	</div>
		      </li>
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">Authors</a>
	        	<div class="dropdown-menu">
	        		<a class="dropdown-item" href="add_author.php">Add New Author</a>
	        		<div class="dropdown-divider"></div>
	        		<a class="dropdown-item" href="manage_author.php">Manage Author</a>
	        	</div>
		      </li>
	          <li class="nav-item">
		        <a class="nav-link" href="issue_book.php">Issue Book</a>
		      </li>
		    </ul>
		</div>
	</nav><br>
	<span><marquee>This is library mangement system. Library opens at 8:00 AM and close at 8:00 PM</marquee></span><br><br>
		<center><h4>Issue Book</h4><br></center>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<form action="" method="post">
					<div class="form-group">
						<label for="book_name">Book Name:</label>
						<input type="text" name="book_name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="book_author">Author ID:</label>
						<select class="form-control" name="book_author">
							<option>-Select author-</option>
							<?php  
								$connection = mysqli_connect("localhost","root","");
								$db = mysqli_select_db($connection,"lms");
								$query = "select author_name from authors";
								$query_run = mysqli_query($connection,$query);
								while($row = mysqli_fetch_assoc($query_run)){
									?>
									<option><?php echo $row['author_name'];?></option>
									<?php
								}
							?>
						</select>
						<!--<input type="text" name="book_author" class="form-control" required> -->
					</div>
					<div class="form-group">
						<label for="book_no">Book Number:</label>
						<input type="text" name="book_no" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="student_id">Student ID:</label>
						<input type="text" name="student_id" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="issue_date">Issue Date:</label>
						<input type="text" name="issue_date" class="form-control" value="<?php echo date("yy-m-d");?>" required>
					</div>
					<button type="submit" name="issue_book" class="btn btn-primary">Issue Book</button>
				</form>
			</div>
			<div class="col-md-4"></div>
		</div>
</body>
</html>

<?php
	if (isset($_POST['issue_book'])) {
		$connection = mysqli_connect("localhost", "root", "");
		$db = mysqli_select_db($connection, "lms");

		$book_no = $_POST['book_no'];
		$book_name = $_POST['book_name'];
		$book_author = $_POST['book_author'];
		$student_id = $_POST['student_id'];
		$issue_date = $_POST['issue_date'];

		// Validate student ID
		$student_check_query = "SELECT * FROM users WHERE id = '$student_id'";
		$student_check_result = mysqli_query($connection, $student_check_query);

		if (mysqli_num_rows($student_check_result) > 0) {
			// Validate book number
			$book_check_query = "SELECT * FROM books WHERE book_no = '$book_no'";
			$book_check_result = mysqli_query($connection, $book_check_query);

			if (mysqli_num_rows($book_check_result) > 0) {
				$query = "INSERT INTO issued_books VALUES (NULL, '$book_no', '$book_name', '$book_author', '$student_id', 1, '$issue_date')";
				if (mysqli_query($connection, $query)) {
					echo "<script>alertMsg('Book issued successfully.');</script>";
				} else {
					echo "<script>alert('Error while issuing the book.');</script>";
				}
			} else {
				echo "<script>alert('Invalid Book Number.');</script>";
			}
		} else {
			echo "<script>alert('Invalid Student ID.');</script>";
		}
	}
?>
