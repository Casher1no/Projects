<?php

namespace App\Controllers;

use App\View;

class UsersController
{
    public function index(): View
    {
        return new View('Users/index.html', [
            "articles" => []
        ]);
    }

    public function show(array $vars): View
    {
        return new View('Users/show.html', [
            "id" => $vars["id"]
        ]);
    }
}
