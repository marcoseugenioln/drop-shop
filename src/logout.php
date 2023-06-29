<?php
    function logout() 
    {
        session_start();

        session_destroy();

        setcookie('user_id', '', 0, "/");

        header("Location: index.php");
    }
?>