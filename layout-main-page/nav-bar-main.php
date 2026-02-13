<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Generator</title>
    <link rel="stylesheet" href="nav-bar-main.css">
</head>
<body>
    <header class="site-header">
        <div class="brand">Student CV Generator</div>
        <nav class="site-nav">
            <button class="nav-btn" onclick="loadContent('../main/main-page.php')" aria-label="Home Page">
                <span>Home</span>
            </button>
            <button class="nav-btn" onclick="loadContent('../view-cv/view-cv.php')" aria-label="View CV">
                <span>View CV</span>
            </button>
        </nav>
    </header>

    <main id="content" class="content-area">
        <!-- content will be loaded here -->
    </main>
    <script src="nav-bar-main.js"></script>
</body>
</html>