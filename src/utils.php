<?php include ( "inc/connect.inc.php" ); ?>

<?php
    function logout() 
    {
        session_start();

        session_destroy();

        setcookie('user_id', '', 0, "/");

        header("Location: index.php");
    }

    function get_user(mysqli $con, string $user_id) : array
    {
        return mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE user_id='$user_id'"));
    }
?>