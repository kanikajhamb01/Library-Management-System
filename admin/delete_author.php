<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");

// Get the author ID from the GET request
$author_id = $_GET['aid'];

// Step 1: Check if the author has any books in the `books` table
$check_books_query = "SELECT * FROM books WHERE author_id = $author_id";
$books_result = mysqli_query($connection, $check_books_query);

if (mysqli_num_rows($books_result) > 0) {
    // Step 2: Check if any of those books are issued
    $check_issued_books_query = "
        SELECT issued_books.*
        FROM issued_books 
        JOIN books ON issued_books.book_no = books.book_no
        WHERE books.author_id = $author_id";
    $issued_books_result = mysqli_query($connection, $check_issued_books_query);

    if (mysqli_num_rows($issued_books_result) > 0) {
        // Books by this author are currently issued
        echo "<script type='text/javascript'>
                alert('Cannot delete author. Books by this author are currently issued.');
                window.location.href = 'manage_author.php';
              </script>";
    } else {
        // Books exist but are not issued
        echo "<script type='text/javascript'>
                alert('Cannot delete author. Books by this author exist in the library. Please delete the books first.');
                window.location.href = 'manage_author.php';
              </script>";
    }
} else {
    // No books by this author, proceed with deletion
    $delete_author_query = "DELETE FROM authors WHERE author_id = $author_id";
    if (mysqli_query($connection, $delete_author_query)) {
        echo "<script type='text/javascript'>
                alert('Author deleted successfully.');
                window.location.href = 'manage_author.php';
              </script>";
    } else {
        // Handle unexpected database error
        echo "<script type='text/javascript'>
                alert('Failed to delete author. Please try again.');
                window.location.href = 'manage_author.php';
              </script>";
    }
}
?>



