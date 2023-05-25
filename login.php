<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if both fields are filled
    if (!empty($username) && !empty($password)) {
        // Check credentials
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION["loggedin"] = true;
            // Redirect to admin.php
            header('Location: admin.php?tool=add');
            exit();
        } else {
            $errorMessage = 'Incorrect username or password.';
        }
    } else {
        $errorMessage = 'Both fields are required.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Motor Market</title>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .error {
                color: red;
            }

            .login-box form {
                width: 60%;
            }

            .login-box label {
                display: block;
                margin-bottom: 0px;
                font-size: 1rem;
                text-align: left;
            }

            .login-box input {
                width: 100%;
                border-radius: 5px;
                border: 1px solid #ccc; 
            }

            .login-box input[type="text"],
            .login-box input[type="password"] {
                height: 40px;
            }

            .login-box .required {
                color: red;
            }

            @media screen and (max-width: 700px) {
                .login-box form {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.html">
                <img src="images/logos/logo-black-small-transparent.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Admin Login</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- login -->
        <div class="login-box">
            <h1>Sign In</h1><br>
            <?php if (isset($errorMessage)) { ?>
                <p class="error"><?php echo $errorMessage; ?></p>
            <?php } ?>
            <form method="POST" action="">
                <label for="username">Username: <span class="required">*</span></label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">Password: <span class="required">*</span></label>
                <input type="password" id="password" name="password" required><br><br><br>

                <input class="btn btn-primary" type="submit" value="Login">
            </form>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // Email format validation using regular expression
            var emailInput = document.getElementById('email');
            emailInput.addEventListener('input', function () {
                var email = emailInput.value;
                var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
                if (!emailRegex.test(email)) {
                    emailInput.setCustomValidity('Please enter a valid email address');
                } else {
                    emailInput.setCustomValidity('');
                }
            });
        </script>
    </body>
</html>