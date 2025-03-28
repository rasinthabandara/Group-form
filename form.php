<?php
// Session Notifications 
session_start();

// Check if user is already logged in
if (isset($_SESSION['logged_in'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle login errors
$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        /* Animated Gradient Background */
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            overflow-x: hidden;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Floating bubbles animation */
        .bubbles {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: rise 15s infinite ease-in;
        }

        .bubble:nth-child(1) {
            width: 40px;
            height: 40px;
            left: 10%;
            animation-duration: 8s;
        }

        .bubble:nth-child(2) {
            width: 20px;
            height: 20px;
            left: 20%;
            animation-duration: 5s;
            animation-delay: 1s;
        }

        .bubble:nth-child(3) {
            width: 50px;
            height: 50px;
            left: 35%;
            animation-duration: 7s;
            animation-delay: 2s;
        }

        .bubble:nth-child(4) {
            width: 80px;
            height: 80px;
            left: 50%;
            animation-duration: 11s;
            animation-delay: 0s;
        }

        .bubble:nth-child(5) {
            width: 35px;
            height: 35px;
            left: 55%;
            animation-duration: 6s;
            animation-delay: 1s;
        }

        .bubble:nth-child(6) {
            width: 45px;
            height: 45px;
            left: 65%;
            animation-duration: 8s;
            animation-delay: 3s;
        }

        .bubble:nth-child(7) {
            width: 25px;
            height: 25px;
            left: 75%;
            animation-duration: 7s;
            animation-delay: 2s;
        }

        .bubble:nth-child(8) {
            width: 80px;
            height: 80px;
            left: 80%;
            animation-duration: 6s;
            animation-delay: 1s;
        }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-200px);
            }
        }

        /* Responsive Container */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Navbar styles */
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }

        .logo h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }

        /* Responsive Navigation */
        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn svg {
            margin-right: 0.5rem;
            width: 20px;
            height: 20px;
        }

        .btn-login {
            color: #4b5563;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }

        .btn-login:hover {
            background-color: rgba(249, 250, 251, 0.9);
        }

        .btn-signup {
            color: white;
            background-color: #4f46e5;
            border: 1px solid transparent;
        }

        .btn-signup:hover {
            background-color: #4338ca;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: #4b5563;
        }

        .mobile-nav {
            display: none;
            background-color: rgba(255, 255, 255, 0.95);
            border-top: 1px solid rgba(229, 231, 235, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .mobile-nav .btn {
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        /* Form Styles */
        .formbold-main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
        }

        .formbold-form-wrapper {
            width: 100%;
            max-width: 570px;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin: 20px 0;
        }

        .formbold-form-wrapper img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .formbold-input-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 15px;
        }

        .formbold-input-flex > div {
            flex: 1;
            min-width: 250px;
        }

        .formbold-form-input {
            width: 100%;
            padding: 13px 22px;
            border-radius: 5px;
            border: 1px solid rgba(221, 227, 236, 0.5);
            background: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 16px;
            color: #536387;
            outline: none;
            transition: all 0.3s ease;
        }

        .formbold-form-input:focus {
            border-color: #6a64f1;
            box-shadow: 0 0 0 3px rgba(106, 100, 241, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }

        .formbold-form-label h3 {
            color: #07074d;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .formbold-checkbox-wrapper {
            margin-bottom: 20px;
        }

        .formbold-btn {
            width: 100%;
            padding: 14px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .formbold-btn:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        /* Notifications */
        .notification {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .notification.success {
            background-color: rgba(212, 237, 218, 0.9);
            color: #155724;
        }

        .notification.error {
            background-color: rgba(248, 215, 218, 0.9);
            color: #721c24;
        }

        /* Add these new styles for dropdown */
        .login-container {
            position: relative;
            display: inline-block;
        }

        .login-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            min-width: 250px;
            margin-top: 5px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .login-dropdown.show {
            display: block;
        }

        .login-dropdown input {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid rgba(221, 227, 236, 0.5);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
        }

        .login-dropdown .formbold-btn {
            padding: 8px 12px;
            font-size: 14px;
        }

        .mobile-dropdown .login-dropdown {
            position: relative;
            right: auto;
            box-shadow: none;
            padding: 10px 0;
            margin-top: 10px;
            background: transparent;
            backdrop-filter: none;
            border: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-dropdown {
                right: auto;
                left: 0;
            }
            
            .nav-buttons {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .mobile-nav {
                position: absolute;
                left: 0;
                right: 0;
                display: none;
            }

            .mobile-nav.show {
                display: block;
            }

            .formbold-form-wrapper {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .formbold-input-flex {
                flex-direction: column;
                gap: 15px;
            }

            .formbold-input-flex > div {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Bubbles Background -->
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <nav class="navbar">
        <div class="container nav-container">
            <div class="logo">
                <h1>Mr.Rasintha &#x2705</h1>
            </div>

            <!-- Desktop Navigation -->
            <div class="nav-buttons desktop-nav">
                <div class="login-container">
                    <button class="btn btn-login" id="desktopLoginBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Login
                    </button>
                    <div class="login-dropdown" id="desktopLoginDropdown">
                    <?php if (!empty($error)): ?>
        <div class="notification error"><?php echo $error; ?></div>
    <?php endif; ?>
                    <form action="logo_conn.php" method="POST">
        <input type="text" name="userid" placeholder="User ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="formbold-btn">Login</button>
    </form>
                    </div>
                </div>
                <button class="btn btn-signup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Sign Up
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn">
                <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="12" x2="20" y2="12"></line>
                    <line x1="4" y1="6" x2="20" y2="6"></line>
                    <line x1="4" y1="18" x2="20" y2="18"></line>
                </svg>
                <svg class="close-icon hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-nav hidden">
            <div class="container">
                <div class="login-container">
                    <button class="btn btn-login mobile" id="mobileLoginBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Login
                    </button>
                    <div class="login-dropdown mobile-dropdown" id="mobileLoginDropdown">
                        <form action="login.php" method="POST">
                            <input type="text" name="userid" placeholder="User ID" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <button type="submit" class="formbold-btn">Login</button>
                        </form>
                    </div>
                </div>
                <button class="btn btn-signup mobile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Sign Up
                </button>
            </div>
        </div>
    </nav>

    <div class="formbold-main-wrapper">
        <div class="formbold-form-wrapper">
            <img src="wc.jpg" 
                 alt="Registration Banner" draggable="false">

            <!-- Notifications -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="notification success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="notification error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="conn.php" method="POST">
                <div class="formbold-form-title">
                    <h2><center>Register now </center></h2>
                    <p><center>Let's build a team.!</center></p>
                </div>

                <div class="formbold-input-flex">
                    <div>
                        <label for="firstname" class="formbold-form-label">
                            <h3>
                            First name&#x1F4A5
                            </h3>
                        </label>
                        <input
                            type="text"
                            name="firstname"
                            id="firstname"
                            class="formbold-form-input"
                            required
                            oninvalid="this.setCustomValidity('Enter Your First Name Here')"
                            oninput="this.setCustomValidity('')"
                        />
                    </div>
                    <div>
                        <label for="lastname" class="formbold-form-label"><h3>Last name&#x1F4A5
                        </h3></label>
                        <input
                            type="text"
                            name="lastname"
                            id="lastname"
                            class="formbold-form-input"
                            required
                            oninvalid="this.setCustomValidity('Enter your Last Name Here')"
                            oninput="this.setCustomValidity('')"
                        />
                    </div>
                </div>

                <div class="formbold-input-flex">
                    <div>
                        <label for="email" class="formbold-form-label"><h3>Email&#x1F4A5
                        </h3></label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="formbold-form-input"
                            required
                            oninvalid="this.setCustomValidity('Enter Your Gmail Here')"
                            oninput="this.setCustomValidity('')"
                        />
                    </div>
                    <div>
                        <label for="phone" class="formbold-form-label"><h3>Phone number&#x1F4A5
                        </h3></label>
                        <input
                            type="tel"
                            name="phonenumber"
                            id="phone"
                            class="formbold-form-input"
                            required
                            oninvalid="this.setCustomValidity('Enter Your Mobile Number Here')"
                            oninput="this.setCustomValidity('')"
                        />
                    </div>
                </div>

                <div class="formbold-mb-3">
                    <label for="address" class="formbold-form-label">
                        <h3>Street Address&#x1F4A5
                        </h3>
                    </label>
                    <input
                        type="text"
                        name="address"
                        id="address"
                        class="formbold-form-input"
                        required
                        oninvalid="this.setCustomValidity('Enter Home/Office Address Here')"
                        oninput="this.setCustomValidity('')"
                    />
                </div>

                <div class="formbold-mb-3">
                    <label for="address2" class="formbold-form-label">
                        <h3>Street Address Line</h3>
                    </label>
                    <input
                        type="text"
                        name="address2"
                        id="address2"
                        class="formbold-form-input"
                    />
                </div>

                <div class="formbold-input-flex">
                    <div>
                        <label for="state" class="formbold-form-label"><h3>State/Province&#x1F4A5
                        </h3></label>
                        <input
                            type="text"
                            name="state"
                            id="state"
                            class="formbold-form-input"
                            required
                            oninvalid="this.setCustomValidity('Enter Your City Here')"
                            oninput="this.setCustomValidity('')"
                        />
                    </div>
                    <div>
                        <label for="country" class="formbold-form-label"><h3>Country&#x1F4A5
                        </h3></label>
                        <input
                            type="text"
                            name="country"
                            id="country"
                            class="formbold-form-input"
                            required
                            oninvalid="this.setCustomValidity('Enter Your Country Here')"
                            oninput="this.setCustomValidity('')"
                        />
                    </div>
                </div>

                <div class="formbold-input-flex">
                    <div>
                        <label for="post" class="formbold-form-label"><h3>Post/Zip code&#x1F4A5
                        </h3></label>
                        <input
                            type="text"
                            name="post"
                            id="post"
                            class="formbold-form-input"
                            required
                            oninvalid="this.setCustomValidity('Enter Your Post-office code Here')"
                            oninput="this.setCustomValidity('')"
                        />
                    </div>
                    <div>
                        <label for="area" class="formbold-form-label"><h3>Area Code</h3></label>
                        <input
                            type="text"
                            name="area"
                            id="area"
                            class="formbold-form-input"
                        />
                    </div>
                </div>

                <div class="formbold-checkbox-wrapper">
                    <label for="supportCheckbox" class="formbold-checkbox-label">
                        <div class="formbold-relative">
                            <input
                                type="checkbox"
                                id="supportCheckbox"
                                class="formbold-input-checkbox"
                                required
                                oninvalid="this.setCustomValidity('You Not Agree Here')"
                                oninput="this.setCustomValidity('')"
                            />
                            <div class="formbold-checkbox-inner">
                                <span class="formbold-opacity-0">
                                    <svg
                                        width="11"
                                        height="8"
                                        viewBox="0 0 11 8"
                                        fill="none"
                                        class="formbold-stroke-current"
                                    >
                                        <path
                                            d="M10.0915 0.951972L10.0867 0.946075L10.0813 0.940568C9.90076 0.753564 9.61034 0.753146 9.42927 0.939309L4.16201 6.22962L1.58507 3.63469C1.40401 3.44841 1.11351 3.44879 0.932892 3.63584C0.755703 3.81933 0.755703 4.10875 0.932892 4.29224L0.932878 4.29225L0.934851 4.29424L3.58046 6.95832C3.73676 7.11955 3.94983 7.2 4.1473 7.2C4.36196 7.2 4.55963 7.11773 4.71406 6.9584L10.0468 1.60234C10.2436 1.4199 10.2421 1.1339 10.0915 0.951972ZM4.2327 6.30081L4.2317 6.2998C4.23206 6.30015 4.23237 6.30049 4.23269 6.30082L4.2327 6.30081Z"
                                            stroke-width="0.4"
                                        ></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        I agree to the defined&#x1F9D9


                        <a href="#"> terms, conditions, and policies</a>
                    </label>
                </div>

                <button class="formbold-btn">Register Now</button>
            </form>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileNav = document.querySelector('.mobile-nav');
        const menuIcon = document.querySelector('.menu-icon');
        const closeIcon = document.querySelector('.close-icon');

        mobileMenuBtn.addEventListener('click', () => {
            mobileNav.classList.toggle('show');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Login dropdown functionality
        const desktopLoginBtn = document.getElementById('desktopLoginBtn');
        const desktopLoginDropdown = document.getElementById('desktopLoginDropdown');
        const mobileLoginBtn = document.getElementById('mobileLoginBtn');
        const mobileLoginDropdown = document.getElementById('mobileLoginDropdown');

        // Toggle desktop login dropdown
        desktopLoginBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            desktopLoginDropdown.classList.toggle('show');
            mobileLoginDropdown.classList.remove('show');
        });

        // Toggle mobile login dropdown
        mobileLoginBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileLoginDropdown.classList.toggle('show');
            desktopLoginDropdown.classList.remove('show');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!desktopLoginDropdown.contains(e.target) && e.target !== desktopLoginBtn) {
                desktopLoginDropdown.classList.remove('show');
            }
            if (!mobileLoginDropdown.contains(e.target) && e.target !== mobileLoginBtn) {
                mobileLoginDropdown.classList.remove('show');
            }
        });
         // Signup button functionality
         const signupButtons = document.querySelectorAll('.btn-signup');
        
        signupButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Create notification element
                const notification = document.createElement('div');
                notification.className = 'notification error';
                notification.textContent = 'User signup is currently blocked. Please try again later.';
                
                // Insert notification after the navbar
                const navbar = document.querySelector('.navbar');
                navbar.insertAdjacentElement('afterend', notification);
                
                // Remove notification after 5 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });
        });
    </script>
</body>
</html>