<?php
session_start();
include 'db.php';
include 'user_navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Update SQL query to join Donations with Charity_Organizations to get organization name
$sql = "
    SELECT Donations.id, Donations.amount, Donations.donation_date, Charity_Organizations.name AS organization_name
    FROM Donations
    JOIN Charity_Organizations ON Donations.organization_id = Charity_Organizations.id
    WHERE Donations.user_id = '$user_id'
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Past Donations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Past Donations</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Organization</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['donation_date']; ?></td>
                        <td><?php echo $row['organization_name']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
