<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update user info
    $sql = "UPDATE Users SET name='$name', email='$email' WHERE id='$user_id'";
    $conn->query($sql);
    header("Location: user_profile.php"); // Refresh page
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>User Profile</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</body>
</html>
