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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Personal Information - CV Generator</title>
    <link rel="stylesheet" href="personal-info.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="page-wrapper">
        <div class="card">
            <h1>Personal Information</h1>

            <form method="POST" action="../cv-form/experience.php" enctype="multipart/form-data">
                <!-- Photo Section -->
                <div class="photo-upload">
                    <div class="photo-preview" id="photoPreview">
                        <?php if ($isEdit && !empty($personal['photo_path'])): ?>
                            <img id="photoImg" src="<?php echo htmlspecialchars($personal['photo_path']); ?>" alt="Profile">
                        <?php else: ?>
                            <span>📷</span>
                        <?php endif; ?>
                    </div>
                    <label for="photoInput" class="upload-btn">Choose Photo</label>
                    <input type="file" id="photoInput" name="photo" accept="image/*">
                </div>

                <hr class="divider">

                <!-- Personal Information Section -->
                <div class="section">
                    <h2>Personal Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" name="first_name" placeholder="E.g. Joshua" value="<?php echo htmlspecialchars($personal['first_name'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" name="last_name" placeholder="E.g. Rosario" value="<?php echo htmlspecialchars($personal['last_name'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="form-grid full">
                        <div class="form-group">
                            <label>Extension Name (if applicable):</label>
                            <input type="text" name="extension_name" placeholder="E.g. Jr., Sr., III" value="<?php echo htmlspecialchars($personal['extension_name'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <!-- Contact Information Section -->
                <div class="section">
                    <h2>Contact Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Phone Number:</label>
                            <input type="tel" name="phone" placeholder="E.g. +63 123 456 7890" value="<?php echo htmlspecialchars($personal['phone'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" placeholder="E.g. name@example.com" value="<?php echo htmlspecialchars($personal['email'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="form-grid full">
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" name="address" placeholder="Street, City, Province" value="<?php echo htmlspecialchars($personal['address'] ?? ''); ?>" required>
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <!-- About Me Section -->
                <div class="section">
                    <h2>About Me</h2>
                    <div class="form-grid full">
                        <div class="form-group">
                            <label>Professional Summary:</label>
                            <textarea name="about" placeholder="Tell us about yourself, your professional goals, and key achievements..." required><?php echo htmlspecialchars($personal['about'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" onclick="window.location.href='../main/main-page.php'">Cancel</button>
                    <button type="submit"><?php echo $isEdit ? 'Update & Next' : 'Next'; ?></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo preview
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    let img = photoPreview.querySelector('img');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'photoImg';
                        img.alt = 'Profile';
                        photoPreview.innerHTML = '';
                        photoPreview.appendChild(img);
                    }
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>