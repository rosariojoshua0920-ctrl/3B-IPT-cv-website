
<!DOCTYPE html>
<html>
<head>
    <title>Personal Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Curriculum Vitae</h2>

<form method="POST" action="result.php" enctype="multipart/form-data">
<h2>Personal Information</h2>
    <label class="upload-box">
        <input type="file" accept="image/*" hidden>
    <div class="upload-content">
        <span class="camera">📷</span>
        <p>Add photo</p>
    </div>
    </label>
    <label>First Name:</label><br>
        <input type="text" name="fname" placeholder="ex.Joshua" required><br> 
    <label>Last Name</label><br> 
        <input type="text" name="lname" placeholder="ex. Rosario" required><br> 
    <label>Extension Name (if applicable):</label>
        <input type="text" name="ename" placeholder="e.g. Jr., III "><br>  
<h2>Contact Information</h2>
    <label>Phone Number:</label><br>
        <input type="tel" name="phone" required><br> 
    <label>Email:</label><br>
        <input type="email" name="email" placeholder="ex@example.com" required><br> 
    <label>Address:</label><br> 
        <input type="text" name="address" required><br>


<h2>About Me</h2>
    <textarea name="about" rows="5" cols="40" required></textarea>
    <!--<button type="submit">Next</button>-->
     <button type="submit">Submit</button>
</form>
</body>
</html>
