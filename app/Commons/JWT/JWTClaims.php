<?php


namespace App\Commons\JWT;


class JWTClaims
{
    private $username;
    private $role;

    /**
     * JWTClaims constructor.
     * @param $username
     * @param $role
     */
    public function __construct($username, $role)
    {
        $this->username = $username;
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return JWTClaims
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     * @return JWTClaims
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
}
