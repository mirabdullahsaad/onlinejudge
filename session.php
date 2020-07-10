<?php
    session_start();


    function message()
    {
        if (isset($_SESSION["message"])) {
            $output = "<div style=\"color:red;text-align:center;\" class=\"message\">";
            $output .= htmlentities($_SESSION["message"]);
            $output .= "</div><br>";
            $_SESSION["message"] = null;
            return $output;
        }
    }


    function errors()
    {
        if (isset($_SESSION["errors"])) {
            $errors = ($_SESSION["errors"]);
            $_SESSION["errors"] = null;
            return $errors;
        }
    }

?>
