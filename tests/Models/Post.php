<?php

namespace Elnooronline\LaravelConcerns\Tests\Models;

use Elnooronline\LaravelConcerns\Models\Abstracts\Model;

class Post extends Model
{
    /**
     * The resource name of the model.
     *
     * @var string
     */
    protected $resourceName = 'custom_resource_name';
}