<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Models\User;
use Illuminate\Support\Facades\Route;

class TestPresenters extends TestCase
{
    /** @test */
    public function it_can_display_show_url()
    {
        Route::namespace('\Tests\Http\Controllers')->as('dashboard')->resource('/users', 'UserController');

        $user = User::create([
            'name' => 'username',
            'email' => 'username@email.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $this->assertEquals($user->present()->getEditUrl, '');
    }
}
