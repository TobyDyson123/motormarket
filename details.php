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

        <!-- Details -->
        <div class="details-box">
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
                    $sql = "SELECT make, model, colour, reg, miles, price, dealer, town, telephone, description, region FROM cars WHERE carIndex = ?";

                    // Prepare the statement
                    $stmt = $conn->prepare($sql);

                    // Bind the car index parameter
                    $stmt->bind_param("i", $carIndex);

                    // Execute the statement
                    $stmt->execute();

                    // Bind the result variables
                    $stmt->bind_result($make, $model, $colour, $reg, $miles, $price, $dealer, $town, $telephone, $description, $region);

                    // Function to generate the Google Images search URL
                    function generateGoogleImagesURL($query)
                    {
                        $baseURL = 'https://www.google.com/search';
                        $params = [
                            'tbm' => 'isch',
                            'q' => urlencode($query),
                        ];
                        $queryString = http_build_query($params);
                        $url = $baseURL . '?' . $queryString;

                        return $url;
                    }

                    // Fetch the results
                    if ($stmt->fetch()) {
                        $searchQuery = ucwords($colour) . " " . $make . " " . $model;
                        $googleImagesURL = generateGoogleImagesURL($searchQuery);
                        // Output the car information
                        echo "<h1>$make $model</h1><br>";
                        echo "<h2>£$price</h2><br>";
                        echo "<h3>Car Information</h3>";
                        echo "<div class='details-wrapper'>";
                        echo "<strong>Colour:</strong> " . ucwords($colour) . "<br>";
                        echo "<strong>Miles:</strong> $miles<br>";
                        echo "<strong>Registration:</strong> $reg<br>";
                        echo "<strong>Description:</strong> " . ucwords($description);
                        echo "</div><br><br>";
                        echo "<h3>Dealer Information</h3>";
                        echo "<div class='details-wrapper'>";
                        echo "<strong>Dealer:</strong> $dealer<br>";
                        echo "<strong>Telephone:</strong> $telephone<br>";
                        echo "<strong>Town:</strong> $town<br>";
                        echo "<strong>Region:</strong> $region";
                        echo "</div><br>";
                        echo '<a style="color: inherit; text-decoration: underline;" target="_blank" href="' . $googleImagesURL . '">Click here to search for ' . $searchQuery . ' on Google Images</a><br>';
                        echo "<a class='btn btn-primary' href='purchase.php?carIndex=" . $carIndex . "'>Purchase</a>";
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

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>