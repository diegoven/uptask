<?php

namespace Controllers;

class LoginController
{
    public static function login()
    {
        echo "from login";

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }

    public static function logout()
    {
        echo "from logout";
    }

    public static function create()
    {
        echo "from create";

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }

    public static function forgotPassword()
    {
        echo "from forgotPassword";

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }

    public static function resetPassword()
    {
        echo "from resetPassword";

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }

    public static function message()
    {
        echo "from message";
    }

    public static function confirmUser()
    {
        echo "from confirmUser";
    }
}
