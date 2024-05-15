<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Data Table</title>
  <style>
    /* Table Styles */
    table {
      font-family: Arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
      margin: 20px auto; /* Center the table horizontally */
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    }

    td, th {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left; /* Align content to the left */
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold; /* Make headers bolder */
    }

    /* Additional Styles (Optional) */
    body {
      font-family: Arial, sans-serif;
    }

    h1 {
      text-align: center; /* Center the table title */
      margin-bottom: 10px; /* Add some space below the title */
    }

  </style>
</head>
<body>

<?php

$connect = mysqli_connect(

  'db', // Service name (replace with your actual service name)
  'php_docker', // Username
  'password', // Password
  'php_docker' // Database name (replace with your actual database name)

);

// Check connection errors
if (!$connect) {
  die("Connection failed: " . mysqli_connect_error());
}

$table_name = "php_docker_table";

// Handle adding new student (if submitted)
if (isset($_POST['submit'])) {
  $id = mysqli_real_escape_string($connect, $_POST['id']); // Sanitize input
  $name = mysqli_real_escape_string($connect, $_POST['name']); // Sanitize input
  $age = (int) $_POST['age']; // Cast to integer
  $cgpa = floatval($_POST['cgpa']); // Cast to float

  $query = "INSERT INTO $table_name (ID, Name, Age, CGPA) VALUES ('$id', '$name', $age, $cgpa)";

  if (mysqli_query($connect, $query)) {
    echo "<p style='color: green;'>Student added successfully!</p>";
  } else {
    echo "<p style='color: red;'>Error: " . mysqli_error($connect) . "</p>";
  }
}

// Display student data
$query = "SELECT * FROM $table_name";

$response = mysqli_query($connect, $query);

echo "<h1>Student Data: </h1>";

echo "<form method='post' style='margin-bottom: 10px;'>";
echo "  <label for='id'>ID:</label>";
echo "  <input type='number' name='id' id='id' required>";
echo "  <label for='name'>Name:</label>";
echo "  <input type='text' name='name' id='name' required>";
echo "  <label for='age'>Age:</label>";
echo "  <input type='number' name='age' id='age' min='1' required>";
echo "  <label for='cgpa'>CGPA:</label>";
echo "  <input type='number' name='cgpa' id='cgpa' step='0.01' min='0' max='4' required>";
echo "  <button type='submit' name='submit'>Add Student</button>";
echo "</form>";

echo "<table style='width:100%; border-collapse: collapse;'>"; // Start table

echo "<thead>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Name</th>";
echo "<th>Age</th>";
echo "<th>CGPA</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($response)) {
  echo "<tr>";
  echo "<td>" . $row['ID'] . "</td>";
  echo "<td>" . $row['Name'] . "</td>";
  echo "<td>" . $row['Age'] . "</td>";
  echo "<td>" . $row['CGPA'] . "</td>";
  echo "</tr>";
}

// Close the connection (important to release resources)
mysqli_close($connect);

echo "</tbody>";
echo "</table>"; // Close table

?>

</body>
</html>