<?php
namespace App\Controller;

use App\Redirect;
use App\Database;

class SignupController
{
    public function signupUser()
    {
        if ($this->emptyInput() == false) {
            // echo "Empty input!";
            return new Redirect("/articles");
            exit();
        }
        if ($this->invalidUid() == false) {
            // echo "Invalid username!";
            return new Redirect("/articles");
            exit();
        }
        if ($this->invalidEmail() == false) {
            // echo "Invalid email!";
            return new Redirect("/articles");
            exit();
        }
        if ($this->pwdMatch() == false) {
            // echo "Passwords don't match!";
            return new Redirect("/articles");
            exit();
        }
        if ($this->invalidEmail() == false) {
            // echo "Username or email taken!";
            return new Redirect("/articles");
            exit();
        }

        $hashedPwd = password_hash($this->password, PASSWORD_DEFAULT);

        $userDatabase = Database::connection()->insert('users', [
            'email' => $this->email,
            'password' => $hashedPwd
        ]);
    }

    private function emptyInput(): bool
    {
        $result = false;
        if (empty($this->email) ||
            empty($this->password) ||
            empty($this->passwordRepeat) ||
            empty($this->name)||
            empty($this->surname)||
            empty($this->birthday)
            ) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidUid(): bool
    {
        $result =false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->name) || !preg_match("/^[a-zA-Z0-9]*$/", $this->surname)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail(): bool
    {
        $result = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
    
    private function pwdMatch(): bool
    {
        $result = false;
        if ($this->password !== $this->passwordRepeat) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
