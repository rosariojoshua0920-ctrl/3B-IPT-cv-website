<?php
session_start();
include "../cv-form/db.php";

// Handle delete
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convert to integer for safety
    
    // Delete from all related tables
    mysqli_query($conn, "DELETE FROM education WHERE personal_info_id = $id");
    mysqli_query($conn, "DELETE FROM work_experience WHERE personal_info_id = $id");
    mysqli_query($conn, "DELETE FROM skills WHERE personal_info_id = $id");
    mysqli_query($conn, "DELETE FROM reference_list WHERE personal_info_id = $id");
    $deleted_personal = mysqli_query($conn, "DELETE FROM personal_info WHERE id = $id");
    
    if ($deleted_personal) {
        header("Location: view-cv.php?success=1");
    } else {
        header("Location: view-cv.php?error=1&msg=" . urlencode(mysqli_error($conn)));
    }
    exit;
}

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ($search) {
    $query = "SELECT * FROM personal_info WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY created_at DESC";
} else {
    $query = "SELECT * FROM personal_info ORDER BY created_at DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View CVs</title>
</head>
<body>
    <h1>My CVs</h1>
    
    
    
    <?php if (isset($_GET['error'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 15px;">
            ✗ Error deleting CV. <?php if (isset($_GET['msg'])) echo htmlspecialchars(urldecode($_GET['msg'])); ?>
        </div>
    <?php endif; ?>
    
    <a href="../layout-main-page/nav-bar-main.php">← Back to Home</a>
    <br><br>
    
    <!-- Search Form -->
    <form method="GET" action="view-cv.php">
        <input type="text" name="search" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <?php if ($search): ?>
            <a href="view-cv.php">Clear Search</a>
        <?php endif; ?>
    </form>
    
    <br><br>
    
    <!-- CVs Table -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $first_name = htmlspecialchars($row['first_name']);
                    $last_name = htmlspecialchars($row['last_name']);
                    $email = htmlspecialchars($row['email']);
                    $phone = htmlspecialchars($row['phone']);
                    $created = isset($row['created_at']) ? date('M d, Y', strtotime($row['created_at'])) : 'N/A';
            ?>
            <tr>
                <td><?php echo $first_name; ?></td>
                <td><?php echo $last_name; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $phone; ?></td>
                <td><?php echo $created; ?></td>
                <td>
                    <a href="../cv-form/result.php?id=<?php echo $id; ?>">View</a> |
                    <a href="../cv-form/personal-info.php?id=<?php echo $id; ?>">Edit</a> |
                    <a href="view-cv.php?delete=1&id=<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete this CV?');">Delete</a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo '<tr><td colspan="6" style="text-align: center;">No CVs found. <a href="../cv-form/personal-info.php">Create one now</a></td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <br>
    <a href="../cv-form/personal-info.php">+ Create New CV</a>

</body>
</html>
