
<?php
session_start();
include "db.php";

// Check if editing
$isEdit = isset($_GET['id']);
$personal = array();

if ($isEdit) {
    $personal_id = mysqli_real_escape_string($conn, $_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM personal_info WHERE id = $personal_id");
    $personal = mysqli_fetch_assoc($result);
    
    if (!$personal) {
        die("CV not found.");
    }
    
    $_SESSION['personal_id'] = $personal_id;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Personal Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Curriculum Vitae</h2>
        <form method="POST" action="../cv-form/experience.php" enctype="multipart/form-data">
        <h2>Personal Information</h2>
           <label>Photo:</label><br>
                <input type="file" name="photo" accept="image/*" <?php echo $isEdit ? '' : 'required'; ?>><br><br>
            <?php if ($isEdit && !empty($personal['photo_path'])): ?>
                <small>Current Photo: <img src="<?php echo htmlspecialchars($personal['photo_path']); ?>" style="max-width: 100px;"></small><br><br>
            <?php endif; ?>
            
            <label>First Name:</label><br>
                <input type="text" id="first_name" name="first_name" placeholder="ex.Joshua" value="<?php echo htmlspecialchars($personal['first_name'] ?? ''); ?>" required><br> 
            <label>Last Name</label><br> 
                <input type="text" id="last_name" name="last_name" placeholder="ex. Rosario" value="<?php echo htmlspecialchars($personal['last_name'] ?? ''); ?>" required><br> 
            <label>Extension Name (if applicable):</label>
                <input type="text" id="extension_name" name="extension_name" placeholder="e.g. Jr., III " value="<?php echo htmlspecialchars($personal['extension_name'] ?? ''); ?>"><br>  
        <h2>Contact Information</h2>
            <label>Phone Number:</label><br>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($personal['phone'] ?? ''); ?>" required><br> 
            <label>Email:</label><br>
                <input type="email" id="email" name="email" placeholder="ex@example.com" value="<?php echo htmlspecialchars($personal['email'] ?? ''); ?>" required><br> 
            <label>Address:</label><br> 
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($personal['address'] ?? ''); ?>" required><br>
        <h2>About Me</h2>
            <textarea id="about" name="about" rows="5" cols="40" required><?php echo htmlspecialchars($personal['about'] ?? ''); ?></textarea>
            <button onclick="window.location.href='../layout-main-page/nav-bar-main.php'">Go to HomePage</button>
            <button type="submit"><?php echo $isEdit ? 'Update & Next' : 'Next'; ?></button>
</form>
</body>
</html>
