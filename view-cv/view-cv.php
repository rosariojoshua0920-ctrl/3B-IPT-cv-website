<?php
session_start(); // Start session to manage CV state
require_once '../cv-form/db.php'; // Include database connection
// Handle delete action
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
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
// Handle search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
if ($search) {
    $query = "SELECT * FROM personal_info WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY created_at DESC";
} else {
    $query = "SELECT * FROM personal_info ORDER BY created_at DESC";
}
$result = mysqli_query($conn, $query);
$total_cvs = mysqli_num_rows($result);





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View CVs</title>
    <link rel="stylesheet" href="../view-cv/view-cv.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="card">
            <h1>Curriculum Vitae</h1>
            
            <div class="top-actions">
                <a onclick="history.back()" class="back-link">← Back to Home</a>
                
                <!-- Search Form -->
                <form method="GET" action="/cv_website/view-cv/view-cv.php" class="search-form">
                   <input type="text" name="search" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>
            
            <!-- CVs Table -->
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_cvs > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
                                    <td class="actions">
                                        <div class="action-links">
                                            <a href="../cv-form/result.php?id=<?php echo $row['id']; ?>">View</a>
                                            <a href="../cv-form/personal-info.php?id=<?php echo $row['id']; ?>">Edit</a>
                                            <a href="/cv_website/view-cv/view-cv.php?delete=1&id=<?php echo $row['id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this CV?');">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="no-records">No CVs found. Start by creating a new one!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
            
            <a href="../cv-form/personal-info.php" class="create-new">+ Create New CV</a>
        </div>
    </div>

</body>
</html>
