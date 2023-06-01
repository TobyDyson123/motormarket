<?php
    session_start();
    // Check if the user is logged in, if not then redirect to the login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    // Database connection parameters
    $host = 'localhost';      // Change this if your database server is located elsewhere
    $username = 'root';
    $password = '';
    $database = 'cars';

    // Create a database connection
    $connection = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Panel</title>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                background: #9492FF !important;
                display: flex;
            }
        </style>
    </head>
    <body>
        <div class="tools-navbar">
            <img src="images/logos/logo-white-small-transparent.png" alt="Logo">
            <h3>Tools</h3>
            <ul class="tools-list">
                <li><a href="admin.php?tool=add">Add Records</a></li>
                <li><a href="admin.php?tool=change">Change Records</a></li>
                <li><a href="admin.php?tool=delete">Delete Records</a></li>
            </ul>
            <a href="index.html" style="position: absolute; bottom: 20px; left: 20px; color: inherit;">Return to Home</a>
        </div>

        <div class="admin-content">
            <?php
                // Check if a tool parameter is set in the GET request
                if (isset($_GET['tool'])) {
                    $tool = $_GET['tool'];

                    // Load the corresponding functionality based on the tool parameter
                    switch ($tool) {
                        case 'add':
                            // Load the functionality for adding records
                            ?>

                            <!-- Add records -->
                            <h2>Add Records</h2>
                            <button class="hamburger"></button>
                            <div class="admin-content-wrapper">
                                <div class="admin-content-info-grid">
                                    <!-- Car Info -->
                                    <h3 id="car-header">Car Information</h3>
                                    <div class="admin-content-car-info">
                                        <div>
                                            <form action="admin.php?tool=add" method="POST" onsubmit="return validateForm();">
                                            <div class="form-group">
                                                <label for="make">Make:</label>
                                                <input type="text" id="make" name="make" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="model">Model:</label>
                                                <input type="text" id="model" name="model" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="reg">Registration:</label>
                                                <input type="text" id="reg" name="reg" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="colour">Colour:</label>
                                                <input type="text" id="colour" name="colour" required>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <label for="miles">Miles:</label>
                                                <input type="text" id="miles" name="miles" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="price">Price:</label>
                                                <input type="text" id="price" name="price" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description:</label>
                                                <input type="text" id="description" name="description" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="carIndex">Car Index:</label>
                                                <input type="text" id="carIndex" name="carIndex" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Dealer Info -->
                                    <h3 id="dealer-header">Dealer Information</h3>
                                    <div class="admin-content-dealer-info">
                                            <div class="form-group">
                                                <label for="dealer">Dealer:</label>
                                                <input type="text" id="dealer" name="dealer" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="telephone">Telephone:</label>
                                                <input type="text" id="telephone" name="telephone" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="region">Region:</label>
                                                <input type="text" id="region" name="region" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="town">Town:</label>
                                                <input type="text" id="town" name="town" required>
                                            </div>
                                    </div>
                                </div>
                                <input class="btn btn-primary" type="submit" value="Add">
                                </form>
                                <?php
                                    // Check if the form was submitted
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                        // Retrieve the form data
                                        $make = $_POST['make'];
                                        $model = $_POST['model'];
                                        $reg = $_POST['reg'];
                                        $colour = $_POST['colour'];
                                        $miles = $_POST['miles'];
                                        $price = $_POST['price'];
                                        $description = $_POST['description'];
                                        $carIndex = $_POST['carIndex'];
                                        $dealer = $_POST['dealer'];
                                        $telephone = $_POST['telephone'];
                                        $region = $_POST['region'];
                                        $town = $_POST['town'];

                                        // Prepare the SQL statement
                                        $sql = "INSERT INTO cars (make, model, reg, colour, miles, price, `description`, carIndex, dealer, telephone, region, town)
                                                VALUES ('$make', '$model', '$reg', '$colour', '$miles', '$price', '$description', '$carIndex', '$dealer', '$telephone', '$region', '$town')";

                                        // Execute the SQL statement
                                        if (mysqli_query($connection, $sql)) {
                                            // Record added successfully
                                            echo "Record added successfully.";
                                        } else {
                                            // Error occurred
                                            echo "Error: " . mysqli_error($connection);
                                        }
                                    }
                                echo "</div>";
                            break;

                        case 'change':
                            // Load the functionality for changing records
                            ?>

                            <!-- Change records -->
                            <h2>Change Records</h2>
                            <button class="hamburger"></button>
                            <div class="admin-content-wrapper">
                                <form action="" method="GET">
                                    <input type="hidden" name="tool" value="change">
                                    <label for="targetCar">Car Index:</label>
                                    <input type="text" id="targetCar" name="targetCar" required><br>
                                    
                                    <input class="car-index-search" type="submit" value="Search">
                                </form>

                                <?php
                                    // Check if a target car parameter is set in the GET request
                                    if (isset($_GET['targetCar'])) {
                                        $targetCar = $_GET['targetCar'];
                                        
                                        // Prepare the SQL query
                                        $sql = "SELECT make, model, colour, reg, miles, price, carIndex, dealer, town, telephone, description, region FROM cars WHERE carIndex = ?";

                                        // Prepare the statement
                                        $stmt = $connection->prepare($sql);

                                        // Bind the car index parameter
                                        $stmt->bind_param("i", $targetCar);

                                        // Execute the statement
                                        $stmt->execute();

                                        // Bind the result variables
                                        $stmt->bind_result($make, $model, $colour, $reg, $miles, $price, $carIndex, $dealer, $town, $telephone, $description, $region);

                                        // Fetch the results
                                        if ($stmt->fetch()) {
                                            ?>
                                            <div class="admin-content-info-grid">
                                                <!-- Car Info -->
                                                <h3 id="car-header">Car Information</h3>
                                                <div class="admin-content-car-info">
                                                    <div>
                                                        <form action="admin.php?tool=change&targetCar=<?php echo $targetCar ?>" method="POST">
                                                        <div class="form-group">
                                                            <label for="make">Make:</label>
                                                            <input type="text" id="make" name="make" value="<?php echo $make; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="model">Model:</label>
                                                            <input type="text" id="model" name="model" value="<?php echo $model; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="reg">Registration:</label>
                                                            <input type="text" id="reg" name="reg" value="<?php echo $reg; ?>" required><br>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="colour">Colour:</label>
                                                            <input type="text" id="colour" name="colour" value="<?php echo $colour; ?>" required><br>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="form-group">
                                                            <label for="miles">Miles:</label>
                                                            <input type="text" id="miles" name="miles" value="<?php echo $miles; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="price">Price:</label>
                                                            <input type="text" id="price" name="price" value="<?php echo $price; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="description">Description:</label>
                                                            <input type="text" id="description" name="description" value="<?php echo $description; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="carIndex">Car Index:</label>
                                                            <input type="text" id="carIndex" name="carIndex" value="<?php echo $carIndex; ?>" required><br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Dealer Info -->
                                                <h3 id="dealer-header">Dealer Information</h3>
                                                <div class="admin-content-dealer-info">
                                                        <div class="form-group">
                                                            <label for="dealer">Dealer:</label>
                                                            <input type="text" id="dealer" name="dealer" value="<?php echo $dealer; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="telephone">Telephone:</label>
                                                            <input type="text" id="telephone" name="telephone" value="<?php echo $telephone; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="region">Region:</label>
                                                            <input type="text" id="region" name="region" value="<?php echo $region; ?>" required><br>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="town">Town:</label>
                                                            <input type="text" id="town" name="town" value="<?php echo $town; ?>" required><br>
                                                        </div>
                                                </div>
                                            </div>
                                            <input class="btn btn-primary" type="submit" value="Change">
                                            </form>
                                            <?php
                                                // Check if the form was submitted
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                    // Retrieve the form data
                                                    $make = $_POST['make'];
                                                    $model = $_POST['model'];
                                                    $reg = $_POST['reg'];
                                                    $colour = $_POST['colour'];
                                                    $miles = $_POST['miles'];
                                                    $price = $_POST['price'];
                                                    $description = $_POST['description'];
                                                    $carIndex = $_POST['carIndex'];
                                                    $dealer = $_POST['dealer'];
                                                    $telephone = $_POST['telephone'];
                                                    $region = $_POST['region'];
                                                    $town = $_POST['town'];

                                                    $stmt->close();

                                                    // Prepare the SQL statement
                                                    $sql = "UPDATE cars SET 
                                                                make = ?, 
                                                                model = ?, 
                                                                reg = ?, 
                                                                colour = ?,
                                                                miles = ?, 
                                                                price = ?, 
                                                                `description` = ?, 
                                                                carIndex = ?, 
                                                                dealer = ?, 
                                                                telephone = ?, 
                                                                region = ?, 
                                                                town = ?
                                                            WHERE carIndex = ?";

                                                    // Prepare the statement
                                                    $stmt = $connection->prepare($sql);

                                                    // Bind the parameters
                                                    $stmt->bind_param("ssssiisissssi", $make, $model, $reg, $colour, $miles, $price, $description, $carIndex, $dealer, $telephone, $region, $town, $carIndex);

                                                    // Execute the statement

                                                    if ($stmt->execute()) {
                                                        // Record updated successfully
                                                        $recordUpdated = true;
                                                        echo "<script>window.location.href = 'admin.php?tool=change';</script>";
                                                    } else {
                                                        // Error occurred
                                                        echo "Error: " . $stmt->error;
                                                    }
                                                }
                                        } else {
                                            echo "Car not found.";
                                        }

                                        // Close the statement and connection
                                        $stmt->close();
                                        $connection->close();
                                    }
                                echo "</div";
                            break;

                        case 'delete':
                            // Load the functionality for deleting records
                            ?>

                            <!-- Delete records -->
                            <h2>Delete Records</h2>
                            <button class="hamburger"></button>
                            <div class="admin-content-wrapper">
                                <form action="" method="GET">
                                    <input type="hidden" name="tool" value="delete">
                                    <label for="targetCar">Car Index:</label>
                                    <input type="text" id="targetCar" name="targetCar" required><br>
                                    
                                    <input class="car-index-search" type="submit" value="Search">
                                </form>

                                <?php
                                    // Check if a target car parameter is set in the GET request
                                    if (isset($_GET['targetCar'])) {
                                        $targetCar = $_GET['targetCar'];
                                        
                                        // Prepare the SQL query
                                        $sql = "SELECT make, model, colour, reg, miles, price, carIndex, dealer, town, telephone, description, region FROM cars WHERE carIndex = ?";

                                        // Prepare the statement
                                        $stmt = $connection->prepare($sql);

                                        // Bind the car index parameter
                                        $stmt->bind_param("i", $targetCar);

                                        // Execute the statement
                                        $stmt->execute();

                                        // Bind the result variables
                                        $stmt->bind_result($make, $model, $colour, $reg, $miles, $price, $carIndex, $dealer, $town, $telephone, $description, $region);

                                        // Fetch the results
                                        if ($stmt->fetch()) {
                                            ?>
                                            <div class="admin-content-info-grid">
                                                <!-- Car Info -->
                                                <h3 id="car-header">Car Information</h3>
                                                <div class="admin-content-car-info">
                                                    <div>
                                                        <p>Make: <?php echo $make ?></p>
                                                        <p>Model: <?php echo $model ?></p>
                                                        <p>Colour: <?php echo $colour ?></p>
                                                        <p>Reg: <?php echo $reg ?></p>
                                                    </div>
                                                    <div>
                                                        <p>Price: <?php echo $price ?></p>
                                                        <p>Miles: <?php echo $miles ?></p>
                                                        <p>Description: <?php echo $description ?></p>
                                                        <p>Car Index: <?php echo $carIndex ?></p>
                                                    </div>
                                                </div>
                                                <!-- Dealer Info -->
                                                <h3 id="dealer-header">Dealer Information</h3>
                                                <div class="admin-content-dealer-info">
                                                    <p>Dealer: <?php echo $dealer ?></p>
                                                    <p>Telephone: <?php echo $telephone ?></p>
                                                    <p>Town: <?php echo $town ?></p>
                                                    <p>Region: <?php echo $region ?></p>
                                                </div>
                                            </div>
                                            
                                            <form style="text-align: center" action="admin.php?tool=delete&targetCar=<?php echo $targetCar ?>" method="POST">
                                                <input type="hidden" name="carIndex" value="<?php echo $carIndex ?>">
                                                <button class="btn btn-primary" type="submit">Delete</button>
                                            </form>
                                            <?php
                                            $stmt->close();

                                            // handle deleting the record
                                            if (isset($_POST['carIndex'])) {
                                                $carIndex = $_POST['carIndex'];

                                                // Prepare the SQL statement
                                                $sql = "DELETE FROM cars WHERE carIndex = ?";

                                                // Prepare the statement
                                                $stmt = $connection->prepare($sql);

                                                // Bind the parameters
                                                $stmt->bind_param("i", $targetCar);

                                                // Execute the statement
                                                if ($stmt->execute()) {
                                                    // Record deleted successfully
                                                    echo "<script>window.location.href = 'admin.php?tool=delete';</script>";
                                                }
                                            }
                                        } else {
                                            echo "Car not found.";
                                        }

                                        // Close the statement and connection
                                        $connection->close();
                                    }
                            echo "</div>";
                            break;

                        default:
                            // Invalid tool parameter, handle error or redirect to a default tool
                            echo 'Invalid tool parameter';
                            break;
                    }
                }
            ?>
        </div>
    </body>
    <script>
        // Add an event listener to the hamburger button
        document.querySelector('.hamburger').addEventListener('click', function() {
            // Toggle the "show" class on the navbar
            document.querySelector('.tools-navbar').classList.toggle('show');
            // Toggle the "active" class on the hamburger button
            this.classList.toggle('active');
        });

        // Add records validation
        function validateForm() {
            var make = document.getElementById("make").value;
            var model = document.getElementById("model").value;
            var reg = document.getElementById("reg").value;
            var colour = document.getElementById("colour").value;
            var miles = document.getElementById("miles").value;
            var price = document.getElementById("price").value;
            var dealer = document.getElementById("dealer").value;
            var town = document.getElementById("town").value;
            var telephone = document.getElementById("telephone").value;
            var description = document.getElementById("description").value;
            var carIndex = document.getElementById("carIndex").value;
            var region = document.getElementById("region").value;

            // Make validation
            if (make.length > 10) {
                alert("Make should be up to 10 characters long.");
                return false;
            }

            // Model validation
            if (model.length > 15) {
                alert("Model should be up to 15 characters long.");
                return false;
            }

            // Reg validation
            if (reg.length !== 1) {
                alert("Registration should be 1 character long.");
                return false;
            }

            // Colour validation
            if (colour.length > 10) {
                alert("Colour should be up to 10 characters long.");
                return false;
            }

            // Miles validation
            if (miles.length > 6 || isNaN(miles)) {
                alert("Miles should be a number up to 6 digits long.");
                return false;
            }

            // Price validation
            if (price.length > 11 || isNaN(price)) {
                alert("Price should be a number up to 11 digits long.");
                return false;
            }

            // Dealer validation
            if (dealer.length > 50) {
                alert("Dealer should be up to 50 characters long.");
                return false;
            }

            // Town validation
            if (town.length > 20) {
                alert("Town should be up to 20 characters long.");
                return false;
            }

            // Telephone validation
            if (telephone.length > 15) {
                alert("Telephone should be up to 15 characters long.");
                return false;
            }

            // Description validation
            if (description.length > 30) {
                alert("Description should be up to 30 characters long.");
                return false;
            }

            // Car Index validation
            if (carIndex.length > 11 || isNaN(carIndex)) {
                alert("Car Index should be a number up to 11 digits long.");
                return false;
            }

            // Region validation
            if (region.length > 10) {
                alert("Region should be up to 10 characters long.");
                return false;
            }

            return true;
        }
    </script>
</html>