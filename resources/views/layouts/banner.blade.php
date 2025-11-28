<style>
    :root {
        --primary-color: #2E8B57;
        --secondary-color: #E9F5EE;
        --dark-text: #2E2E2E;
        --light-text: #666;
    }

    .banner-main { max-width: 210mm; margin: auto; }

    .smart-banner {
        display: grid;
        grid-template-columns: 120px auto 220px;
        align-items: center;
        background: linear-gradient(to right, #fff, var(--secondary-color));
        padding: 20px 25px;
        border-radius: 10px;
        border-left: 6px solid var(--primary-color);
        box-shadow: 0 3px 7px rgba(0,0,0,0.08);
    }

    /* Logo Left */
    .banner-logo img {
        width: 85px;
        height: 85px;
        object-fit: contain;
    }

    /* Centered brand */
    .brand-text-center {
        text-align: center;
    }

    .brand-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary-color);
        letter-spacing: 1px;
    }

    .brand-tagline {
        font-size: 13px;
        color: var(--light-text);
    }

    /* Right Information */
    .banner-info {
        text-align: right;
        font-size: 13px;
        color: var(--light-text);
        line-height: 1.5;
    }

    .banner-info strong { color: var(--dark-text); }

    @media (max-width: 700px) {
        .smart-banner { 
            grid-template-columns: 1fr;
            text-align: center;
            gap: 15px;
        }
        .banner-info { text-align: center; }
    }
</style>

<div class="banner-main">
    <header class="smart-banner">

        <!-- Left Logo -->
        <div class="banner-logo">
            <img src="{{ asset('logo.png') }}" alt="Logo">
        </div>

        <!-- Center Title -->
        <div class="brand-text-center">
            <div class="brand-title">Ovijatrik</div>
            <div class="brand-tagline">A Journey in Search of Smiling Faces</div>
        </div>

        <!-- Right Office Info -->
        <div class="banner-info">
            <strong>Ovijatrik Office</strong><br>
            Islambagh, Dinajpur, Bangladesh<br>
            www.ovijatrik.org<br>
            01717-017645<br>
            ovijatrik.dinajpur@gmail.com
        </div>

    </header>
</div>
