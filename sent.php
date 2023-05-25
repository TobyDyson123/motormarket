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

        <!-- Sent -->
        <div class="sent-box">
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Check if the message has been received
                    if (isset($_POST['message']) && !empty($_POST['message'])) {
                        // Display a success message
                        echo "<img src='images/logos/logo-black-icon-transparent.png' alt='logo icon'/>";
                        echo "<p id='company-title'>Motor Market</p>";
                        echo "<h1>Message Sent Successfully</h1>";
                        echo "<p>We have received your message and a staff member will reply to you as soon as possible. We appreciate your feedback!</p><br><br>";
                        echo "<p>While you wait, why not have a look at all the exciting cars we have to offer!</p>";
                        echo "<a href='cars.php' class='btn btn-primary'>Browse Cars</a>";
                    } else {
                        // No message received
                        echo "No message was received.";
                    }
                } else {
                    // Invalid request method
                    echo "Invalid request method.";
                }
            ?>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- JavaScript for filter toggle and close buttons -->
    </body>
</html>