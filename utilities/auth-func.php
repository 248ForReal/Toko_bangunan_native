<?php
session_start();

function register($nama_admin, $username, $password, $role) {
    global $conn_online;
    
    $nama_admin = mysqli_real_escape_string($conn_online, $nama_admin);
    $username = mysqli_real_escape_string($conn_online, $username);
    $password = password_hash(mysqli_real_escape_string($conn_online, $password), PASSWORD_BCRYPT);
    $role = mysqli_real_escape_string($conn_online, $role);
    
    $query = "INSERT INTO admins (nama_admin, username, password, role, createdAt, updatedAt) VALUES (?, ?, ?, ?, NOW(), NOW())";
    $statement = mysqli_prepare($conn_online, $query);
    mysqli_stmt_bind_param($statement, "ssss", $nama_admin, $username, $password, $role);
    
    if (mysqli_stmt_execute($statement)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Registrasi gagal: " . mysqli_stmt_error($statement);
    }
    
    mysqli_stmt_close($statement);
}

function login($username, $password) {
    global $conn_online;
    
    $username = mysqli_real_escape_string($conn_online, $username);
    
    $query = "SELECT * FROM admins WHERE username = ?";
    $statement = mysqli_prepare($conn_online, $query);
    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            $_SESSION['login_time'] = time();
            header("Location: main/");
            exit();
        } else {
            echo "Kata sandi salah.";
        }
    } else {
        echo "Nama pengguna tidak ditemukan.";
    }
    
    mysqli_stmt_close($statement);
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: ../");
    exit();  
}
?>
