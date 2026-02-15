<?php
session_start();
include "db.php";

// Check if we're coming from personal-info.php with POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'])) {
    
    $isEdit = isset($_SESSION['personal_id']);
    $personal_id = $_SESSION['personal_id'] ?? null;

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['name']) {
        $photoName = $_FILES['photo']['name'];
        $tempName = $_FILES['photo']['tmp_name'];
        $folder = "uploads/" . $photoName;
        move_uploaded_file($tempName, $folder);
        $_SESSION['photo'] = $folder;
    } else if (!isset($_SESSION['photo'])) {
        // Default if no photo
        $_SESSION['photo'] = '';
    }

    /* Escape all POST data for SQL injection prevention */
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $extension_name = mysqli_real_escape_string($conn, $_POST['extension_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $photo_path = mysqli_real_escape_string($conn, $_SESSION['photo']);

    /* Insert or Update personal info */
    if ($isEdit) {
        // Update existing
        $sql = "UPDATE personal_info SET 
        photo_path='$photo_path',
        first_name='$first_name',
        last_name='$last_name',
        extension_name='$extension_name',
        phone='$phone',
        email='$email',
        address='$address',
        about='$about'
        WHERE id = $personal_id";
    } else {
        // Insert new
        $sql = "INSERT INTO personal_info 
        (photo_path, first_name, last_name, extension_name, phone, email, address, about)
        VALUES 
        ('$photo_path','$first_name','$last_name','$extension_name','$phone','$email','$address','$about')";
    }

    if (!mysqli_query($conn, $sql)) {
        die("Error: " . mysqli_error($conn));
    }

    /* Get/Set personal ID */
    if (!$isEdit) {
        $personal_id = mysqli_insert_id($conn);
        if ($personal_id === 0) {
            die("Error: Failed to insert personal info. No ID returned.");
        }
        $_SESSION['personal_id'] = $personal_id;
        $_SESSION['form_submitted'] = true;
    }

    /* Save to session */
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['extension_name'] = $_POST['extension_name'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['about'] = $_POST['about'];
}

// Check if we have a valid session with personal_id
if (!isset($_SESSION['personal_id'])) {
    die("Error: Please start by filling out the personal information form first. <a href='personal-info.php'>Click here</a>");
}

$personal_id = $_SESSION['personal_id'];
$isEdit = true; // We always have an ID at this point

// Fetch existing education and experience if editing
$education_list = array();
$experience_list = array();
$skills_list = array();
$reference_list = array();

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
    $reference_list[] = [
        'name' => $row['reference_name'],
        'contact' => isset($row['reference_contact']) ? $row['reference_contact'] : ''
    ];
}

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

    <form method="POST" action="result.php">
    <div class="page-wrapper">
        <div class="card">

    <!-- Education Section -->
    <div class="section">
        <h2>Education</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Degree:</label>
                <input type="text" name="degree">
            </div>

            <div class="form-group">
                <label>School:</label>
                <input type="text" name="school">
            </div>

            <div class="form-group">
                <label>Start Date:</label>
                <input type="date" name="school_start_year">
            </div>

            <div class="form-group">
                <label>End Date:</label>
                <input type="date" name="school_end_year">
            </div>
        </div>

        <div class="btn-center">
            <button type="button" onclick="addEducation()">Add Education</button>
        </div>
        <div id="education-list"></div>
    </div>

    <!-- Work Experience Section -->
    <div class="section">
        <h2>Work Experiences (Optional)</h2>
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
                <label>Start Date:</label>
                <input type="date" name="work_start_year">
            </div>
            <div class="form-group">
                <label>End Date:</label>
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
                <input type="text" name="skill">
            </div>
        </div>
        <div class="btn-center">
            <button type="button" onclick="addSkill()">Add Skill</button>
        </div>
        <div id="skill-list"></div>
    </div>

    <!-- References Section -->
    <div class="section">
        <h2>References (Optional)</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Reference Name:</label>
                <input type="text" name="reference">
            </div>
            <div class="form-group">
                <label>Contact Info:</label>
                <input type="text" name="reference_contact">
            </div>
        </div>
        <div class="btn-center">
            <button type="button" onclick="addReference()">Add Reference</button>
        </div>
        <div id="reference-list"></div>
    </div>
    <div class="btn-center">
        <button type="button" class="back" onclick="history.back()">← Back</button>
        <button type="button" class="next" onclick="validateAndNext()">Submit</button>
    </div>
        </div>
    </div>
    </form>
    
    <script src="experience.js"></script>
    <script>
        // Set edit mode flag - we always have existing data now
        const isEdit = <?php echo count($education_list) > 0 ? 'true' : 'false'; ?>;
        
        // Pre-populate forms if we have existing data
        <?php if (!empty($education_list)): ?>
            <?php foreach ($education_list as $edu): ?>
                educationList.push({
                    degree: <?php echo json_encode($edu['degree']); ?>,
                    school: <?php echo json_encode($edu['school']); ?>,
                    start_year: <?php echo json_encode($edu['start_year']); ?>,
                    end_year: <?php echo json_encode($edu['end_year']); ?>
                });
            <?php endforeach; ?>
            displayEducation();
        <?php endif; ?>
        
        <?php if (!empty($experience_list)): ?>
            <?php foreach ($experience_list as $exp): ?>
                experienceList.push({
                    company: <?php echo json_encode($exp['company']); ?>,
                    position: <?php echo json_encode($exp['position']); ?>,
                    start_year: <?php echo json_encode($exp['start_year']); ?>,
                    end_year: <?php echo json_encode($exp['end_year']); ?>
                });
            <?php endforeach; ?>
            displayExperience();
        <?php endif; ?>
        
        <?php if (!empty($skills_list)): ?>
            <?php foreach ($skills_list as $skill): ?>
                skillList.push(<?php echo json_encode($skill); ?>);
            <?php endforeach; ?>
            displaySkills();
        <?php endif; ?>
        
        <?php if (!empty($reference_list)): ?>
            <?php foreach ($reference_list as $ref): ?>
                referenceList.push({
                    name: <?php echo json_encode($ref['name']); ?>,
                    contact: <?php echo json_encode($ref['contact']); ?>
                });
            <?php endforeach; ?>
            displayReferences();
        <?php endif; ?>
    </script>
    
</body>
</html>