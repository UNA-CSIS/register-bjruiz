<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Games List</title>
        <style>
            table{
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td{
                border: 1px solid black;
            }
            th, td{
                padding: 8px;
                text-align: left;
            }
            th{
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <h2>UNA NCAA Championship Season</h2>
        <a href='index.php'><b>Back to Login</b></a>
        <br>
        <table>
            <tr>
                <th>Opponent</th>
                <th>Result</th>
                <th>Site</th>
            </tr>

            <?php
            $sql = "SELECT * FROM games";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['opponent'] . "</td>";
                    echo "<td>" . $row['result'] . "</td>";
                    echo "<td>" . $row['site'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No games found</td></tr>";
            }
            ?>
        </table><br>
        
    </body>
</html>
<?php
$conn->close();
?>
