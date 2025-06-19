<?php
session_start();

// Connect to database
include '../../config/koneksi.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare statement
    $stmt = mysqli_prepare($conn, "SELECT u.*, r.nama_role 
    FROM user AS u
    JOIN role AS r ON r.id = u.role_id
    WHERE username=? AND password=?");

    // Check if the prepare statement succeeded
    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);

        // Execute statement
        mysqli_stmt_execute($stmt);

        // Store result
        $result = mysqli_stmt_get_result($stmt);

        // Check if username and password are valid
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            // Set session variables
            $_SESSION["username"] = $username;
            $_SESSION["name"] = $user["nama"];
            $_SESSION["id"] = $user["id"];
            $_SESSION["role"] = $user["role_id"];

            // Check if user is admin
            if ($user["role_id"] == 1) {
            // Redirect to kepala sekolah dashboard
                header("Location: ../apoteker/dashboard.php");
                exit(); // exit script after redirection
            }
            // Redirect to dashboard
            header("Location: ../admin/dashboard.php");
            exit(); // exit script after redirection
        } else {
            // Invalid credentials, redirect back to login page
            $_SESSION["error"] = "Terjadi kesalahan. Silahkan coba lagi.";
            header("Location: ../../index.php");
            exit(); // exit script after redirection
        }

        // Close result set
        mysqli_stmt_close($stmt);
    }
}

// Close connection
mysqli_close($conn);