<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form";
$dbtb = "users";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try { // Try block එක ඇරඹීම
        // Sanitize inputs
        $fields = [
            'firstname' => mysqli_real_escape_string($conn, $_POST['firstname'] ?? ''),
            'lastname'  => mysqli_real_escape_string($conn, $_POST['lastname'] ?? ''),
            'email'     => mysqli_real_escape_string($conn, $_POST['email'] ?? ''),
            'phonenumber' => mysqli_real_escape_string($conn, $_POST['phonenumber'] ?? ''),
            'address'   => mysqli_real_escape_string($conn, $_POST['address'] ?? ''),
            'address2'  => mysqli_real_escape_string($conn, $_POST['address2'] ?? ''),
            'state'     => mysqli_real_escape_string($conn, $_POST['state'] ?? ''),
            'country'   => mysqli_real_escape_string($conn, $_POST['country'] ?? ''),
            'post'      => mysqli_real_escape_string($conn, $_POST['post'] ?? ''),
            'area'      => mysqli_real_escape_string($conn, $_POST['area'] ?? '')
        ];

        // Prepared statement
        $stmt = $conn->prepare("INSERT INTO $dbtb (firstname, lastname, email, phonenumber, address, address2, state, country, post, area) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", 
            $fields['firstname'],
            $fields['lastname'],
            $fields['email'],
            $fields['phonenumber'],
            $fields['address'],
            $fields['address2'],
            $fields['state'],
            $fields['country'],
            $fields['post'],
            $fields['area']
        );

        if ($stmt->execute()) {
            $_SESSION['success'] = "Welcome to our team.! You added waiting list..";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }

        $stmt->close();

    } catch (Exception $e) { // Try  Catch
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    // Redirect  POST request 
    header("Location: form.php");
    exit();
}

mysqli_close($conn);
?>