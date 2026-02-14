<?php
session_start();
include "../cv-form/db.php";

// Handle delete
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

// Search functionality
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
    <title>My CVs - Student CV Generator</title>
    <link rel="stylesheet" href="view-cv-modern.css">
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-container">
            <a href="../layout-main-page/nav-bar-main.php" class="nav-logo">Student CV Generator</a>
            <div class="nav-links">
                <a href="../layout-main-page/nav-bar-main.php" class="nav-link">Home</a>
                <a href="view-cv.php" class="nav-link active">View CV</a>
            </div>
        </div>
    </nav>

    <div class="page-container">
        <!-- Connection Status -->
        <?php if (mysqli_ping($conn)): ?>
            <div class="connection-status success">
                ✓ Connected successfully
            </div>
        <?php endif; ?>
        
        <!-- Page Header -->
        <div class="page-header">
            <h1>My CVs</h1>
            <p class="page-subtitle">Manage and organize your curriculum vitae</p>
        </div>
        
        <!-- Alert Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                CV deleted successfully
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                Error deleting CV. <?php if (isset($_GET['msg'])) echo htmlspecialchars(urldecode($_GET['msg'])); ?>
            </div>
        <?php endif; ?>
        
        <!-- Stats Bar -->
        <?php if ($total_cvs > 0): ?>
        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_cvs; ?></div>
                <div class="stat-label">Total CVs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo date('M d, Y'); ?></div>
                <div class="stat-label">Today's Date</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $search ? mysqli_num_rows($result) : $total_cvs; ?></div>
                <div class="stat-label"><?php echo $search ? 'Search Results' : 'All Records'; ?></div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Search Section -->
        <div class="search-section">
            <form method="GET" action="view-cv.php" class="search-form">
                <input 
                    type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="🔍 Search by name or email..." 
                    value="<?php echo htmlspecialchars($search); ?>"
                    autocomplete="off"
                >
                <button type="submit" class="btn-search">Search</button>
                <?php if ($search): ?>
                    <a href="view-cv.php" class="btn-clear">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- CVs Table -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-container">
                <table class="cv-table">
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
                        <?php 
                        mysqli_data_seek($result, 0); // Reset pointer
                        while ($row = mysqli_fetch_assoc($result)): 
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
                            <td class="actions">
                                <a href="../cv-form/result.php?id=<?php echo $id; ?>">View</a>
                                <a href="../cv-form/personal-info.php?id=<?php echo $id; ?>">Edit</a>
                                <a href="view-cv.php?delete=1&id=<?php echo $id; ?>" 
                                   onclick="return confirm('⚠️ Delete CV?\n\nThis will permanently remove:\n• Personal Information\n• Education History\n• Work Experience\n• Skills\n• References\n\nThis action cannot be undone!');">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="table-container">
                <div class="empty-state">
                    <div class="empty-state-icon">📄</div>
                    <h3><?php echo $search ? "No CVs Found" : "No CVs Yet"; ?></h3>
                    <p>
                        <?php 
                        if ($search) {
                            echo "No CVs match your search criteria. Try different keywords.";
                        } else {
                            echo "You haven't created any CVs yet. Create your first CV to get started!";
                        }
                        ?>
                    </p>
                    <?php if (!$search): ?>
                        <a href="../cv-form/personal-info.php" class="create-btn">Create Your First CV</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Footer Action -->
        <div class="footer-action">
            <a href="../cv-form/personal-info.php" class="btn-create-new">Create New CV</a>
        </div>
    </div>

    <script>
        // Auto-hide alert messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Search input focus effect
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            searchInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        }
    </script>
</body>
</html>