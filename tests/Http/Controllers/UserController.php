<?php

namespace Tests\Http\Controllers;

use Tests\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return ['Ahmed'];
    }
}