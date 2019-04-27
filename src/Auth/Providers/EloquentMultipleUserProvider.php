<?php

namespace Elnooronline\LaravelConcerns\Auth\Providers;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Config;

class EloquentMultipleUserProvider extends EloquentUserProvider
{
    protected $mapping = [];

    /**
     * EloquentMultipleUserProvider constructor.
     *
     * @param \Illuminate\Contracts\Hashing\Hasher $hasher
     * @param string $model
     * @param array $mapping
     */
    public function __construct(Hasher $hasher, $model, array $mapping)
    {
        parent::__construct($hasher, $model);

        $this->mapping = $mapping;
    }

    /**
     * @inheritdoc
     */
    public function retrieveById($identifier)
    {
        return $this->mapRetrievedAuthenticatable(parent::retrieveById($identifier));
    }

    /**
     * @inheritdoc
     */
    public function retrieveByToken($identifier, $token)
    {
        return $this->mapRetrievedAuthenticatable(parent::retrieveByToken($identifier, $token));
    }

    /**
     * @inheritdoc
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->mapRetrievedAuthenticatable(parent::retrieveByCredentials($credentials));
    }

    /**
     * Take a base authenticatable and return the proper object for it based on its type attribute.
     *
     * May return Customer, Shop or Manager model.
     *
     * @param $authenticatable
     * @return null
     */
    protected function mapRetrievedAuthenticatable($authenticatable)
    {
        if (! $authenticatable) {
            return null;
        }

        $typeColumnName = Config::get('laravel-concerns.user_type_column_name', 'type');

        $model = $this->mapping[$authenticatable->{$typeColumnName}];

        return $model::find($authenticatable->getAuthIdentifier());
    }
}
