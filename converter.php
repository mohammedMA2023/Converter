<!DOCTYPE html>
<html>
<head>
    <title>Unit Converter - V2</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <h1>Unit Converter - V2</h1>
    <h2><?php echo $_POST["conv"]?> Conversion</h2>
    <div class="result-container">
        
        <?php
        // This code will log the IP and time to the log.txt file.
        $ip = $_SERVER["REMOTE_ADDR"];
        date_default_timezone_set("Europe/London");
        $date = date('d-m-Y H:i:s');
        $file = 'log.txt';
        $current = file_get_contents($file);
        $newLine = "User " . $ip . " made a request at: " . $date . "\r\n";
        $current = $current . $newLine;
        file_put_contents($file, $current);

        // Function to handle exceptions gracefully
        function handleException($e) {
            echo "Error: " . $e->getMessage();
        }

        // Function to safely convert input to float
        function safeFloatval($input) {
            if (is_numeric($input)) {
                return floatval($input);
            } else {
                throw new Exception("Please enter a valid numeric input.");
            }
        }

        // This function will be able to convert between units like meters to feet and inches (could also apply to other similar conversion processes).    
        function convert1($val, $factor, $factor2, $text1, $text2, $text3) {
            $initial_convert = $val * $factor;
            $new_conv = ($initial_convert - (int)$initial_convert) * $factor2;

            echo "<p>" . " What you entered: "  . " $val" . " $text1 " . "</p>";
            echo "<p>"  . (int)$initial_convert . " $text2</p>";
            echo "<p>" . round($new_conv, 2) . " $text3</p>";
        }

        // This function will do the reverse of the first function (for conversions like feet and inches into meters).
        function convert2($val, $val2, $factor, $factor2, $text1, $text2, $text3) {
            $initial_convert = $val / $factor;
            $new_conv = ($initial_convert + $val2) / $factor2;

            echo "<p>" . " What you entered: " . $val2 . "$text1" . " $val" . " $text2 " . "</p>";

            echo "<p>" . round($new_conv, 2) . " $text3</p>";
        }

        // This is a function that will be able to carry simple conversions like kilometers to meters (could be applied to other similar conversions).
        function convert3($val, $factor, $text1, $text2) {
            echo "<p>What you entered: " . $_POST["input1"] . " $text1" . "</p>";

            echo "<p>" . round($val * $factor, 2) . " $text2</p>";
        }

        // This function will convert between units like meters into kilometers.
        function convert4($val, $factor, $text1, $text2) {
            echo "<p>What you entered: " . $_POST["input1"]. " $text1</p>";

            echo "<p>" . round($val / $factor, 2) . " $text2</p>";
        }

        // This switch block will determine the conversion which should take place.
        try {
            $convValue = $_POST['conv'];

            switch ($convValue) {
                case 'Meters to Feet and Inches':
                    convert1(safeFloatval($_POST["input1"]), 3.281, 12, "m", "Ft", "In");
                    break;

                case 'Feet and Inches to Meters':
                    convert2(safeFloatval($_POST['input2']), safeFloatval($_POST['input1']), 12, 3.281, "Ft", "In", "m");
                    break;

                case 'Kilometers to Miles':
                    convert4(safeFloatval($_POST['input1']), 1.6, "Kilometers", "Miles");
                    break;

                case "Miles to Kilometers":
                    convert3(safeFloatval($_POST['input1']), 1.6, "Miles", "Kilometers");
                    break;

                case "Fahrenheit to Celsius":
                    convert3(safeFloatval(($_POST['input1'] - 32) * (5 / 9)), 1, "Fahrenheit (°F)", "Celsius (°C)");
                    break;

                case "Celsius to Fahrenheit":
                    convert3(safeFloatval($_POST['input1']) * (9/5) + 32, 1, "Celsius (°C)", "Fahrenheit (°F)");
                    break;

                default:
                    // Code to handle when none of the specified options match
                    echo "Invalid selection.";
                    break;
            }
        } catch (Exception $e) {
            handleException($e);
        }
        ?>

    </div>

    <form method="get" action="index.html">
        <br><br>
        <input type="submit" value="Go Back"> 
    </form>

    <br>
    <p>Thanks for using the converter!</p>
</body>
</html>
