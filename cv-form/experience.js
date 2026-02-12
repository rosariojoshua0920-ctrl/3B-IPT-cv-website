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

        function validateAndNext() {
            // Get all inputs/textareas in the current content
            const requiredFields = document.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red';
                    field.style.borderWidth = '2px';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                alert('Please fill in all required fields');
                return;
            }
            
            // Save form data and move to next
            document.querySelector('form').submit();
        }