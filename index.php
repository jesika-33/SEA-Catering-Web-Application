<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register – SEA Catering</title>
    <link rel="stylesheet" href="CSS/SEACateringHomePage.css">
    <link rel="stylesheet" href="CSS/SEACateringAuth.css">
</head>
<body>

    <!-- Top nav -->
    <nav>
        <h1>SEA Catering</h1>
        <span class="menu-toggle" onclick="toggleMenu()">☰</span>
        <ul id="navbar" class="menu">
            <li><a href="SEACateringHomePage.html">Home</a></li>
            <li><a href="SEACateringMealPlans.html">Meal Plans</a></li>
            <li><a href="SEACateringSubscription.html">Subscription</a></li>
            <li><a href="SEACateringTestimonials.html">Testimonials</a></li>
            <li><a href="SEACateringContactPage.html">Contact</a></li>
            <li><a href="index.php" class="active">Sign In</a></li>
        </ul>
    </nav>

    
        <header class="header-container">
            <img src="https://placehold.co/1200x300/c0e0c0/333333?text=Secure+Access" alt="Secure access header image">
            <div class="header-description">
                <h1>Account Access</h1>
                <p>Login or Register to manage your meal plans.</p>
            </div>
        </header>
      <main>
        <section class="auth-section">
            <div class="auth-form-toggle">
                <button id="loginTab">Login</button>
                <button id="registerTab" class="active">Register</button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="auth-form" style="display: none;" action="php/login.php" method="post">
                <h2>Login to Your Account</h2>
                <div id="login-error-message" class="error-message"></div>
                <label for="loginEmail">Email:</label>
                <input type="email" id="loginEmail" name="email" required>

                <label for="loginPassword">Password:</label>
                <input type="password" id="loginPassword" name="password" required>


                <button type="submit">Login</button>
            </form>

            <!-- Register Form -->
            <form id="registerForm" class="auth-form" style="display: block;" action="php/register.php" method="post">
                <h2>Create New Account</h2>
                <div id="register-error-message" class="error-message"></div>
                <label for="registerFullName">Full Name:</label>
                <input type="text" id="registerFullName" name="fullName" required>

                <label for="registerEmail">Email:</label>
                <input type="email" id="registerEmail" name="email" required>

                <label for="registerPassword">Password:</label>
                <input type="password" id="registerPassword" name="password" required placeholder="Min 8 chars, incl. upper, lower, number, special">
                <div style="font-size: 0.8em; color: #888; margin-top: -15px; margin-bottom: 10px; text-align: left;">
                    Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.
                </div>

                <button type="submit">Register</button>
            </form>
        </section>
    </main>

    <script>
    function toggleMenu() {
  const menu = document.querySelector('.menu');
  menu.classList.toggle('mobile');
}

  </script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginErrorMessage = document.getElementById('login-error-message');
            const registerErrorMessage = document.getElementById('register-error-message');

            const registerFullNameInput = document.getElementById('registerFullName');
            const registerEmailInput = document.getElementById('registerEmail');
            const registerPasswordInput = document.getElementById('registerPassword');
            const loginEmailInput = document.getElementById('loginEmail');
            const loginPasswordInput = document.getElementById('loginPassword');

            // --- Tab Switching Logic ---
            loginTab.addEventListener('click', () => {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                loginErrorMessage.textContent = '';
                registerErrorMessage.textContent = '';
            });

            registerTab.addEventListener('click', () => {
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerForm.style.display = 'block';
                loginForm.style.display = 'none';
                loginErrorMessage.textContent = '';
                registerErrorMessage.textContent = '';
            });

            // --- Password Validation Function (Client-side) ---
            function validatePassword(password) {
                const minLength = 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasLowercase = /[a-z]/.test(password);
                const hasNumber = /[0-9]/.test(password);
                const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~` ]/.test(password); // Added space

                if (password.length < minLength) {
                    return "Password must be at least 8 characters long.";
                }
                if (!hasUppercase) {
                    return "Password must include at least one uppercase letter.";
                }
                if (!hasLowercase) {
                    return "Password must include at least one lowercase letter.";
                }
                if (!hasNumber) {
                    return "Password must include at least one number.";
                }
                if (!hasSpecialChar) {
                    return "Password must include at least one special character (!@#$%^&*...).";
                }
                return null; // Password is valid
            }

            // --- Register Form Submission (Frontend) ---
            registerForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                registerErrorMessage.textContent = ''; // Clear previous errors

                const fullName = registerFullNameInput.value.trim();
                const email = registerEmailInput.value.trim();
                const password = registerPasswordInput.value;

                if (!fullName || !email || !password) {
                    registerErrorMessage.textContent = 'All fields are required.';
                    return;
                }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    registerErrorMessage.textContent = 'Please enter a valid email address.';
                    return;
                }

                const passwordError = validatePassword(password);
                if (passwordError) {
                    registerErrorMessage.textContent = passwordError;
                    return;
                }

                try {
                    const response = await fetch('php/register.php', { // PHP endpoint for registration
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ fullName, email, password })
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Registration successful! You can now log in.');
                        // Switch to login tab after successful registration
                        loginTab.click();
                        registerForm.reset();
                    } else {
                        registerErrorMessage.textContent = result.message || 'Registration failed.';
                    }
                } catch (error) {
                    console.error('Registration fetch error:', error);
                    registerErrorMessage.textContent = 'An error occurred during registration. Please try again later.';
                }
            });

            // --- Login Form Submission (Frontend) ---
            loginForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                loginErrorMessage.textContent = ''; // Clear previous errors

                const email = loginEmailInput.value.trim();
                const password = loginPasswordInput.value;

                if (!email || !password) {
                    loginErrorMessage.textContent = 'Email and password are required.';
                    return;
                }

                try {
                    const response = await fetch('php/login.php', { // PHP endpoint for login
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ email, password })
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Login successful! Redirecting to User Dashboard...');
                        window.location.href = 'SEACateringUserDashboard.html'; // Redirect on success
                    } else {
                        loginErrorMessage.textContent = result.message || 'Login failed.';
                    }
                } catch (error) {
                    console.error('Login fetch error:', error);
                    loginErrorMessage.textContent = 'An error occurred during login. Please try again later.';
                }
            });

            // --- Check if user is already logged in on page load (via PHP session) ---
            async function checkLoginStatus() {
                try {
                    const response = await fetch('php/session_check.php'); // PHP endpoint to check session
                    const result = await response.json();
                    if (result.loggedIn) {
                        // User is logged in, redirect to dashboard
                        alert("You are already logged in. Redirecting to User Dashboard.");
                        window.location.href = 'SEACateringUserDashboard.html';
                    }
                } catch (error) {
                    console.error('Error checking login status:', error);
                    // Continue without redirection if status check fails
                }
            }
            checkLoginStatus();
        });
    </script>
</body>
</html>
