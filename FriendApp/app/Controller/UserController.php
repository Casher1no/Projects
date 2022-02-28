<?php

class UserController
{
    private string $email;
    private string $psw;

    public function __construct(string $email, string $psw)
    {
        $this->email = $email;
        $this->psw = $psw;
    }
}
