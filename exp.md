

body {
    width: 100%;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 14px;
    background-color: #1f5c384f;
}

.page-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
    padding: 40px 20px;
}

.card {
    background-color: #ffffff;
    border: 1px solid #d0d0d0;
    border-radius: 6px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    padding: 36px 40px;
    width: 100%;
    max-width: 680px;
}

.divider {
    border: none;
    border-top: 1px solid #e8e8e8;
    margin: 24px 0;
}

/* Section wrapper */
.section {
    margin-bottom: 30px;
}

/* Section headings */
h2 {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 14px;
    color: #111;
}

/* Two-column grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    column-gap: 40px;
    row-gap: 14px;
}

/* Individual field */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

label {
    font-size: 13px;
    color: #333;
}

input[type="text"] {
    width: 100%;
    height: 30px;
    border: 1px solid #c8c8c8;
    border-radius: 0;
    padding: 4px 8px;
    font-size: 13px;
    color: #333;
    background-color: #fff;
    outline: none;
    transition: border-color 0.15s;
}

input[type="text"]:focus {
    border-color: #999;
}

/* Center the add button */
.btn-center {
    display: flex;
    justify-content: center;
    margin-top: 14px;
}

/* Add buttons */
button {
    background-color: #fff;
    color: #333;
    border: 1.5px solid #aaa;
    padding: 5px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border-radius: 0;
    transition: background-color 0.15s, border-color 0.15s;
}

button:hover {
    background-color: #f0f0f0;
    border-color: #888;
}

/* Next button */
button.next {
    background-color: #1a73e8;
    color: #fff;
    border: none;
    padding: 7px 28px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 2px;
}

button.next:hover {
    background-color: #1558b0;
}

.next-btn {
    margin-top: 20px;
}

/* Added entries list */
.entry-list {
    margin-top: 10px;
    padding-left: 4px;
}

.entry-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    padding: 5px 6px;
    border-bottom: 1px solid #eee;
    color: #444;
}

.entry-item .remove-btn {
    background: none;
    border: none;
    color: #c0392b;
    font-size: 16px;
    cursor: pointer;
    padding: 0 4px;
    font-weight: bold;
    line-height: 1;
}

.entry-item .remove-btn:hover {
    color: #922b21;
    background: none;
}

// Helper: get input value by name and clear it
function getAndClear(name) {
    const el = document.querySelector(`input[name="${name}"]`);
    const val = el ? el.value.trim() : '';
    if (el) el.value = '';
    return val;
}

// Helper: append an entry item to a list container
function appendEntry(containerId, text) {
    const list = document.getElementById(containerId);
    if (!list.querySelector('.entry-list')) {
        const ul = document.createElement('div');
        ul.className = 'entry-list';
        list.appendChild(ul);
    }
    const ul = list.querySelector('.entry-list');

    const item = document.createElement('div');
    item.className = 'entry-item';
    item.innerHTML = `<span>${text}</span><button class="remove-btn" title="Remove">&#x2715;</button>`;
    item.querySelector('.remove-btn').addEventListener('click', () => item.remove());
    ul.appendChild(item);
}

// Add Education
function addEducation() {
    const degree    = getAndClear('degree');
    const school    = getAndClear('school');
    const startYear = getAndClear('school_start_year');
    const endYear   = getAndClear('school_end_year');

    if (!school) { alert('Please enter a Degree and School name.'); return; }

    const parts = [];
    if (degree)    parts.push(degree);
    if (school)    parts.push(school);
    if (startYear || endYear) parts.push(`(${startYear || '?'} – ${endYear || 'Present'})`);

    appendEntry('education-list', parts.join(' | '));
}

// Add Work Experience
function addExperience() {
    const company   = getAndClear('company');
    const position  = getAndClear('position');
    const startYear = getAndClear('work_start_year');
    const endYear   = getAndClear('work_end_year');

    if (!company && !position) { alert('Please enter a company or position.'); return; }

    const parts = [];
    if (position) parts.push(position);
    if (company)  parts.push(`at ${company}`);
    if (startYear || endYear) parts.push(`(${startYear || '?'} – ${endYear || 'Present'})`);

    appendEntry('experience-list', parts.join(' '));
}

// Add Skill
function addSkill() {
    const skill = getAndClear('skill');
    if (!skill) { alert('Please enter a skill.'); return; }
    appendEntry('skill-list', skill);
}

// Add Reference
function addReference() {
    const reference = getAndClear('reference');
    if (!reference) { alert('Please enter a reference.'); return; }
    appendEntry('reference-list', reference);
}

// Next / Submit
function submitForm() {
    // Placeholder: collect data and proceed
    alert('Proceeding to next step...');
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience</title>
    <link rel="stylesheet" href="experience.css">
    <link rel="stylesheet" href="experience.js">
</head>
<body>
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
        <button type="button" class="next" onclick="submitForm()">Next</button>
    </div>
        </div>
            </div>

    <script src="experience.js"></script>
</body>
</html>