<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2Z Auction - Your Premier Auction Platform</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            background-color: #f7f8fc;
            color: #333;
            overflow-x: hidden;
        }
        a {
            text-decoration: none;
            color: inherit;
        }

        /* Header Section */
        header {
            background: linear-gradient(120deg, #6a0dad, #e40bd9);
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header .logo {
            font-size: 28px;
            font-weight: bold;
        }
        header nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        header nav ul li a {
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: opacity 0.3s ease;
        }
        header nav ul li a:hover {
            opacity: 0.7;
        }

        /* Hero Section */
        .hero {
            background: url('landing/landing3.jpg') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .hero button {
            background: #ff6f61;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .hero button:hover {
            background: #e55b4b;
        }

        /* Features Section */
        .features {
            padding: 50px 20px;
            background-color: #fff;
        }
        .features h2 {
            text-align: center;
            font-size: 36px;
            color: #6a0dad;
            margin-bottom: 40px;
        }
        .features .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .feature {
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .feature:hover {
            transform: translateY(-10px);
        }
        .feature img {
            width: 80px;
            margin-bottom: 15px;
        }
        .feature h3 {
            margin-bottom: 10px;
            color: #6c63ff;
        }

        /* How It Works Section */
        .how-it-works {
            background: linear-gradient(120deg, #6a0dad, #e40bd9);
            color: white;
            padding: 50px 20px;
        }
        .how-it-works h2 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 40px;
        }
        .how-it-works .steps {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .step {
            background: white;
            color: #333;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            max-width: 300px;
        }
        .step img {
            width: 80px;
            margin-bottom: 15px;
        }

        /* About Us Section */
        .about-us {
            padding: 50px 20px;
            background-color: #fff;
        }
        .about-us h2 {
            text-align: center;
            font-size: 36px;
            color: #6a0dad;
            margin-bottom: 20px;
        }
        .about-us p {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            font-size: 18px;
            line-height: 1.8;
            color: #555;
        }

        /* Footer Section */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">A2Z Auction</div>
    <nav>
        <ul>
            <li><a href="#features">Features</a></li>
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="#about-us">About Us</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Sign Up</a></li>
        </ul>
    </nav>
</header>

<div class="hero">
    <div class="hero-content">
        <h1>Discover the Future of Auctions</h1>
        <p>Join A2Z Auction and experience a seamless platform to buy, sell, and bid with confidence.</p>
        <button onclick="location.href='register.php'">Get Started</button>
    </div>
</div>

<section class="features" id="features">
    <h2>Why Choose A2Z Auction?</h2>
    <div class="feature-grid">
        <div class="feature">
            <img src="landing/landing6.png" alt="Wide Variety">
            <h3>Wide Variety of Products</h3>
            <p>Discover everything from electronics to rare collectibles.</p>
        </div>
        <div class="feature">
            <img src="landing/landing5.png" alt="Real-Time">
            <h3>Real-Time Bidding</h3>
            <p>Participate in auctions and win amazing deals.</p>
        </div>
        <div class="feature">
            <img src="landing/landing4.png" alt="Secure">
            <h3>Quality Assurance</h3>
            <p>Discover top-quality products from verified sellers.</p>
        </div>
    </div>
</section>

<section class="how-it-works" id="how-it-works">
    <h2>How It Works</h2>
    <div class="steps">
        <div class="step">
            <img src="landing/landing8.png" alt="Sign Up">
            <h3>Step 1</h3>
            <p>Sign up and create your account.</p>
        </div>
        <div class="step">
            <img src="landing/landing9.png" alt="Browse">
            <h3>Step 2</h3>
            <p>Browse and find products you love.</p>
        </div>
        <div class="step">
            <img src="landing/landing10.png" alt="Bid">
            <h3>Step 3</h3>
            <p>Place your bid and win the auction.</p>
        </div>
    </div>
</section>

<section class="about-us" id="about-us">
    <h2>About Us</h2>
    <p>A2Z Auction is revolutionizing the way auctions are conducted online. We are dedicated to creating a dynamic and trustworthy platform where buyers and sellers connect effortlessly. Whether you're searching for rare collectibles, everyday essentials, or an exciting bidding experience, we provide a seamless, user-friendly environment for everyone. With a commitment to innovation, transparency, and security, we empower our users to explore, bid, and thrive in the digital auction space. Join A2Z Auction today and experience the future of online auctions!</p>
</section>

<footer>
    <p>&copy; 2025 A2Z Auction. All rights reserved.</p>
</footer>

</body>
</html>
