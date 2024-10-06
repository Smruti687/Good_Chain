<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $organization_id = $_POST['organization_id'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO Donations (user_id, organization_id, amount) VALUES ('$user_id', '$organization_id', '$amount')";
    if ($conn->query($sql) === TRUE) {
        echo "Donation successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Make a Donation</h2>
        <form method="POST" action="">
            <input type="hidden" name="organization_id" value="<?php echo $_GET['org_id']; ?>">
            <div class="form-group">
                <label for="amount">Donation Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <button type="submit" class="btn btn-primary">Donate</button>
        </form>
    </div>
</body>
</html>
