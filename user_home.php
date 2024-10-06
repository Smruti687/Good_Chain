<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch charity organizations from database
include 'db.php';
include 'user_navbar.php';
$sql = "SELECT * FROM Charity_Organizations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Charity Organizations</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <a href="donation.php?org_id=<?php echo $row['id']; ?>" class="btn btn-primary">Donate</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
