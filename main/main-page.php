<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CV Generator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
            min-height: 100vh;
        }

       

        /* Main Content Area */
        .content-area {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* Hero Card */
        .hero-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 60px 48px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .icon-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 32px;
        }

        .doc-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(211, 47, 47, 0.3);
        }

        .doc-icon svg {
            width: 44px;
            height: 44px;
        }

        .hero-card h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .lead {
            font-size: 14px;
            color: #666;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            justify-content: center;
        }

        .btn-primary {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(211, 47, 47, 0.2);
        }

        .btn-primary:hover {
            background: #b71c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(211, 47, 47, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Spinner Animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .site-header {
                padding: 12px 20px;
                flex-direction: column;
                gap: 16px;
            }

            .brand {
                font-size: 18px;
            }

            .site-nav {
                width: 100%;
                justify-content: center;
            }

            .nav-btn {
                flex: 1;
                justify-content: center;
            }

            .hero-card {
                padding: 48px 32px;
            }

            .hero-card h2 {
                font-size: 24px;
            }

            .lead {
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .site-header {
                padding: 12px 16px;
            }

            .site-nav {
                flex-direction: column;
            }

            .nav-btn {
                width: 100%;
            }

            .hero-card {
                padding: 40px 24px;
            }

            .doc-icon {
                width: 70px;
                height: 70px;
            }

            .doc-icon svg {
                width: 38px;
                height: 38px;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    

    <main id="content" class="content-area">
        <section class="hero-card">
            <div class="icon-wrap">
                <div class="doc-icon">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" fill="white"/>
                        <path d="M14 3v6h6" fill="white"/>
                        <rect x="8" y="12" width="8" height="1" rx="0.5" fill="#fff" opacity="0.9"/>
                        <rect x="8" y="15" width="5" height="1" rx="0.5" fill="#fff" opacity="0.9"/>
                    </svg>
                </div>
            </div>
            <h2>Welcome to the CV Generator</h2>
            <p class="lead">Click the button below to start creating your CV.</p>
            <div class="actions">
                <button class="btn-primary" onclick="window.location.href='../cv-form/personal-info.php'">Start creating your CV</button>
            </div>
        </section>
    </main>

    <script>
        // Dynamic content loading function
        function loadContent(url) {
            const contentArea = document.getElementById('content');
            
            // Show loading state
            contentArea.innerHTML = `
                <div style="text-align: center; padding: 60px 20px;">
                    <div style="width: 40px; height: 40px; border: 3px solid #ffe0e0; border-top-color: #d32f2f; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 20px;"></div>
                    <p style="color: #666; font-size: 15px;">Loading...</p>
                </div>
            `;

            // Fetch content
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    contentArea.innerHTML = html;
                    
                    // Execute any scripts in the loaded content
                    const scripts = contentArea.querySelectorAll('script');
                    scripts.forEach(oldScript => {
                        const newScript = document.createElement('script');
                        Array.from(oldScript.attributes).forEach(attr => {
                            newScript.setAttribute(attr.name, attr.value);
                        });
                        newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                        oldScript.parentNode.replaceChild(newScript, oldScript);
                    });
                })
                .catch(error => {
                    console.error('Error loading content:', error);
                    contentArea.innerHTML = `
                        <div style="text-align: center; padding: 60px 20px;">
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#d32f2f" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                            </div>
                            <h3 style="font-size: 18px; color: #1a1a1a; margin-bottom: 8px; font-weight: 600;">Failed to load content</h3>
                            <p style="color: #666; font-size: 14px; margin-bottom: 20px;">Please check the file path and try again.</p>
                            <button onclick="location.reload()" style="background: #d32f2f; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer;">Reload Page</button>
                        </div>
                    `;
                });
        }

        // Initialize - add active state to nav buttons
        document.addEventListener('DOMContentLoaded', function() {
            const navButtons = document.querySelectorAll('.nav-btn');
            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    navButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>