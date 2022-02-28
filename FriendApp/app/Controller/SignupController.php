<?php
namespace App\Controller;

use App\Redirect;
use App\Database;
use App\Model\Signup;
use App\View;

class SignupController
{
    public function signUp():View
    {
        return new View('/Users/signup');
    }

    public function signUpUser():Redirect
    {
        if (isset($_POST["submit"])) {
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
            if ($this->invalidEmail() == false) {
                // echo "Username or email taken!";
                return new Redirect("/articles");
                exit();
            }

            $hashedPwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);

        
            Database::connection()
            ->insert('users', [
                'email' => $_POST['email'],
                'password' => $hashedPwd,
            ]);
            
            $createdUser = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('users')
            ->where("email = ?")
            ->setParameter(0, $_POST['email'])
            ->fetchAllAssociative();
            
            Database::connection()
            ->insert('user_profiles', [
                'user_id' => $createdUser[0]['id'],
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'birthday' => $_POST['birthday']
            ]);
        }
        return new Redirect("/articles");
    }

    private function emptyInput(): bool
    {
        $result = false;
        if (empty($_POST['email']) ||
            empty($_POST['pwd']) ||
            empty($_POST['name'])||
            empty($_POST['surname'])||
            empty($_POST['birthday'])
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
        if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST['name']) || !preg_match("/^[a-zA-Z0-9]*$/", $_POST['surname'])) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail(): bool
    {
        $result = false;
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
