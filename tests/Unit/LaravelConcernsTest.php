<?php

namespace Tests\Unit;

use Tests\Post;
use Tests\TestCase;
use Tests\User;

class LaravelConcernsTest extends TestCase
{
    public function test_filter_html()
    {
        $html = "<a href=\"#\" onclick=\"alert(123)\"></a>";
        $this->assertEquals('<a href="#"></a>', filter_html($html));
        $html = "<a href=\"#\" id=\"test\" data-test=\"something\" onclick=\"alert(123)\"></a>";
        $this->assertEquals('<a href="#"></a>', filter_html($html));
        $html = "<a href=\"#\" id=\"test\" data-test=\"something\" onclick=\"alert(123)\"></a><script>alert(123)</script>";
        $this->assertEquals('<a href="#"></a>', filter_html($html));
    }

    public function testResourceName()
    {
        $this->assertEquals('users', (new User())->getResourceName());
        $this->assertEquals('custom_resource_name', (new Post())->getResourceName());
    }
}
