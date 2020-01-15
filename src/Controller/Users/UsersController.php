<?php

namespace App\Controller\Users;

use App\Controller\AbstractController;
use App\Model\Element\NavbarManager;
use App\Model\Users\UsersManager;
use App\lib\CreateImage;
use App\lib\JeFutLeBordel;
use App\Model\Element\GalleryNameManager;
use App\Model\Element\GalleryPhotoManager;

class UsersController extends AbstractController
{
    private $errors;
    private $userManager;
    private $members;
    private $firstname;
    private $lastname;
    private $pseudo;
    private $birthday;
    private $email;
    private $password;
    private $ageDifference;



    public function signIn()
    {
        $authority = $_SESSION["authority"];
        $navbarManager = new NavbarManager;
        $menus = $navbarManager->selectByAuthority($authority);
        return $this->twig->render('Users/signIn.html.twig', ["menus"=>$menus,"sessions"=>$_SESSION]);
    }

    public function checkSignIn()
    {
        if (empty($_POST["pseudo"])) {
            $this->errors[] = "pas de pseudo";
            $_SESSION["firstname"] = 'Enter Pseudo';
        }
        if (empty($_POST["password"])) {
            $this->errors[] = "pas de password";
            $_SESSION["lastname"] = 'Enter Password';
        }
        //if(empty($this->errors))
        {
            $pseudo = htmlspecialchars($_POST["pseudo"]);
            $password = htmlspecialchars($_POST["password"]);
        }

        //recuperation de user dans la base de donner
        //on regarde si le pseudo existe


        $usersManager = new UsersManager();
        $users = $usersManager->selectByName($pseudo);
        $_SESSION["userId"]=$users["ID"];
        //check si le pseudo existe dans la base de donnees
        //et si le mot de passe est bonne
        if ($pseudo == $users["pseudo"] && $password == $users["password"] && 0 != $users) {
            $_SESSION["authority"] = $users["authority"];

            if ('X' == $users["authority"]) {
                //si le user est admin direction vers la section admin
                header("Location: ../Admin/index");
            } else {
                //sinon ver le index
                header("Location: /");
            }
        } else {
            //si le user ne existe pas redirections sur la form signIn
            $_SESSION["signin"]="Username or Password wrong";
            header("Location: signIn");
        }
    }

    public function signUp()
    {
        $authority = $_SESSION["authority"];
        $navbarManager = new NavbarManager;
        $menus = $navbarManager->selectByAuthority($authority);
        return $this->twig->render('Users/signUp.html.twig', ["menus"=>$menus,"sessions"=>$_SESSION]);
    }

    public function checkSignUp()
    {
        $this->doFieldsCheckSignUp();

        //si la variable post ette bien ramplie on continuer
        if (empty($this->errors)) {
            $this->doPostTOVariable();
            //doTo
            //-check email syntax
            //-compare pseudo in database to finde double
            //-check password syntax and hash it
            //-check age
            //check mail

            $jeFutLeBordel=new JeFutLeBordel(
                $this->members,
                $this->pseudo,
                $this->email,
                $this->password,
                $this->ageDifference,
                $this->errors
            );

            $this->errors=$jeFutLeBordel->doJeFutLeBordel();
            
            //Si tout va bien continuer inser le tableaux et return sur la prochain page
            var_dump($this->errors);
            if (empty($this->errors)) {
                $usersManager = new UsersManager();
                $_SESSION["userId"] = $usersManager->insertUser(
                    $this->firstname,
                    $this->lastname,
                    $this->pseudo,
                    $this->email,
                    $this->birthday,
                    $this->password
                );
                header("Location: /");
            } else {
                //sinon return vers la page signUp.php
                
                header("Location: signUp");
            }
        } else {
            //sinon return vers la page signUp.php
            
            header("Location: signUp");
        }
    }

    public function uploadUserImage()
    {
        $galleryNameManager=new GalleryNameManager();
        $galleryNameManager=$galleryNameManager->selectAll();
        $navbarManager=new NavbarManager();
        $menus=$navbarManager->selectByAuthority($_SESSION["authority"]);
        return $this->twig->render(
            "Users/uploadUserImage.html.twig",
            ["session"=>$_SESSION["error"],
            "gallerys"=>$galleryNameManager,
            "menus"=>$menus
            ]
        );
    }

    public function createUserImage()
    {
        if ($_POST["description"]!="") {
            $createImage=new CreateImage($_FILES, $_POST["description"]);
            $createImage->doCreateImage();
            if (isset($_SESSION["lastInsertID"])&&$_SESSION["lastInsertID"]!="") {
                $galleryPhotoManager=new GalleryPhotoManager();
                $galleryPhotoManager->insert((int)$_SESSION["lastInsertID"], (int)$_POST["gallery"]);
            }
            $_POST=array();
        } else {
            $_SESSION["error"]="Non description set";
            var_dump($_POST);
            header("Location: /Users/uploadUserImage");
        }
    }

    public function signOut()
    {
        session_unset();
        session_destroy();
        header("Location: /");
    }

    // ############################### DO CONTOLLE AND CHECKS ##########################

    public function doFieldsCheckSignUp()
    {
        //on controlle si la variable es cest valeur sont vide
        if (empty($_POST["firstname"])) {
            $this->errors[] = "Firstname is empty!";
            $_SESSION["firstname"] = 'Enter Firstname:';
        }
        if (empty($_POST["lastname"])) {
            $this->errors[] = "Lastname is empty!";
            $_SESSION["lastname"] = 'Enter Lastname:';
        }
        if (empty($_POST["pseudo"])) {
            $this->errors[] = "Pseudo is empty!";
            $_SESSION["pseudo"] = 'Enter Pseudo:';
        }
        if (empty($_POST["birthday"])) {
            $this->errors[] = "Birthday is empty!";
            $_SESSION["birthday"] = 'Enter Birthday:';
        }
        if (empty($_POST["email"])) {
            $this->errors[] = "Email is empty!";
            $_SESSION["email"] = 'Enter Email:';
        }
        if (empty($_POST["password"])) {
            $this->errors[] = "Password is empty!";
            $_SESSION["password"] = 'Enter Password:';
        }
        if (!empty($this->errors)) {
            $_SESSION["signup"]="";
            foreach ($this->errors as $error) {
                $_SESSION["signup"].=$error.' ';
            }
        }
    }

    public function doPostToVariable()
    {
        $this->userManager = new UsersManager();
        $this->members = $this->userManager->selectAll();
        $this->firstname = htmlspecialchars($_POST["firstname"]);
        $this->lastname = htmlspecialchars($_POST["lastname"]);
        $this->pseudo = htmlspecialchars($_POST["pseudo"]);
        $this->birthday = htmlspecialchars($_POST["birthday"]);
        $this->email = htmlspecialchars($_POST["email"]);
        $this->password = htmlspecialchars($_POST["password"]);
        $this->ageDifference = date_diff(date_create(), date_create($this->birthday));
        $this->ageDifference = (int) $this->ageDifference->format('%Y');
    }
}
