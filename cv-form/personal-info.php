
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
            <label class="upload-box">
                <input type="file" accept="image/*" hidden>
            <div class="upload-content">
                <span class="camera">📷</span>
                <p>Add photo</p>
            </div>
            </label>
            <label>First Name:</label><br>
                <input type="text" id="first_name" name="first_name" placeholder="ex.Joshua" required><br> 
            <label>Last Name</label><br> 
                <input type="text" id="last_name" name="last_name" placeholder="ex. Rosario" required><br> 
            <label>Extension Name (if applicable):</label>
                <input type="text" id="extension_name" name="extension_name" placeholder="e.g. Jr., III "><br>  
        <h2>Contact Information</h2>
            <label>Phone Number:</label><br>
                <input type="tel" id="phone" name="phone" required><br> 
            <label>Email:</label><br>
                <input type="email" id="email" name="email" placeholder="ex@example.com" required><br> 
            <label>Address:</label><br> 
                <input type="text" id="address" name="address" required><br>
        <h2>About Me</h2>
            <textarea id="about" name="about" rows="5" cols="40" required></textarea>
            <button type="submit">Next</button>
</form>
</body>
</html>
