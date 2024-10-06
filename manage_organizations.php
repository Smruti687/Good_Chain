<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Include DB connection
include 'db.php';

// Add organization
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_organization'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO Charity_Organizations (name, description, image_url) VALUES ('$name', '$description', '$image_url')";
    $conn->query($sql);
}

// Update organization
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_organization'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $sql = "UPDATE Charity_Organizations SET name='$name', description='$description', image_url='$image_url' WHERE id='$id'";
    $conn->query($sql);
}

// Delete organization
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM Charity_Organizations WHERE id='$id'";
    $conn->query($sql);
}

// Fetch organizations from database
$sql = "SELECT * FROM Charity_Organizations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Organizations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Organizations</h2>
        <form method="POST" class="mb-4">
            <h4>Add New Organization</h4>
            <div class="form-group">
                <label for="name">Organization Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image_url">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" required>
            </div>
            <button type="submit" name="add_organization" class="btn btn-primary">Add Organization</button>
        </form>

        <h4>Existing Organizations</h4>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</a>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Organization</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <div class="form-group">
                                        <label for="edit_name">Organization Name</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" value="<?php echo $row['name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_description">Description</label>
                                        <textarea class="form-control" id="edit_description" name="description" required><?php echo $row['description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_image_url">Image URL</label>
                                        <input type="text" class="form-control" id="edit_image_url" name="image_url" value="<?php echo $row['image_url']; ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="update_organization" class="btn btn-primary">Update Organization</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
