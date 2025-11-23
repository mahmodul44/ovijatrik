 
 <style>
     /* --- CSS VARIABLES (Change colors here) --- */
        :root {
            --primary-color: #2E8B57; /* SeaGreen - Good for Charity */
            --secondary-color: #f4f9f6;
            --text-dark: #333333;
            --text-light: #666666;
            --border-color: #dddddd;
        }

        /* --- GLOBAL RESET --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9e9e9; /* Grey background for screen only */
            padding: 40px 20px;
            color: var(--text-dark);
        }

        /* --- THE PAGE CONTAINER (A4 Style) --- */
        .banner-main {
            background: white;
            width: 100%;
            max-width: 210mm; /* A4 Width */
            min-height: 20mm; /* A4 Height */
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); /* Paper shadow effect */
            position: relative;
        }

        /* --- SMART BANNER DESIGN --- */
        .smart-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        /* Logo Section */
        .banner-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-placeholder {
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 24px;
            border-radius: 8px;
        }

        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.2;
        }

        .company-tagline {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
        }

        /* Address Section */
        .banner-details {
            text-align: right;
            font-size: 13px;
            color: var(--text-light);
            line-height: 1.6;
        }

        .banner-details strong {
            color: var(--text-dark);
        }

        /* --- UI BUTTONS (Hidden when printing) --- */
        .actions {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn {
            background-color: var(--text-dark);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover { background-color: black; }

           /* Mobile Adjustment */
        @media (max-width: 600px) {
            .smart-banner {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            .banner-details {
                text-align: center;
            }
        }
 </style>
 
 <!-- Control Buttons -->
    {{-- <div class="actions">
        <button class="btn" onclick="window.print()">🖨️ Print / Save as PDF</button>
    </div> --}}

    <!-- The Report Sheet -->
    <div class="banner-main">
        
        <!-- 1. SMART BANNER START -->
        <header class="smart-banner">
            <div class="banner-logo">
                <!-- Replace this div with <img src="logo.png"> -->
                <div class="logo-placeholder">
                    ♥
                </div>
                <div>
                    <div class="company-name">Hope Foundation</div>
                    <div class="company-tagline">Empowering Lives, Together.</div>
                </div>
            </div>

            <div class="banner-details">
                <strong>Hope Foundation Office</strong><br>
                123 Charity Lane, Green District<br>
                New York, NY 10012<br>
                <span style="color: var(--primary-color)">www.hopefoundation.org</span><br>
                +1 (555) 123-4567
            </div>
        </header>
        <!-- SMART BANNER END -->
    </div>