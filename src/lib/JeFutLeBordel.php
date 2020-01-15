<?php

    namespace App\lib;

class JeFutLeBordel
{
    private $members;
    private $pseudo;
    private $email;
    private $password;
    private $ageDifference;
    private $errors;

    public function __construct($members, $pseudo, $email, $password, $ageDifference, $errors)
    {
        $this->members=$members;
        $this->pseudo=$pseudo;
        $this->email=$email;
        $this->password=$password;
        $this->ageDifference=$ageDifference;
        $this->errors=$errors;
    }

    public function doJeFutLeBordel()
    {
        $this->doControlleVariable();
        var_dump($this->errors);
        return $this->errors;
    }

    public function doControlleVariable()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "email es pas valide";
            $_SESSION["email"] = 'Addresse mail not valid';
            foreach ($this->members as $member) {
                if ($member["email"] == $this->email) {
                    $this->errors[] = "email deja existant";
                    $_SESSION["email"] = 'email alredy exist';
                }
            }
        }
        $this->doCheckPassword();
        //check pseudo
        foreach ($this->members as $member) {
            if ($member["pseudo"] == $this->pseudo) {
                $this->errors[] = "pseudo deja existant";
                $_SESSION["pseudo"] = 'Pesudo alredy exist';
            }
        }
        //check password
    }
    
    public function doCheckPassword()
    {
        if (4 >= strlen($this->password)) {
            $this->errors[] = "password es trop courte";
            $_SESSION["password"] = 'passowrd wrong';
        }
        if (!preg_match("#[0-9]+#", $this->password)) {
            $this->errors[] = "password as pas de chiffre";
            $_SESSION["password"] = 'passowrd wrong';
        }
        if (!preg_match("#[a-zA-Z]+#", $this->password)) {
            $this->errors[] = "password as pas de lettre";
            $_SESSION["password"] = 'passowrd wrong';
        }
        if ((int) $this->ageDifference < 0) {
            $this->errors[] = "Your musst be more then 18 year old";
            $_SESSION["birthday"] = 'Your musst be more then 18 year old';
        }
    }
}
