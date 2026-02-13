

<?php
session_start();
include "db.php";

$isEdit = isset($_SESSION['personal_id']);
$personal_id = $_SESSION['personal_id'] ?? null;

// Handle file upload
if ($_FILES['photo']['name']) {
    $photoName = $_FILES['photo']['name'];
    $tempName = $_FILES['photo']['tmp_name'];
    $folder = "uploads/" . $photoName;
    move_uploaded_file($tempName, $folder);
    $_SESSION['photo'] = $folder;
} else if ($isEdit) {
    // Use existing photo if not uploading new one
    $result = mysqli_query($conn, "SELECT photo_path FROM personal_info WHERE id = $personal_id");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['photo'] = $row['photo_path'];
}

/* Insert or Update personal info */
if ($isEdit) {
    // Update existing
    $sql = "UPDATE personal_info SET 
    photo_path='{$_SESSION['photo']}',
    first_name='{$_POST['first_name']}',
    last_name='{$_POST['last_name']}',
    extension_name='{$_POST['extension_name']}',
    phone='{$_POST['phone']}',
    email='{$_POST['email']}',
    address='{$_POST['address']}',
    about='{$_POST['about']}'
    WHERE id = $personal_id";
} else {
    // Insert new
    $sql = "INSERT INTO personal_info 
    (photo_path, first_name, last_name, extension_name, phone, email, address, about)
    VALUES 
    ('{$_SESSION['photo']}','{$_POST['first_name']}','{$_POST['last_name']}',
    '{$_POST['extension_name']}','{$_POST['phone']}',
    '{$_POST['email']}','{$_POST['address']}','{$_POST['about']}')";
}

if (!mysqli_query($conn, $sql)) {
    die("Error: " . mysqli_error($conn));
}

/* Get/Set personal ID */
if (!$isEdit) {
    $personal_id = mysqli_insert_id($conn);
    $_SESSION['personal_id'] = $personal_id;
}

/* Save to session */
$_SESSION['first_name'] = $_POST['first_name'];
$_SESSION['last_name'] = $_POST['last_name'];
$_SESSION['extension_name'] = $_POST['extension_name'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['address'] = $_POST['address'];
$_SESSION['about'] = $_POST['about'];

// Fetch existing education and experience if editing
$education_list = array();
$experience_list = array();
$skills_list = array();
$reference_list = array();

if ($isEdit) {
    $edu_result = mysqli_query($conn, "SELECT * FROM education WHERE personal_info_id = $personal_id");
    while ($row = mysqli_fetch_assoc($edu_result)) {
        $education_list[] = $row;
    }
    
    $exp_result = mysqli_query($conn, "SELECT * FROM work_experience WHERE personal_info_id = $personal_id");
    while ($row = mysqli_fetch_assoc($exp_result)) {
        $experience_list[] = $row;
    }
    
    $skill_result = mysqli_query($conn, "SELECT * FROM skills WHERE personal_info_id = $personal_id");
    while ($row = mysqli_fetch_assoc($skill_result)) {
        $skills_list[] = $row['skill_name'];
    }
    
    $ref_result = mysqli_query($conn, "SELECT * FROM reference_list WHERE personal_info_id = $personal_id");
    while ($row = mysqli_fetch_assoc($ref_result)) {
        $reference_list[] = $row['reference_name'];
    }
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
    <title>Experience</title>
    <link rel="stylesheet" href="experience.css?v=<?php echo time(); ?>">
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
                <input type="text" name="company">
            </div>
            <div class="form-group">
                <label>Position:</label>
                <input type="text" name="position">
            </div>
            <div class="form-group">
                <label>Start Year:</label>
                <input type="date" name="work_start_year">
            </div>
            <div class="form-group">
                <label>End Year:</label>
                <input type="date" name="work_end_year">
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
    <script>
        // Set edit mode flag
        const isEdit = <?php echo $isEdit ? 'true' : 'false'; ?>;
        
        // Pre-populate forms if editing
        <?php if ($isEdit && !empty($education_list)): ?>
            <?php foreach ($education_list as $edu): ?>
                educationList.push({
                    degree: '<?php echo htmlspecialchars($edu['degree']); ?>',
                    school: '<?php echo htmlspecialchars($edu['school']); ?>',
                    start_year: '<?php echo $edu['start_year']; ?>',
                    end_year: '<?php echo $edu['end_year']; ?>'
                });
            <?php endforeach; ?>
            displayEducation();
        <?php endif; ?>
        
        <?php if ($isEdit && !empty($experience_list)): ?>
            <?php foreach ($experience_list as $exp): ?>
                experienceList.push({
                    company: '<?php echo htmlspecialchars($exp['company']); ?>',
                    position: '<?php echo htmlspecialchars($exp['position']); ?>',
                    start_year: '<?php echo $exp['start_year']; ?>',
                    end_year: '<?php echo $exp['end_year']; ?>'
                });
            <?php endforeach; ?>
            displayExperience();
        <?php endif; ?>
        
        <?php if ($isEdit && !empty($skills_list)): ?>
            <?php foreach ($skills_list as $skill): ?>
                skillList.push('<?php echo htmlspecialchars($skill); ?>');
            <?php endforeach; ?>
            displaySkills();
        <?php endif; ?>
        
        <?php if ($isEdit && !empty($reference_list)): ?>
            <?php foreach ($reference_list as $ref): ?>
                referenceList.push('<?php echo htmlspecialchars($ref); ?>');
            <?php endforeach; ?>
            displayReferences();
        <?php endif; ?>
    </script>
    
</body>
</html>


