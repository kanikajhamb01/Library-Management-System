<?php
    require("functions.php");
    session_start();

    # Fetch admin data from database
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, "lms");
    $name = "";
    $email = "";
    $mobile = "";
    $query = "select * from admins where email = '$_SESSION[email]'";
    $query_run = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($query_run)) {
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
            </div>
            <font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name']; ?></strong></span></font>
            <font style="color: white"><span><strong>Email: <?php echo $_SESSION['email']; ?></strong></font>
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
    <span><marquee>This is library management system. Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <center><h4>Add a new Book</h4><br></center>
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
                    <input type="text" name="book_author" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="book_category">Category ID:</label>
                    <input type="text" name="book_category" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="book_no">Book Number:</label>
                    <input type="text" name="book_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="book_price">Book Price:</label>
                    <input type="text" name="book_price" class="form-control" required>
                </div>
                <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>
</html>

<?php
   if (isset($_POST['add_book'])) {
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, "lms");

    // Validate author ID
    $author_check_query = "SELECT * FROM authors WHERE author_id = '$_POST[book_author]'";
    $author_check_result = mysqli_query($connection, $author_check_query);

    // Validate category ID
    $category_check_query = "SELECT * FROM category WHERE cat_id = '$_POST[book_category]'";
    $category_check_result = mysqli_query($connection, $category_check_query);

    if (mysqli_num_rows($author_check_result) > 0 && mysqli_num_rows($category_check_result) > 0) {
        // Both author and category exist
        $query = "INSERT INTO books VALUES (NULL, '$_POST[book_name]', '$_POST[book_author]', '$_POST[book_category]', '$_POST[book_no]', '$_POST[book_price]')";
        if (mysqli_query($connection, $query)) {
            echo "<script>
                    alert('Book added successfully.');
                    window.location.href = 'admin_dashboard.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to add book. Please try again.');
                  </script>";
        }
    } else {
        // Error messages based on validation results
        if (mysqli_num_rows($author_check_result) == 0) {
            echo "<script>
                    alert('Author ID does not exist. Please add the author details first.');
                  </script>";
        }
        if (mysqli_num_rows($category_check_result) == 0) {
            echo "<script>
                    alert('Category ID does not exist. Please add the category details first.');
                  </script>";
        }
    }
}
?>

