let currentPage = 1;
let photoData = null;
let educationCount = 0;
let experienceCount = 0;

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Photo upload
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoData = e.target.result;
                const preview = document.getElementById('photoPreview');
                preview.src = photoData;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Photo circle click
    document.getElementById('photoCircle').addEventListener('click', function() {
        document.getElementById('photoInput').click();
    });

    // Navigation buttons
    document.getElementById('nextBtn1').addEventListener('click', nextPage);
    document.getElementById('prevBtn2').addEventListener('click', prevPage);
    document.getElementById('nextBtn2').addEventListener('click', nextPage);
    document.getElementById('prevBtn3').addEventListener('click', prevPage);
    document.getElementById('downloadBtn').addEventListener('click', downloadCV);
    document.getElementById('printBtn').addEventListener('click', printCV);

    // Add entry buttons
    document.getElementById('addEducationBtn').addEventListener('click', addEducation);
    document.getElementById('addExperienceBtn').addEventListener('click', addExperience);

    // Initialize with one education and experience entry
    addEducation();
    addExperience();
});

function nextPage() {
    if (currentPage === 2) {
        generatePreview();
    }
    
    const current = document.getElementById(`page${currentPage}`);
    const next = document.getElementById(`page${currentPage + 1}`);
    
    if (next) {
        current.classList.remove('active');
        current.classList.add('prev');
        next.classList.add('active');
        next.classList.remove('prev');
        currentPage++;
    }
}

function prevPage() {
    const current = document.getElementById(`page${currentPage}`);
    const prev = document.getElementById(`page${currentPage - 1}`);
    
    if (prev) {
        current.classList.remove('active');
        prev.classList.remove('prev');
        prev.classList.add('active');
        currentPage--;
    }
}

function addEducation() {
    educationCount++;
    const container = document.getElementById('educationEntries');
    const entry = document.createElement('div');
    entry.className = 'entry';
    entry.id = `education-${educationCount}`;
    entry.innerHTML = `
        <button class="remove-btn" data-remove="education-${educationCount}">×</button>
        <div class="form-grid">
            <div class="form-group">
                <label>Degree:</label>
                <input type="text" class="edu-degree" placeholder="e.g., Bachelor of Science">
            </div>
            <div class="form-group">
                <label>School:</label>
                <input type="text" class="edu-school" placeholder="University name">
            </div>
            <div class="form-group">
                <label>Start Year / End Year:</label>
                <input type="text" class="edu-years" placeholder="YYYY-YYYY">
            </div>
        </div>
    `;
    container.appendChild(entry);
    
    // Add event listener to remove button
    entry.querySelector('.remove-btn').addEventListener('click', function() {
        removeEntry(this.getAttribute('data-remove'));
    });
}

function addExperience() {
    experienceCount++;
    const container = document.getElementById('experienceEntries');
    const entry = document.createElement('div');
    entry.className = 'entry';
    entry.id = `experience-${experienceCount}`;
    entry.innerHTML = `
        <button class="remove-btn" data-remove="experience-${experienceCount}">×</button>
        <div class="form-grid">
            <div class="form-group">
                <label>Company:</label>
                <input type="text" class="exp-company" placeholder="Company name">
            </div>
            <div class="form-group">
                <label>Position:</label>
                <input type="text" class="exp-position" placeholder="Job title">
            </div>
            <div class="form-group">
                <label>Start Year / End Year:</label>
                <input type="text" class="exp-years" placeholder="YYYY-YYYY">
            </div>
            <div class="form-group full">
                <label>Description:</label>
                <textarea class="exp-description" placeholder="Describe your responsibilities and achievements"></textarea>
            </div>
        </div>
    `;
    container.appendChild(entry);
    
    // Add event listener to remove button
    entry.querySelector('.remove-btn').addEventListener('click', function() {
        removeEntry(this.getAttribute('data-remove'));
    });
}

function removeEntry(id) {
    document.getElementById(id).remove();
}

function generatePreview() {
    const firstName = document.getElementById('firstName').value || 'First Name';
    const lastName = document.getElementById('lastName').value || 'Last Name';
    const extensionName = document.getElementById('extensionName').value;
    const phone = document.getElementById('phone').value || '+00 000 0000';
    const email = document.getElementById('email').value || 'email@example.com';
    const address = document.getElementById('address').value || 'Address, City';
    const about = document.getElementById('about').value || 'Brief description about yourself.';
    const skillsText = document.getElementById('skills').value;
    const references = document.getElementById('references').value;

    // Parse skills
    const skillsArray = skillsText.split(',').map(s => s.trim()).filter(s => s);
    
    // Get education entries
    let educationHTML = '';
    document.querySelectorAll('#educationEntries .entry').forEach(entry => {
        const degree = entry.querySelector('.edu-degree').value;
        const school = entry.querySelector('.edu-school').value;
        const years = entry.querySelector('.edu-years').value;
        if (degree || school) {
            educationHTML += `
                <div class="cv-entry">
                    <div class="cv-entry-header">
                        <div class="cv-entry-title">${degree || 'Degree'}</div>
                        <div class="cv-entry-subtitle">${school || 'School'}</div>
                        <div class="cv-entry-date">${years || 'YYYY-YYYY'}</div>
                    </div>
                </div>
            `;
        }
    });

    // Get experience entries
    let experienceHTML = '';
    document.querySelectorAll('#experienceEntries .entry').forEach(entry => {
        const company = entry.querySelector('.exp-company').value;
        const position = entry.querySelector('.exp-position').value;
        const years = entry.querySelector('.exp-years').value;
        const description = entry.querySelector('.exp-description').value;
        if (company || position) {
            // Format description as bullet points if it contains line breaks
            let formattedDesc = description;
            if (description && description.includes('\n')) {
                const points = description.split('\n').filter(p => p.trim());
                formattedDesc = '<ul>' + points.map(p => `<li>${p.trim()}</li>`).join('') + '</ul>';
            }
            
            experienceHTML += `
                <div class="cv-entry">
                    <div class="cv-entry-header">
                        <div class="cv-entry-title">${position || 'Position'}</div>
                        <div class="cv-entry-subtitle">${company || 'Company'}</div>
                        <div class="cv-entry-date">${years || 'YYYY-YYYY'}</div>
                    </div>
                    ${description ? `<div class="cv-entry-content">${formattedDesc}</div>` : ''}
                </div>
            `;
        }
    });

    // Generate skills with rating bars
    let skillsHTML = '';
    skillsArray.forEach(skill => {
        const rating = Math.floor(Math.random() * 3) + 3; // Random rating 3-5
        skillsHTML += `
            <div class="skill-item">
                <div class="skill-name">${skill}</div>
                <div class="skill-bar">
                    <div class="skill-fill" style="width: ${rating * 20}%"></div>
                </div>
            </div>
        `;
    });

    const fullName = `${firstName} ${lastName}${extensionName ? ' ' + extensionName : ''}`;
    
    const cvHTML = `
        <div class="cv-layout">
            <div class="cv-sidebar">
                <div class="cv-photo">
                    ${photoData ? `<img src="${photoData}" alt="Profile Photo">` : ''}
                </div>
                
                <div class="cv-name">
                    <h1>${firstName}<br>${lastName.toUpperCase()}</h1>
                    <h2>GRAPHICS DESIGNER</h2>
                </div>

                <div class="cv-section">
                    <div class="cv-section-title">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        <h3>Contact</h3>
                    </div>
                    <div class="cv-contact">
                        <p><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>${address}</p>
                        <p><svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>${phone}</p>
                        <p><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>${email}</p>
                    </div>
                </div>

                ${skillsHTML ? `
                <div class="cv-section">
                    <div class="cv-section-title">
                        <svg viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
                        <h3>Skills</h3>
                    </div>
                    <div class="cv-skills">
                        ${skillsHTML}
                    </div>
                </div>
                ` : ''}
            </div>

            <div class="cv-main">
                ${about ? `
                <div class="cv-main-section">
                    <div class="cv-main-section-title">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <h3>About Me</h3>
                    </div>
                    <div class="cv-entry-content">
                        ${about}
                    </div>
                </div>
                ` : ''}

                ${educationHTML ? `
                <div class="cv-main-section">
                    <div class="cv-main-section-title">
                        <svg viewBox="0 0 24 24"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>
                        <h3>Education</h3>
                    </div>
                    ${educationHTML}
                </div>
                ` : ''}

                ${experienceHTML ? `
                <div class="cv-main-section">
                    <div class="cv-main-section-title">
                        <svg viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/></svg>
                        <h3>Work Experience</h3>
                    </div>
                    ${experienceHTML}
                </div>
                ` : ''}

                ${references ? `
                <div class="cv-main-section">
                    <div class="cv-main-section-title">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        <h3>References</h3>
                    </div>
                    <div class="cv-entry-content">
                        ${references}
                    </div>
                </div>
                ` : ''}
            </div>
        </div>
    `;

    document.getElementById('cvPreview').innerHTML = cvHTML;
}

function downloadCV() {
    const element = document.getElementById('cvPreview');
    const opt = {
        margin: 0,
        filename: 'curriculum-vitae.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Create a loading message
    const downloadBtn = event.target;
    const originalText = downloadBtn.textContent;
    downloadBtn.textContent = 'Generating PDF...';
    downloadBtn.disabled = true;

    // Load html2pdf library dynamically
    if (typeof html2pdf === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
        script.onload = function() {
            html2pdf().set(opt).from(element).save().then(() => {
                downloadBtn.textContent = originalText;
                downloadBtn.disabled = false;
            });
        };
        document.head.appendChild(script);
    } else {
        html2pdf().set(opt).from(element).save().then(() => {
            downloadBtn.textContent = originalText;
            downloadBtn.disabled = false;
        });
    }
}

function printCV() {
    window.print();
}