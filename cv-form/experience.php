<?php
session_start();
include "db.php";

/* Upload Photo */
$photoName = $_FILES['photo']['name'];
$tempName = $_FILES['photo']['tmp_name'];
$folder = "uploads/" . $photoName;
move_uploaded_file($tempName, $folder);

/* Insert personal info */
$sql = "INSERT INTO personal_info 
(photo_path, first_name, last_name, extension_name, phone, email, address, about)
VALUES 
('$folder','{$_POST['first_name']}','{$_POST['last_name']}',
'{$_POST['extension_name']}','{$_POST['phone']}',
'{$_POST['email']}','{$_POST['address']}','{$_POST['about']}')";

if (!mysqli_query($conn, $sql)) {
    die("Error: " . mysqli_error($conn));
}

/* Get inserted ID */
$personal_id = mysqli_insert_id($conn);

/* Save to session */
$_SESSION['personal_id'] = $personal_id;
$_SESSION['photo'] = $folder;
$_SESSION['first_name'] = $_POST['first_name'];
$_SESSION['last_name'] = $_POST['last_name'];
$_SESSION['extension_name'] = $_POST['extension_name'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['address'] = $_POST['address'];
$_SESSION['about'] = $_POST['about'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience</title>
    <link rel="stylesheet" href="experience.css">
</head>
<body>


 
    <form method="POST" action="../cv-form/result.php" >
    <div class="page-wrapper">
        <div class="card">

    <!-- Education dito oo yes -->
    <div class="section">
        <h2>Education</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Degree:</label>
                <input type="text" name="degree" required>
            </div>

    <div class="form-group">
        <label>School:</label>
        <input type="text" name="school" required>
            </div>

    <div class="form-group">
        <label>Start Year:</label>
        <input type="date" name="school_start_year" required>
            </div>

    <div class="form-group">
        <label>End Year:</label>
        <input type="date" name="school_end_year" required>
            </div>
        </div>

        <div class="btn-center">
            <button type="button" onclick="addEducation()">Add Education</button>
        </div>
        <div id="education-list"></div>
    </div>

    <!-- Work Experience Section -->
    <div class="section">
        <h2>Work Experiences</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Company name:</label>
                <input type="text" name="company" required>
            </div>
            <div class="form-group">
                <label>Position:</label>
                <input type="text" name="position" required>
            </div>
            <div class="form-group">
                <label>Start Year:</label>
                <input type="date" name="work_start_year" required>
            </div>
            <div class="form-group">
                <label>End Year:</label>
                <input type="date" name="work_end_year" required>
            </div>
        </div>
        <div class="btn-center">
            <button type="button" onclick="addExperience()">Add Experience</button>
        </div>
        <div id="experience-list"></div>
    </div>

    <!-- Skills Section -->
    <div class="section">
        <h2>Skills</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Skill:</label>
                <input type="text" name="skill" required>
            </div>
        </div>
        <div class="btn-center">
            <button type="button" onclick="addSkill()">Add Skill</button>
        </div>
        <div id="skill-list"></div>
    </div>

    <!-- References Section -->
    <div class="section">
        <h2>References</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Reference:</label>
                <input type="text" name="reference" required>
            </div>
        </div>
        <div class="btn-center">
            <button type="button" onclick="addReference()">Add Reference</button>
        </div>
        <div id="reference-list"></div>
    </div>

    <div class="btn-center next-btn">
        <button type="button" class="btn btn-primary" onclick="validateAndNext()">Next</button>
    </div>
        </div>
            </div>
    </form>
    <script src="experience.js"></script>
    
</body>
</html>


