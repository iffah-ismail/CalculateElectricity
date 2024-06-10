<!-- Created by: Nurul 'Iffah binti Che Ismail -->
 <!--10 June 2024 -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calculator</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-left">Calculate</h1>
        <form method="post" action="">
            <!--Input -->
            <div class="form-group">
                <label for="voltage">Voltage</label>
                <input type="number" step="any" class="form-control" id="voltage" name="voltage" required>
                <p>Voltage (V)</p>
            </div>
            <div class="form-group">
                <label for="current">Current</label>
                <input type="number" step="any" class="form-control" id="current" name="current" required>
                <p>Amphere (A)</p>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate </label>
                <input type="number" step="any" class="form-control" id="rate" name="rate" required>
                <p>(sen/kWh)</p>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Calculate</button>
            </div>
        </form>

        <?php
        //calculate power
        function calculatePower($voltage, $current) {
            return ($voltage * $current) / 1000;
        }

        //calculate energy
        function calculateEnergy($power, $hours) {
            return $power * $hours;
        }

        //calculate total cost
        function calculateTotalCost($energy, $rate) {
            return $energy * ($rate / 100);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // declare variables
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'];

            //calculate power in kW
            $power = calculatePower($voltage, $current);

            // array
            $results = [];

            // calculate energy usage and total cost for each hour in 24hrs
            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = calculateEnergy($power, $hour);
                $totalCost = calculateTotalCost($energy, $rate);
                $results[] = ['hour' => $hour, 'energy' => $energy, 'total' => $totalCost];
            }
            echo "<div class='mt-4'>";
            //Display results
            echo "<div class='card mb-3' style='border: 1px solid lightblue;'><div class='card-body'>";
            echo "<p class='card-text' style='color: darkblue;'><strong>POWER:</strong> " . number_format($power, 5) . " kW</p>";
            echo "<p class='card-text' style='color: darkblue;'><strong>RATE:</strong> " . number_format($rate / 100, 4) . " RM</p>";
            echo "</div></div>";
            
            echo "<table class='table table-bordered'>";
            // Table display details result
            echo "<thead><tr><th>#</th><th>Hour</th><th>Energy (kWh)</th><th>Total (RM)</th></tr></thead><tbody>";
            foreach ($results as $result) {
                
                echo "<tr><td>{$result['hour']}</td><td>{$result['hour']}</td><td>" . number_format($result['energy'], 5) . "</td><td>" . number_format($result['total'], 2) . "</td></tr>";
            }
            echo "</tbody></table>";
            echo "</div>";
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
