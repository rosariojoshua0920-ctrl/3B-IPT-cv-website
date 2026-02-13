<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information - CV Generator</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-page {
            width: 100%;
            max-width: 600px;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 48px;
        }

        .form-title {
            text-align: center;
            color: #1a1a1a;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .photo-row {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            margin-bottom: 40px;
        }

        .photo-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff9999 0%, #ff7777 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-wrap::before {
            content: '';
            position: absolute;
            width: 32px;
            height: 32px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23cc0000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 13a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            z-index: 1;
        }

        .photo-wrap img[src*="data:image"],
        .photo-wrap img:not([src*="default"]) {
            z-index: 2;
        }

        .photo-wrap img[src*="data:image"] ~ ::before,
        .photo-wrap img:not([src*="default"]) ~ ::before {
            display: none;
        }

        .photo-actions {
            display: flex;
            gap: 12px;
        }

        .upload-btn {
            background: #fff0f0;
            color: #d32f2f;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .upload-btn:hover {
            background: #ffe0e0;
        }

        input[type="file"] {
            display: none;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 32px 0 20px;
        }

        .grid {
            display: grid;
            gap: 16px;
            margin-bottom: 20px;
        }

        .two-cols {
            grid-template-columns: 1fr 1fr;
        }

        .field {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        input, textarea {
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
            background: white;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
        }

        input::placeholder, textarea::placeholder {
            color: #999;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            gap: 16px;
        }

        .btn-outline, .btn-primary {
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-outline {
            background: white;
            color: #666;
            border: 1px solid #e0e0e0;
        }

        .btn-outline:hover {
            background: #f5f5f5;
        }

        .btn-primary {
            background: #d32f2f;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: #b71c1c;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
        }

        @media (max-width: 640px) {
            .form-card {
                padding: 32px 24px;
            }

            .two-cols {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn-outline, .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h2>Curriculum Vitae</h2>
        <form method="POST" action="../cv-form/experience.php" enctype="multipart/form-data">
        <h2>Personal Information</h2>
           <label>Photo:</label><br>
                <input type="file" name="photo" accept="image/*" ><br><br>
            
            <label>First Name:</label><br>
                <input type="text" id="first_name" name="first_name" placeholder="ex.Joshua" required><br> 
            <label>Last Name</label><br> 
                <input type="text" id="last_name" name="last_name" placeholder="ex. Rosario" required><br> 
            <label>Extension Name (if applicable):</label>
                <input type="text" id="extension_name" name="extension_name" placeholder="e.g. Jr., III "><br>  
        <h2>Contact Information</h2>
            <label>Phone Number:</label><br>
                <input type="tel" id="phone" name="phone" required><br> 
            <label>Email:</label><br>
                <input type="email" id="email" name="email" placeholder="ex@example.com" required><br> 
            <label>Address:</label><br> 
                <input type="text" id="address" name="address" required><br>
        <h2>About Me</h2>
            <textarea id="about" name="about" rows="5" cols="40" required></textarea>
            <button type="submit">Next</button>
</form>
</body>
</html>