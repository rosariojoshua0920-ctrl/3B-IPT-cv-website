<?php
session_start();

// Process form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle photo upload
    $photo_path = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = 'uploads/';
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['photo']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            // Generate unique filename
            $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_path = $upload_dir . time() . '_' . uniqid() . '.' . $file_extension;
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
                // Store photo path in session
                $_SESSION['photo_uploaded'] = true;
            } else {
                $photo_path = '';
            }
        }
    }
    
    // Store all personal info in session (NOT in database yet)
    $_SESSION['personal_info'] = [
        'first_name' => trim($_POST['first_name']),
        'last_name' => trim($_POST['last_name']),
        'extension_name' => trim($_POST['extension_name'] ?? ''),
        'phone' => trim($_POST['phone']),
        'email' => trim($_POST['email']),
        'address' => trim($_POST['address']),
        'about' => trim($_POST['about']),
        'photo_path' => $photo_path
    ];
    
    // Redirect to experience page
    header("Location: experience.php");
    exit();
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
    
    <?php if (isset($error)): ?>
        <div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="" enctype="multipart/form-data">
        <h2>Personal Information</h2>
        
        <label class="upload-box">
            <input type="file" name="photo" accept="image/*">
            <div class="upload-content">
                <span class="camera">📷</span>
                <p>Add photo</p>
            </div>
        </label>
        
        <label>First Name:</label><br>
        <input type="text" id="first_name" name="first_name" 
               value="<?php echo isset($_SESSION['personal_info']['first_name']) ? htmlspecialchars($_SESSION['personal_info']['first_name']) : ''; ?>"
               placeholder="ex. Joshua" required><br> 
        
        <label>Last Name</label><br> 
        <input type="text" id="last_name" name="last_name" 
               value="<?php echo isset($_SESSION['personal_info']['last_name']) ? htmlspecialchars($_SESSION['personal_info']['last_name']) : ''; ?>"
               placeholder="ex. Rosario" required><br> 
        
        <label>Extension Name (if applicable):</label>
        <input type="text" id="extension_name" name="extension_name" 
               value="<?php echo isset($_SESSION['personal_info']['extension_name']) ? htmlspecialchars($_SESSION['personal_info']['extension_name']) : ''; ?>"
               placeholder="e.g. Jr., III"><br>  
        
        <h2>Contact Information</h2>
        
        <label>Phone Number:</label><br>
        <input type="tel" id="phone" name="phone" 
               value="<?php echo isset($_SESSION['personal_info']['phone']) ? htmlspecialchars($_SESSION['personal_info']['phone']) : ''; ?>"
               required><br> 
        
        <label>Email:</label><br>
        <input type="email" id="email" name="email" 
               value="<?php echo isset($_SESSION['personal_info']['email']) ? htmlspecialchars($_SESSION['personal_info']['email']) : ''; ?>"
               placeholder="ex@example.com" required><br> 
        
        <label>Address:</label><br> 
        <input type="text" id="address" name="address" 
               value="<?php echo isset($_SESSION['personal_info']['address']) ? htmlspecialchars($_SESSION['personal_info']['address']) : ''; ?>"
               required><br>
        
        <h2>About Me</h2>
        <textarea id="about" name="about" rows="5" cols="40" required><?php echo isset($_SESSION['personal_info']['about']) ? htmlspecialchars($_SESSION['personal_info']['about']) : ''; ?></textarea>
        
        <button type="submit">Next</button>
    </form>
</body>
</html>