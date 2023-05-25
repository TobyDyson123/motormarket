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
            .form-group {
                margin-bottom: 30px;
            }
            .example-label {
                font-size: 12px;
                color: gray;
                margin-top: 5px;
            }
            .error-message {
                color: red;
                font-size: 12px;
                margin-top: 5px;
            }
            .form-group label {
                display: block;
                margin-bottom: 0px;
                font-size: 0.8rem;
            }

            .form-group input {
                width: 100%;
                border-radius: 5px;
                border: 1px solid #ccc; 
            }

            .form-group .required {
                color: red;
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

        <!-- Purchase -->
        <div class="purchase-container">
            <div class="purchase-car-info-wrapper">
                <h3>You Have Chosen:</h3>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "cars";

                    // Check if the car index is provided in the GET request
                    if (isset($_GET['carIndex'])) {
                        $carIndex = $_GET['carIndex'];

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
                            echo "<strong>$make $model</strong>";
                            echo "£$price<br><br><br>";
                            echo "<h4>Vehicle Identification Number:</h4>";
                            echo "$carIndex<br><br>";
                            echo "<h4>Dealer Information</h4>";
                            echo "<strong>Dealer:</strong> $dealer<br>";
                            echo "<strong>Telephone:</strong> $telephone<br>";
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
            </div>
            <div class="purchase-customer-info-grid">
                <div class="purchase-customer-details-wrapper">
                <h3>Customer Details</h3>
                <form action="checkout.php?carIndex=<?php echo $carIndex; ?>" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="firstname">Firstname: <span class="required">*</span></label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname: <span class="required">*</span></label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address: <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required>
                        <div class="error-message" id="email-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="street">Street Address: <span class="required">*</span></label>
                        <input type="text" id="street" name="street" required>
                        <div class="example-label">Example: 10 Foobar Road</div>
                        <div class="error-message" id="street-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="postcode">Postcode: <span class="required">*</span></label>
                        <input type="text" id="postcode" name="postcode" required>
                        <div class="example-label">Example: AB1 2CD</div>
                        <div class="error-message" id="postcode-error"></div>
                    </div>
                </div>
                <div class="purchase-payment-details-wrapper">
                    <h3>Payment Details</h3>
                    <div class="form-group">
                        <label for="cardholder">Cardholder's Name: <span class="required">*</span></label>
                        <input type="text" id="cardholder" name="cardholder" required>
                    </div>
                    <div class="form-group">
                        <label for="cardnumber">Card Number: <span class="required">*</span></label>
                        <input type="text" id="cardnumber" name="cardnumber" required>
                        <div class="error-message" id="cardnumber-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="expiredate">Expire Date: <span class="required">*</span></label>
                        <input type="date" id="expiredate" name="expiredate" required>
                        <div class="error-message" id="expiredate-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV: <span class="required">*</span></label>
                        <input type="text" id="cvv" name="cvv" required>
                        <div class="error-message" id="cvv-error"></div>
                    </div>
                    <button class="btn btn-primary" type="submit">Checkout</button>
                </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function validateForm() {
                var email = document.getElementById("email").value;
                var cardNumber = document.getElementById("cardnumber").value;
                var expireDate = document.getElementById("expiredate").value;
                var postcode = document.getElementById("postcode").value;
                var street = document.getElementById("street").value;
                var cvv = document.getElementById("cvv").value;

                // Email validation using regular expression
                var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
                if (!emailRegex.test(email)) {
                    document.getElementById("email-error").innerHTML = "Please enter a valid email address.";
                    return false;
                }

                // Street address validation (e.g., 10 Foobar Road)
                if (!/^\d+ \w+(\s+\w+)*$/.test(street)) {
                    document.getElementById("street-error").innerHTML = "Please enter a valid street address.";
                    return false;
                }

                // Postcode validation (e.g., AB1 2CD)
                if (!/^[A-Z]{1,2}\d{1,2} ?\d[A-Z]{2}$/i.test(postcode)) {
                    document.getElementById("postcode-error").innerHTML = "Please enter a valid postcode.";
                    return false;
                }

                // Card number validation (16-19 digits)
                if (!/^\d{16,19}$/.test(cardNumber)) {
                    document.getElementById("cardnumber-error").innerHTML = "Please enter a valid card number (16-19 digits).";
                    return false;
                }

                // Expire date validation (not empty)
                if (expireDate === "") {
                    document.getElementById("expiredate-error").innerHTML = "Please enter a valid expire date.";
                    return false;
                }

                // CVV validation (3 digits)
                if (!/^\d{3}$/.test(cvv)) {
                    document.getElementById("cvv-error").innerHTML = "Please enter a valid CVV (3 digits).";
                    return false;
                }

                return true;
            }

            // Clear error messages when the inputs are modified
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener("input", function() {
                    document.getElementById(this.id + "-error").innerHTML = "";
                });
            }
        </script>
    </body>
</html>