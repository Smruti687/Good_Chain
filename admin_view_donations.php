<?php
session_start();
include 'db.php';
include 'admin_navbar.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all donations with the related organization name
$sql = "
    SELECT Donations.id, Donations.amount, Donations.donation_date, Users.name AS donor_name, Charity_Organizations.name AS organization_name
    FROM Donations
    JOIN Users ON Donations.user_id = Users.id
    JOIN Charity_Organizations ON Donations.organization_id = Charity_Organizations.id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View All Donations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>All Donations</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>Donor Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Organization</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['donor_name']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['donation_date']; ?></td>
                        <td><?php echo $row['organization_name']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
