<?php

namespace Elnooronline\LaravelConcerns\Tests\Http\Controllers;

use Elnooronline\LaravelConcerns\Tests\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return ['Ahmed'];
    }
}