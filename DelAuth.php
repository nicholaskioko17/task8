<?php
require_once "../configs/Dbconn.php";
if (isset($_GET['author_id'])) {
    $authorId = $_GET['author_id'];


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
       
        $stmt = $DBconn->prepare("DELETE FROM author_table WHERE author_id = :authorId");
        $stmt->bindParam(':authorId', $authorId);

        try {
            $stmt->execute();
            echo "Author successfully deleted.";
            exit();
        } catch (PDOException $e) {
            echo "Error deleting author: " . $e->getMessage();
        }
    }
} else {
    echo "Author ID not provided.";
    exit();
}

// Retrieve author details from the database based on the provided author ID
$stmt = $DBconn->prepare("SELECT * FROM authortb WHERE author_id = :authorId");
$stmt->bindParam(':authorId', $authorId);
$stmt->execute();
$author = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the author exists
if (!$author) {
    echo "Author not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Author</title>
</head>
<body>
    <h2>Delete Author</h2>
    <p>Are you sure you want to delete the author with Full Names: <?= $author['full_names']; ?>?</p>
    
    <form method="post" action="">
        <input type="submit" name="delete" value="Delete">
        <a href="viewauthors.php">Cancel</a>
    </form>
</body>
</html>