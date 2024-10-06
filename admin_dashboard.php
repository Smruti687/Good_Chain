<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Include DB connection
include 'db.php';
include 'admin_navbar.php';

// Fetch donation statistics
$sqlDonations = "SELECT COUNT(*) as total_donations, SUM(amount) as total_amount FROM Donations";
$resultDonations = $conn->query($sqlDonations);
$donationsData = $resultDonations->fetch_assoc();

$sqlUsers = "SELECT COUNT(*) as total_users FROM Users";
$resultUsers = $conn->query($sqlUsers);
$usersData = $resultUsers->fetch_assoc();

$sqlOrganizations = "SELECT COUNT(*) as total_organizations FROM Charity_Organizations";
$resultOrganizations = $conn->query($sqlOrganizations);
$organizationsData = $resultOrganizations->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>

        <h3 class="mt-4">Metrics</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Donations</h5>
                        <p class="card-text"><?php echo $donationsData['total_donations']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Amount Donated</h5>
                        <p class="card-text">$<?php echo number_format($donationsData['total_amount'], 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text"><?php echo $usersData['total_users']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Organizations</h5>
                        <p class="card-text"><?php echo $organizationsData['total_organizations']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-4">Donation Trends</h3>
        <canvas id="donationChart" width="400" height="200"></canvas>

        <script>
            const ctx = document.getElementById('donationChart').getContext('2d');
            const donationChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Sample months
                    datasets: [{
                        label: 'Donations ($)',
                        data: [1200, 1900, 3000, 500, 2000, 3000, 4000, 1500, 3000, 2000, 4000, 5000], // Sample data
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>
