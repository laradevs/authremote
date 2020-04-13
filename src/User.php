<?php


namespace LaraDevs\AuthRemote;


use Illuminate\Contracts\Auth\Authenticatable;

class User implements Authenticatable
{
    /**
     * @var array
     */
    protected $attributes = ['name', 'email','id','token','refreshToken','expiresIn','created_at','updated_at'];

    /**
     * User constructor.
     * @param $attributes
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->attributes[$attribute];
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->attributes['id'];
    }

    /**
     * Get the name of the unique identifier for the user.
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->attributes['id'];
    }

    /**
     * Get the password for the user.
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    /**
     * Get the token value for the "remember me" session.
     * @return string
     */
    public function getRememberToken()
    {
        return $this->attributes[$this->getRememberTokenName()];
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->attributes[$this->getRememberTokenName()] = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
