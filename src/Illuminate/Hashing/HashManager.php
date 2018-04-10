<?php

namespace Illuminate\Hashing;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Manager;

class HashManager extends Manager implements Hasher
{
    /**
     * Create an instance of the Bcrypt hash Driver.
     *
     * @return BcryptHasher
     */
    public function createBcryptDriver()
    {
        return new BcryptHasher(isset($this->app['config']['hashing.bcrypt']) ? $this->app['config']['hashing.bcrypt'] : []);
    }

    /**
     * Create an instance of the Argon2 hash Driver.
     *
     * @return ArgonHasher
     */
    public function createArgonDriver()
    {
        return new ArgonHasher(isset($this->app['config']['hashing.argon']) ? $this->app['config']['hashing.argon'] : []);
    }

    /**
     * Get information about the given hashed value.
     *
     * @param  string $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return $this->driver()->info($hashedValue);
    }

    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     */
    public function make($value, array $options = [])
    {
        return $this->driver()->make($value, $options);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string $value
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return $this->driver()->check($value, $hashedValue, $options);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return $this->driver()->needsRehash($hashedValue, $options);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return isset($this->app['config']['hashing.driver']) ? $this->app['config']['hashing.driver'] : 'bcrypt';
    }
}
