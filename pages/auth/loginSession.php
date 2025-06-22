<?php
session_start();

// Connect to database
include '../../config/koneksi.php';

// Function to redirect with error
function redirectWithError($message, $username = '')
{
    $_SESSION['error'] = $message;
    if (!empty($username)) {
        $_SESSION['old_username'] = $username;
    }
    header("Location: ../../index.php");
    exit();
}

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    redirectWithError("Akses tidak diizinkan.");
}

// Validate and sanitize input
$username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
$password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

// Basic validation
if (empty($username)) {
    redirectWithError("Username tidak boleh kosong.");
}

if (empty($password)) {
    redirectWithError("Password tidak boleh kosong.", $username);
}

if (strlen($username) < 3) {
    redirectWithError("Username minimal 3 karakter.", $username);
}

if (strlen($password) < 4) {
    redirectWithError("Password minimal 4 karakter.", $username);
}

// Check database connection
if (!$conn) {
    redirectWithError("Koneksi database gagal. Silakan coba lagi.");
}

// Sanitize username to prevent SQL injection
$username_clean = mysqli_real_escape_string($conn, $username);
$password_clean = mysqli_real_escape_string($conn, $password);

// Prepare statement untuk keamanan
$stmt = mysqli_prepare($conn, "SELECT u.*, r.nama_role 
    FROM user AS u
    JOIN role AS r ON r.id = u.role_id
    WHERE u.username = ? AND u.password = ?");

// Check if prepare statement succeeded
if (!$stmt) {
    redirectWithError("Terjadi kesalahan sistem. Silakan coba lagi.", $username);
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "ss", $username_clean, $password_clean);

// Execute statement
if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    redirectWithError("Terjadi kesalahan saat memverifikasi data. Silakan coba lagi.", $username);
}

// Get result
$result = mysqli_stmt_get_result($stmt);

// Check if username and password are valid
if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    // Verify user data
    if (empty($user['username']) || empty($user['nama'])) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        redirectWithError("Data pengguna tidak valid. Hubungi administrator.", $username);
    }

    // Set session variables
    $_SESSION["username"] = $user["username"];
    $_SESSION["nama"] = $user["nama"];
    $_SESSION["id"] = $user["id"];
    $_SESSION["role"] = $user["role_id"];
    $_SESSION["nama_role"] = $user["nama_role"];
    $_SESSION["login_time"] = time();

    // Clear any existing error messages
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['old_username'])) {
        unset($_SESSION['old_username']);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);

    // Redirect based on user role
    if ($user["role_id"] == 1) {
        // Karyawan (role_id = 1) → Dashboard Karyawan
        header("Location: ../karyawan/dashboard.php");
        exit();
    } else {
        // Admin (role_id = 2 atau lainnya) → Dashboard Admin
        header("Location: ../admin/dashboard.php");
        exit();
    }
} else {
    // Invalid credentials - check if username exists for better error message
    mysqli_stmt_close($stmt);

    // Check if username exists
    $checkStmt = mysqli_prepare($conn, "SELECT username FROM user WHERE username = ?");

    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "s", $username_clean);
        mysqli_stmt_execute($checkStmt);
        $userResult = mysqli_stmt_get_result($checkStmt);

        if (mysqli_num_rows($userResult) > 0) {
            // Username exists, so password is wrong
            mysqli_stmt_close($checkStmt);
            mysqli_close($conn);
            redirectWithError("Password yang Anda masukkan salah. Silakan periksa kembali.", $username);
        } else {
            // Username doesn't exist
            mysqli_stmt_close($checkStmt);
            mysqli_close($conn);
            redirectWithError("Username tidak ditemukan. Periksa kembali username Anda.", $username);
        }
    } else {
        // Generic error if we can't check username
        mysqli_close($conn);
        redirectWithError("Username atau password salah. Silakan periksa kembali.", $username);
    }
}

// Close connection
mysqli_close($conn);

// This should never be reached, but just in case
redirectWithError("Terjadi kesalahan yang tidak terduga. Silakan coba lagi.", $username);
