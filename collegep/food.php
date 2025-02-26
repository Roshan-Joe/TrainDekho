<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRCTC Elegant Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            color: #2c3e50;
        }

        header {
            background: linear-gradient(135deg, #1a2a6c 0%, #b21f1f 50%, #fdbb2d 100%);
            padding: 20px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            height: 60px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #fdbb2d;
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        .menu-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .menu-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5em;
            text-align: center;
            color: #1a2a6c;
            margin-bottom: 40px;
            position: relative;
        }

        .menu-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #1a2a6c, #b21f1f, #fdbb2d);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            position: relative;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .menu-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5em;
            color: #1a2a6c;
            margin: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #fdbb2d;
        }

        .menu-list {
            padding: 0 20px 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            transform: translateX(10px);
        }

        .menu-item img {
            width: 30px;
            height: 30px;
            margin-right: 15px;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .search-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 40px 20px;
            text-align: center;
            border-radius: 20px;
            margin: 40px auto;
            max-width: 800px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .search-section input {
            padding: 15px 25px;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 16px;
            width: 300px;
            margin: 10px;
            transition: all 0.3s ease;
        }

        .search-section input:focus {
            outline: none;
            border-color: #1a2a6c;
            box-shadow: 0 0 10px rgba(26,42,108,0.1);
        }

        .search-section button {
            background: linear-gradient(135deg, #1a2a6c 0%, #b21f1f 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(26,42,108,0.2);
        }

        .search-section button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26,42,108,0.3);
        }

        footer {
            background: #1a2a6c;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            nav {
                margin-top: 20px;
            }

            .menu-title {
                font-size: 2em;
            }

            .search-section input {
                width: calc(100% - 70px);
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-section">
                <img src="TRAIN MANIA YOU TUBE CHANNEL LOGO.png" alt="IRCTC Logo" class="logo">
                <h1 style="color: white; margin: 0;">TrainDekho Menu</h1>
            </div>
            <nav>
                <a href="rose.html">Home</a>
                <a href="contactus.html">Contact Us</a>
                <a href="HELP.html">Help</a>
            </nav>
        </div>
    </header>

    <section class="menu-section">
        <h2 class="menu-title">Our Exclusive Menu Selection</h2>
        <div class="menu-grid">
            <div class="menu-card">
                <h3>Premium Express Menu</h3>
                <div class="menu-list">
                    <div class="menu-item">
                        <img src="images/beverages.png" alt="Beverages">
                        <span>Gourmet Beverages</span>
                    </div>
                    <div class="menu-item">
                        <img src="images/breakfast.png" alt="Breakfast">
                        <span>Continental Breakfast</span>
                    </div>
                    <div class="menu-item">
                        <img src="images/meal.png" alt="Meal">
                        <span>Signature Meals</span>
                    </div>
                </div>
            </div>

            <div class="menu-card">
                <h3>Luxury Class Dining</h3>
                <div class="menu-list">
                    <div class="menu-item">
                        <img src="images/1ac.png" alt="1AC">
                        <span>First Class A/C Special</span>
                    </div>
                    <div class="menu-item">
                        <img src="images/2ac.png" alt="2AC">
                        <span>Executive Class Dining</span>
                    </div>
                </div>
            </div>

            <div class="menu-card">
                <h3>Signature Specials</h3>
                <div class="menu-list">
                    <div class="menu-item">
                        <img src="images/vande.png" alt="Vande Bharat">
                        <span>Vande Bharat Exclusive</span>
                    </div>
                    <div class="menu-item">
                        <img src="images/tejas.png" alt="Tejas">
                        <span>Tejas Gourmet Selection</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="search-section">
        <h2 style="color: #1a2a6c; font-family: 'Playfair Display', serif;">Find Your Perfect Meal</h2>
        <input type="text" placeholder="Search for dishes...">
        <input type="text" placeholder="Enter Train Number">
        <button onclick="searchPopup()">Search Menu</button>
    </section>

    <footer>
        <p>&copy; 2025 TrainDekho. All Rights Reserved.</p>
    </footer>

    <script>
        function searchPopup() {
            alert("Discovering your culinary journey...\n\nFeatured Items:\n1. Signature Biryani\n2. Gourmet Pizza\n3. Premium Thali\n4. Special Dosa\n5. International Cuisine");
        }
    </script>
</body>
</html>
