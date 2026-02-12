
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience</title>
    <link rel="stylesheet" href="experience.css">
</head>
<body>

 <form>
    <div class="page-wrapper">
        <div class="card">

    <!-- Education dito oo yes -->
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
        <label>Start Year:</label>
        <input type="text" name="school_start_year" placeholder="YYYY">
            </div>

    <div class="form-group">
        <label>End Year:</label>
        <input type="text" name="school_end_year" placeholder="YYYY">
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
                <input type="text" name="work_start_year" placeholder="YYYY">
            </div>
            <div class="form-group">
                <label>End Year:</label>
                <input type="text" name="work_end_year" placeholder="YYYY">
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
        <h2>References</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Reference:</label>
                <input type="text" name="reference">
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


