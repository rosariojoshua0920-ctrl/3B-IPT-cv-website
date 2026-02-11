<!DOCTYPE html>
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
    </div>

</div>

</body>
</html>

<?php
include 'db.php';

// Personal Info
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$ename = $_POST['ename'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$about = $_POST['about'];

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



$conn->close();
?>

