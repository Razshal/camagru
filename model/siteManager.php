<?php
Class siteManager
{
    private $info = "";

    public function success_log($message)
    {
        $this->info = $this->info . "<p class='success'>{$message}</p><br>";
    }
    public function error_log($message)
    {
        $this->info = $this->info . "<p class='error'>{$message}</p><br>";
    }
    public function info_log($message)
    {
        $this->info = $this->info . "<p class='info'>{$message}</p><br>";
    }
    public function get_logs()
    {
        return $this->info;
    }
    public function password_policie()
    {
        return "Password must be at least 8 long and contains at least one letter and one digit";
    }
    public function login_policie()
    {
        return "Login must be between 4 and 20 chars";
    }
}