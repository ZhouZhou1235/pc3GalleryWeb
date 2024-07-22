<!DOCTYPE html>
<?php
    session_start();
    session_unset();
    echo "
    <script>
        window.location.href='index.php';
    </script>
    ";
?>