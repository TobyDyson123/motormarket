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

        <!-- Results -->
        <div class="results-box">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "cars";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve filter options
            $makeOptions = getDistinctValues($conn, "make");
            $colourOptions = getDistinctValues($conn, "colour");
            $townOptions = getDistinctValues($conn, "town");

            // Retrieve filter values from query parameters
            $selectedMake = isset($_GET['make']) ? $_GET['make'] : "";
            $selectedColour = isset($_GET['colour']) ? $_GET['colour'] : "";
            $minMiles = isset($_GET['min_miles']) ? $_GET['min_miles'] : "";
            $maxMiles = isset($_GET['max_miles']) ? $_GET['max_miles'] : "";
            $minPrice = isset($_GET['min_price']) ? $_GET['min_price'] : "";
            $maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : "";
            $selectedTown = isset($_GET['town']) ? $_GET['town'] : "";

            // Build the WHERE clause for filtering
            $whereClause = "1=1"; // Default condition
            if ($selectedMake) {
                $whereClause .= " AND make = '$selectedMake'";
            }
            if ($selectedColour) {
                $whereClause .= " AND colour = '$selectedColour'";
            }
            if ($minMiles) {
                $whereClause .= " AND miles >= $minMiles";
            }
            if ($maxMiles) {
                $whereClause .= " AND miles <= $maxMiles";
            }
            if ($minPrice) {
                $whereClause .= " AND price >= $minPrice";
            }
            if ($maxPrice) {
                $whereClause .= " AND price <= $maxPrice";
            }
            if ($selectedTown) {
                $whereClause .= " AND town = '$selectedTown'";
            }

            // Pagination
            $resultsPerPage = 4; // Number of results per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
            $offset = ($page - 1) * $resultsPerPage; // Offset for database query

            // Query to get total number of results with filters applied
            $totalResultsQuery = "SELECT COUNT(*) AS total FROM cars WHERE $whereClause";
            $totalResultsResult = $conn->query($totalResultsQuery);
            $totalResultsRow = $totalResultsResult->fetch_assoc();
            $totalResults = $totalResultsRow['total'];

            // Query to get filtered cars with pagination
            $query = "SELECT make, model, price, miles, colour, carIndex FROM cars WHERE $whereClause LIMIT $offset, $resultsPerPage";
            $result = $conn->query($query);

            // Display search results
            echo "<b>Showing " . ($offset + 1) . " to " . min($offset + $resultsPerPage, $totalResults) . " of $totalResults results</b><br><br>";
        ?>
            <!-- Filter toggle button -->
            <button class="filter-toggle-btn" onclick="toggleSidebar()">Toggle Filters</button>

            <!-- Filter sidebar -->
            <div id="filter-sidebar" class="filter-sidebar">
                <form method="GET">
                    <!-- Filter options -->
                    <?php
                    // Make
                    echo "Make: <select name='make'>";
                    echo "<option value=''>All</option>";
                    foreach ($makeOptions as $makeOption) {
                    $selected = $selectedMake == $makeOption ? "selected" : "";
                    echo "<option value='$makeOption' $selected>$makeOption</option>";
                    }
                    echo "</select><br><br>";

                    // Colour
                    echo "Colour: <select name='colour'>";
                    echo "<option value=''>All</option>";
                    foreach ($colourOptions as $colourOption) {
                    $selected = $selectedColour == $colourOption ? "selected" : "";
                    echo "<option value='$colourOption' $selected>" . ucwords($colourOption) . "</option>";
                    }
                    echo "</select><br><br>";

                    // Min Miles
                    echo "Min Miles: <select name='min_miles'>";
                    echo "<option value=''>Any</option>";
                    for ($i = 5000; $i <= 80000; $i += 5000) {
                    $selected = $minMiles == $i ? "selected" : "";
                    echo "<option value='$i' $selected>$i</option>";
                    }
                    echo "</select><br><br>";

                    // Max Miles
                    echo "Max Miles: <select name='max_miles'>";
                    echo "<option value=''>Any</option>";
                    for ($i = 10000; $i <= 130000; $i += 10000) {
                    $selected = $maxMiles == $i ? "selected" : "";
                    echo "<option value='$i' $selected>$i</option>";
                    }
                    echo "</select><br><br>";

                    // Min Price
                    echo "Min Price: <select name='min_price'>";
                    echo "<option value=''>Any</option>";
                    for ($i = 5000; $i <= 25000; $i += 500) {
                    $selected = $minPrice == $i ? "selected" : "";
                    echo "<option value='$i' $selected>$i</option>";
                    }
                    echo "</select><br><br>";

                    // Max Price
                    echo "Max Price: <select name='max_price'>";
                    echo "<option value=''>Any</option>";
                    for ($i = 10000; $i <= 35000; $i += 500) {
                    $selected = $maxPrice == $i ? "selected" : "";
                    echo "<option value='$i' $selected>$i</option>";
                    }
                    echo "</select><br><br>";

                    // Town
                    echo "Town: <select name='town'>";
                    echo "<option value=''>All</option>";
                    foreach ($townOptions as $townOption) {
                    $selected = $selectedTown == $townOption ? "selected" : "";
                    echo "<option value='$townOption' $selected>$townOption</option>";
                    }
                    echo "</select><br><br>";

                    // Submit
                    echo "<input style='background-color: #9492FF; border-radius: 5px; border: none; padding: 5px 20px;' type='submit' value='Filter'>";
                    echo "</form>";
                    echo "<form method='GET' action='cars.php' style='margin: 10px 0px;'>";
                    echo "<button style='border: none;' class='reset-filters-btn' type='submit'>Reset Filters</button>";
                    echo "</form>";
                    ?>
                </form>
            </div>

        <?php
            echo "<div class='results-grid'>";

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='grid-item' onclick=\"window.location.href='details.php?carIndex=" . $row['carIndex'] . "'\">";
                    echo "<b>" . $row['make'] . " " . $row['model'] . "</b><br>";
                    echo "Price: £" . $row['price'] . "<br>";
                    echo "Mileage: " . $row['miles'] . "<br>";
                    echo "Colour: " . ucwords($row['colour']) . "<br>";
                    echo "</div>";
                }
            } else {
                echo "No results found.";
            }

            echo "</div>";

            // Pagination links
            $totalPages = ceil($totalResults / $resultsPerPage);
            $visiblePages = 3; // Number of visible pages in the pagination links
            $startPage = max(1, $page - floor($visiblePages / 2));
            $endPage = min($startPage + $visiblePages - 1, $totalPages);

            $filters = $_GET; // Get all the current filter values
            unset($filters['page']); // Remove the 'page' parameter from the filters

            // Previous button
            if ($page > 1) {
                $prevPageUrl = 'cars.php?page=' . ($page - 1) . '&' . http_build_query($filters);
                echo "<a class='page-btn' href='$prevPageUrl'><span class='chevron'>&laquo;</span></a>";
            } else {
                echo "<span class='page-btn unclickable'><span class='chevron'>&laquo;</span></span>";
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $pageUrl = 'cars.php?page=' . $i . '&' . http_build_query($filters);
                if ($i == $page) {
                    echo "<span class='current-page'>$i</span> ";
                } else {
                    echo "<a class='clickable-page' href='$pageUrl' style='color: inherit; text-decoration: underline;'>$i</a> ";
                }
            }

            // Next button
            if ($page < $totalPages) {
                $nextPageUrl = 'cars.php?page=' . ($page + 1) . '&' . http_build_query($filters);
                echo "<a class='page-btn' href='$nextPageUrl'><span class='chevron'>&raquo;</span></a>";
            } else {
                echo "<span class='page-btn unclickable'><span class='chevron'>&raquo;</span></span>";
            }

            // Close connection
            $conn->close();

            // Function to retrieve distinct values for a given column
            function getDistinctValues($conn, $column)
            {
                $query = "SELECT DISTINCT $column FROM cars";
                $result = $conn->query($query);
                $values = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $values[] = $row[$column];
                    }
                }
                return $values;
            }
        ?>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- JavaScript for filter toggle and close buttons -->
        <script>
            function toggleSidebar() {
                var sidebar = document.getElementById("filter-sidebar");
                sidebar.classList.toggle("active");
            }
        </script>
    </body>
</html>