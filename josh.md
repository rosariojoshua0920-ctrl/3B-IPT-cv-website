<?php
include 'db.php';

// Personal Info
$fname = $_POST['first_name'] ?? '';
$lname = $_POST['last_name'] ?? '';   
$ename = $_POST['extension_name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$about = $_POST['about'] ?? '';

// Education
$degree = $_POST['degree'] ?? '';
$school = $_POST['school'] ?? '';
$school_start_year = $_POST['school_start_year'] ?? '';
$school_end_year = $_POST['school_end_year'] ?? '';

// Experience
$company = $_POST['company'] ?? '';
$position = $_POST['position'] ?? '';
$work_start_year = $_POST['work_start_year'] ?? '';
$work_end_year = $_POST['work_end_year'] ?? '';

// Skills
$skill1 = $_POST['skill1'] ?? '';

// References
$reference = $_POST['reference'] ?? '';

// Photo upload handling
$photo = '';
if(isset($_FILES['photo']) && $_FILES['photo']['name'] != ''){
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    if(!is_dir($target_dir)) mkdir($target_dir);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir.$photo);
}

// Insert personal info only if form was submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql_personal = "INSERT INTO personal_info 
    (first_name, last_name, extension_name, phone, email, address, about, photo) 
    VALUES ('$fname', '$lname', '$ename', '$phone', '$email', '$address', '$about', '$photo')";

    if($conn->query($sql_personal) === TRUE){
        $personal_id = $conn->insert_id;

        // Insert Education
        $sql_edu = "INSERT INTO education (personal_id, degree, school, start_year, end_year) 
                    VALUES ('$personal_id', '$degree', '$school', '$school_start_year', '$school_end_year')";
        $conn->query($sql_edu);
        
        // Insert Experience
        $sql_exp = "INSERT INTO experience (personal_id, company, position, start_year, end_year) 
                    VALUES ('$personal_id', '$company', '$position', '$work_start_year', '$work_end_year')";
        $conn->query($sql_exp);

        // Insert Skills
        $sql_skill = "INSERT INTO skills (personal_id, skill) VALUES ('$personal_id', '$skill1')";
        $conn->query($sql_skill);

        // Insert References
        $sql_ref = "INSERT INTO references (personal_id, reference) VALUES ('$personal_id', '$reference')";
        $conn->query($sql_ref);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Result</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="result.js"></script>
</head>
<body>

<div>
    
    <div>
        
        <!-- Left Column -->
        <div>
            
            <!-- Photo -->
            <div>
                <div>Photo</div>
            </div>

            <!-- Contact Section -->
            <h3>Contact</h3>
            
            <p></p>
            
            <p></p>
            
            <p></p>

            <!-- Skills Section -->
            <h3>Skills</h3>
            
            <ul></ul>

            <!-- References Section -->
            <h3>References</h3>
            
            <p></p>

        </div>

        <!-- Right Column -->
        <div>
            
            <!-- Header -->
            <div>
                <h1></h1>
                <p></p>
            </div>

            <!-- About/Description -->
            <p></p>

            <!-- Education Section -->
            <h3>Education</h3>
            
            <div></div>

            <!-- Experience Section -->
            <h3>Experience</h3>
            
            <div></div>

        </div>

    </div>

    <!-- Download and Print Buttons -->
    <div>
        <button onclick="window.print()">Print</button>
        <button onclick="downloadPDF()">Download</button>
        <button onclick="window.location.href='../layout-main-page/nav-bar-main.php'">Back to Main Page</button>
    </div>

</div>

</body>
</html>

<?php
include 'db.php';

// Personal Info
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];   
$ename = $_POST['extension_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$about = $_POST['about'];



// Education
$degree = $_POST['degree'];
$school = $_POST['school'];
$school_start_year = $_POST['school_start_year'];
$school_end_year = $_POST['school_end_year'];

// Experience
$company = $_POST['company'];
$position = $_POST['position'];
$work_start_year = $_POST['work_start_year'];
$work_end_year = $_POST['work_end_year'];

// Skills
$skill1 = $_POST['skill1'];

// References
$reference = $_POST['reference'];



// Photo upload handling
$photo = '';
if(isset($_FILES['photo']) && $_FILES['photo']['name'] != ''){
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir.$photo);
}

// Insert personal info
$sql_personal = "INSERT INTO personal_info 
(first_name, last_name, extension_name, phone, email, address, about, photo) 
VALUES ('$fname', '$lname', '$ename', '$phone', '$email', '$address', '$about', '$photo')";

if($conn->query($sql_personal) === TRUE){
    $personal_id = $conn->insert_id; // get the last inserted id

    // Insert Education
    $degree = $_POST['degree'];
    $school = $_POST['school'];
    $start_year = $_POST['school_start_year'];
    $end_year = $_POST['school_end_year'];

    $sql_edu = "INSERT INTO education (personal_id, degree, school, start_year, end_year) 
                VALUES ('$personal_id', '$degree', '$school', '$start_year', '$end_year')";
    $conn->query($sql_edu);
    
    // Insert Experience
    $company = $_POST['company'];
    $position = $_POST['position'];
    $work_start_year = $_POST['work_start_year'];
    $work_end_year = $_POST['work_end_year'];
    $sql_exp = "INSERT INTO experience (personal_id, company, position, start_year, end_year) 
                VALUES ('$personal_id', '$company', '$position', '$work_start_year', '$work_end_year')";
    $conn->query($sql_exp);

    // Insert Skills
    $skill1 = $_POST['skill1'];
    $sql_skill = "INSERT INTO skills (personal_id, skill) VALUES ('$personal_id', '$skill1')";
    $conn->query($sql_skill);

    // Insert References
    $reference = $_POST['reference'];
    $sql_ref = "INSERT INTO references (personal_id, reference) VALUES ('$personal_id', '$reference')";
    $conn->query($sql_ref);

    

    echo "CV saved successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>






<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Result</title>
</head>
<body>

<div>
    
    <div>
        
        <!-- Left Column -->
        <div>
            
            <!-- Photo -->
            <div>
                <div>Photo</div>
            </div>

            <!-- Contact Section -->
            <h3>Contact</h3>
            
            <p></p>
            
            <p></p>
            
            <p></p>

            <!-- Skills Section -->
            <h3>Skills</h3>
            
            <ul></ul>

            <!-- References Section -->
            <h3>References</h3>
            
            <p></p>

        </div>

        <!-- Right Column -->
        <div>
            
            <!-- Header -->
            <div>
                <h1></h1>
                <p></p>
            </div>

            <!-- About/Description -->
            <p></p>

            <!-- Education Section -->
            <h3>Education</h3>
            
            <div></div>

            <!-- Experience Section -->
            <h3>Experience</h3>
            
            <div></div>

        </div>

    </div>

    <!-- Download and Print Buttons -->
    <div>
        <button onclick="window.print()">Print</button>
        <button onclick="downloadPDF()">Download</button>
        <button onclick="window.location.href='../layout-main-page/nav-bar-main.php'">Back to Main Page</button>
    </div>

</div>

</body>
</html>

<?php
include 'db.php';

// Personal Info
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];   
$ename = $_POST['extension_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$about = $_POST['about'];



// Education
$degree = $_POST['degree'];
$school = $_POST['school'];
$school_start_year = $_POST['school_start_year'];
$school_end_year = $_POST['school_end_year'];

// Experience
$company = $_POST['company'];
$position = $_POST['position'];
$work_start_year = $_POST['work_start_year'];
$work_end_year = $_POST['work_end_year'];

// Skills
$skill1 = $_POST['skill1'];

// References
$reference = $_POST['reference'];







// Photo upload handling
$photo = '';
if(isset($_FILES['photo']) && $_FILES['photo']['name'] != ''){
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir.$photo);
}

// Insert personal info
$sql_personal = "INSERT INTO personal_info 
(first_name, last_name, extension_name, phone, email, address, about, photo) 
VALUES ('$fname', '$lname', '$ename', '$phone', '$email', '$address', '$about', '$photo')";

if($conn->query($sql_personal) === TRUE){
    $personal_id = $conn->insert_id; // get the last inserted id

    // Insert Education
    $degree = $_POST['degree'];
    $school = $_POST['school'];
    $start_year = $_POST['school_start_year'];
    $end_year = $_POST['school_end_year'];

    $sql_edu = "INSERT INTO education (personal_id, degree, school, start_year, end_year) 
                VALUES ('$personal_id', '$degree', '$school', '$start_year', '$end_year')";
    $conn->query($sql_edu);
    
    // Insert Experience
    $company = $_POST['company'];
    $position = $_POST['position'];
    $work_start_year = $_POST['work_start_year'];
    $work_end_year = $_POST['work_end_year'];
    $sql_exp = "INSERT INTO experience (personal_id, company, position, start_year, end_year) 
                VALUES ('$personal_id', '$company', '$position', '$work_start_year', '$work_end_year')";
    $conn->query($sql_exp);

    // Insert Skills
    $skill1 = $_POST['skill1'];
    $sql_skill = "INSERT INTO skills (personal_id, skill) VALUES ('$personal_id', '$skill1')";
    $conn->query($sql_skill);

    // Insert References
    $reference = $_POST['reference'];
    $sql_ref = "INSERT INTO references (personal_id, reference) VALUES ('$personal_id', '$reference')";
    $conn->query($sql_ref);

    

    echo "CV saved successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
 -->


 <<<<< HEAD
    <h1>CV Generator</h1>
    <nav>
        <button onclick="loadContent('../main/main-page.php')">Main Page</button>
        <button onclick="loadContent('../view-cv/view-cv.php')">View Result</button>
    </nav>
    <div id="content"></div>
=======
    <header class="site-header">
        <div class="brand">CV Generator</div>
        <nav class="site-nav">
            <button class="nav-btn" onclick="loadContent('../main/main-page.php')" aria-label="Main Page">
                <span>Main Page</span>
            </button>
            <button class="nav-btn" onclick="loadContent('../view-cv/view-cv.php')" aria-label="View CV">
                <span>View CV</span>
            </button>
        </nav>
    </header>

    <main id="content" class="content-area">
        <!-- content will be loaded here -->
    </main>
<<<<<<< HEAD

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

<<<<<<< HEAD
            <textarea id="about" name="about" rows="5" cols="40" required><?php echo htmlspecialchars($personal['about'] ?? ''); ?></textarea>
            <button onclick="window.location.href='../layout-main-page/nav-bar-main.php'">Go to HomePage</button>
            <button type="submit"><?php echo $isEdit ? 'Update & Next' : 'Next'; ?></button>
=======
            <textarea id="about" name="about" rows="5" cols="40" required></textarea>
            <button type="submit">Next</button>
>>>>>>> f3123985d4a222d6b64d0d7ae0b2fac87eff5b74
</form>