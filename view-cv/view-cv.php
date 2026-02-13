<?php
session_start();
include "../cv-form/db.php";

// Search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// Delete functionality
if (isset($_GET['delete'])) {
    $personal_id = mysqli_real_escape_string($conn, $_GET['delete']);
    
    // Delete all related data
    mysqli_query($conn, "DELETE FROM education WHERE personal_info_id = $personal_id");
    mysqli_query($conn, "DELETE FROM work_experience WHERE personal_info_id = $personal_id");
    mysqli_query($conn, "DELETE FROM skills WHERE personal_info_id = $personal_id");
    mysqli_query($conn, "DELETE FROM reference_list WHERE personal_info_id = $personal_id");
    mysqli_query($conn, "DELETE FROM personal_info WHERE id = $personal_id");
    
    header("Location: view-cv.php");
    exit();
}

// Fetch CVs
$query = "SELECT * FROM personal_info WHERE 1=1";
if (!empty($search)) {
    $query .= " AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%')";
}
$query .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View CVs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 { color: #333; }
        .search-box form {
            display: flex;
            gap: 10px;
            width: 100%;
            margin: 20px 0;
        }
        .search-box input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-box button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-view { background-color: #28a745; color: white; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>View CVs</h2>
        <p>Search and manage your saved CVs</p>
        
        <div class="search-box">
            <form method="GET">
                <input type="search" name="search" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="view-cv-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-view">View</a>
                                    <a href="../cv-form/personal-info.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this CV?');">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No CVs found. <a href="../cv-form/personal-info.php">Create a new CV</a></p>
        <?php endif; ?>
    </div>
</body>
</html>