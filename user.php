<?php
class User
{
    private string $name;
    private string $username;
    private string $password;
    private string $userType;
    // constructor
    //Set Behavior
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setUserType(string $userType)
    {
        $this->userType = $userType;
    }

    // Get Behavior
    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUserType()
    {
        return $this->userType;
    }
};
