<?php
    // Database connection
    $connection = mysqli_connect("localhost", "root", "", "lms");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the book number to delete
    $book_no = $_GET['bn']; // Assuming 'bn' is passed via GET

    // Check if the book is currently issued
    $checkIssuedQuery = "SELECT COUNT(*) AS issued_count FROM issued_books WHERE book_no = $book_no";
    $checkIssuedResult = mysqli_query($connection, $checkIssuedQuery);
    $issuedRow = mysqli_fetch_assoc($checkIssuedResult);

    if ($issuedRow['issued_count'] > 0) {
        // Book is issued, cannot delete
        ?>
        <script type="text/javascript">
            alert("Cannot delete the book as it is currently issued.");
            window.location.href = "manage_book.php";
        </script>
        <?php
    } else {
        // Book is not issued, proceed with deletion
        $query = "DELETE FROM books WHERE book_no = $book_no";
        if (mysqli_query($connection, $query)) {
            // Success message
            ?>
            <script type="text/javascript">
                alert("Book deleted successfully.");
                window.location.href = "manage_book.php";
            </script>
            <?php
        } else {
            // Error message
            ?>
            <script type="text/javascript">
                alert("Error deleting book: <?php echo mysqli_error($connection); ?>");
                window.location.href = "manage_book.php";
            </script>
            <?php
        }
    }

    // Close the database connection
    mysqli_close($connection);
?>
