<?php

class SessionManager
{
    private $userManager = NULL;

    public function __construct($userManager)
    {
        if ($userManager === NULL)
            throw new Exception("unable to initiate session manage because of invalid user manager");
        else
            $this->userManager = $userManager;
    }

    public function is_logged_user_valid ()
    {
        return (isset($_SESSION) && isset($_SESSION["user"])
            && $_SESSION["user"] !== ""
            && $this->userManager->get_user($_SESSION["user"]));
    }

    public function log_in_user ($login, $password)
    {
        if ($this->userManager->authenticate($login, $password))
        {
            $_SESSION["user"] = $login;
            return true;
        }
        else
            return false;
    }

    public function log_out_user ()
    {
        $_SESSION["user"] = "";
    }

    public function get_logged_user_name ()
    {
        if ($this->is_logged_user_valid())
            return $_SESSION["user"];
        else
        {
            $this->log_out_user();
            return "";
        }
    }

    public function update_user_name($login)
    {
        if ($this->userManager->get_user($login))
        {
            $_SESSION["user"] = $login;
            return true;
        }
        else
        {
            $this->log_out_user();
            return false;
        }
    }
}