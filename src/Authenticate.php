<?php

class Authenticate
{
    public function is_authenticated()
    {
        if (!isset($_SESSION['email'])) {
            return false;
        }
        return true;
    }
}

