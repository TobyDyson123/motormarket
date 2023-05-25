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

        <!-- Checkout -->
        <div class="checkout-box">
            <h1>Order Summary</h1><br>
            <h2>Basket:</h2>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "cars";

                // Check if the car index is provided in the GET request
                if (isset($_GET['carIndex'])) {
                    $carIndex = $_GET['carIndex'];
                    $firstname = $_POST["firstname"];
                    $lastname = $_POST["lastname"];
                    $email = $_POST["email"];
                    $street = $_POST["street"];
                    $postcode = $_POST["postcode"];
                    $cardholder = $_POST["cardholder"];
                    $cardnumber = $_POST["cardnumber"];
                    $expiredate = $_POST["expiredate"];
                    $cvv = $_POST["cvv"];

                    // Create a new connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check the connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Prepare the SQL query
                    $sql = "SELECT make, model, price, dealer, telephone FROM cars WHERE carIndex = ?";

                    // Prepare the statement
                    $stmt = $conn->prepare($sql);

                    // Bind the car index parameter
                    $stmt->bind_param("i", $carIndex);

                    // Execute the statement
                    $stmt->execute();

                    // Bind the result variables
                    $stmt->bind_result($make, $model, $price, $dealer, $telephone);

                    // Fetch the results
                    if ($stmt->fetch()) {
                        // Output the car information
                        echo "<div class='checkout-info-group'>";
                        echo "<strong>$make $model</strong><br>";
                        echo "£$price";
                        echo "</div><br>";
                        echo "<h2>Your Details:</h2>";
                        echo "<div class='checkout-info-group'>";
                        echo "<p><strong>Name:</strong> $firstname $lastname</p>";
                        echo "<p><strong>Email Address:</strong> $email</p>";
                        echo "<p><strong>Address:</strong> $street, $postcode</p>";
                        echo "<p><strong>Cardholder's Name:</strong> $cardholder</p>";
                        echo "<p><strong>Card Number:</strong> $cardnumber</p>";
                        echo "<p><strong>Exp:</strong> $expiredate</p>";
                        echo "<p><strong>CVV:</strong> $cvv</p>";
                        echo "</div><br>";
                        echo "<h2>Dealer Information:</h2>";
                        echo "<div class='checkout-info-group'>";
                        echo "<strong>Dealer:</strong> $dealer<br>";
                        echo "<strong>Telephone:</strong> $telephone<br>";
                        echo "</div><br>";
                    } else {
                        echo "Car not found.";
                    }

                    // Close the statement and connection
                    $stmt->close();
                    $conn->close();
                } else {
                    echo "Car index not provided.";
                }
            ?>

            <form action="purchased.html" method="post" onsubmit="return validateCheckbox()">
                <label for="confirmation-checkbox">
                <input type="checkbox" id="confirmation-checkbox" required>
                    By ticking this box, I confirm that the information provided is correct to the best of my knowledge
                </label>
                <br>
                <button class="btn btn-primary" type="submit">Order Now</button>
            </form>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function validateCheckbox() {
                var checkbox = document.getElementById("confirmation-checkbox");
                if (!checkbox.checked) {
                    alert("Please confirm that the information provided is correct.");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>