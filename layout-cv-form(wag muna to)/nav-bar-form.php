<?php
// Determine current page to set active step
$current_page = basename($_SERVER['PHP_SELF']);
$active_step = 'personal';
if ($current_page === 'experience.php') {
    $active_step = 'experience';
} elseif ($current_page === 'result.php') {
    $active_step = 'template';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <link rel="stylesheet" href="style-nav.css">
</head>
<body>
    
      
            <div>Curriculum Vitae</div>
                    <nav>
                    <button onclick="loadContent('../cv-form/personal-info.php')"  required>
                        <div>👤</div>
                        <p>Personal</p>
                    </button>
                  
                    <button onclick="loadContent('../cv-form/experience.php')" required>
                        <div>💼</div>
                        <p>Experiences</p>
                    </button>
                  
                    <button onclick="loadContent('../cv-form/result.php')" >
                        <div>✓</div>
                        <p>Template</p>
                    </button>
                    </nav>
                    <div id="content"></div>
                    <button onclick="loadNext()">Next</button> 
                    <button onclick="window.location.href='../layout-main-page/nav-bar-main.php'">Back to Main Page</button>
            <script src="nav-bar-form.js"></script>
                
</body>
</html>