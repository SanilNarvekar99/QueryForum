<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['id']) {

    session_reset();
    session_destroy();
    $name =   $_SESSION['userName'];
    echo "<script>alert('$name Thanks for using Query Solution platform!'); window.location.href = 'index.php'; </script>";
    exit();
} else {
    echo '<script>alert("Session Timed out Please login!");  window.location.href= "joinus.php"</script>';
    // header("Location: loginForm.php");
    exit();
}
