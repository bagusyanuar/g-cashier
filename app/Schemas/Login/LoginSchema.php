<?php


namespace App\Schemas\Login;


use App\Commons\Schema\BaseSchema;
use Illuminate\Validation\Rules\Password;

class LoginSchema extends BaseSchema
{
    private $username;
    private $password;

    protected function rules()
    {
        return [
            'username' => 'required',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
        ];
    }

    public function hydrateBody()
    {
        $username = $this->body['username'];
        $password = $this->body['password'];
        $this->setUsername($username)
            ->setPassword($password);
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
     * @return LoginSchema
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return LoginSchema
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

}
