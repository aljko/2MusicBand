<?php


namespace App\Model\Users;

use App\Model\AbstractManager;

class UsersManager extends AbstractManager
{

    /**
     * @param \PDO $pdo
     */
    const TABLE = "User";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectByName(string $pseudo)
    {
        if ($this->pdo->query("SELECT * FROM User WHERE pseudo='{$pseudo}'")->fetch()) {
            return $this->pdo->query("SELECT * FROM User WHERE pseudo='{$pseudo}'")->fetch();
        } else {
            return 0;
        }
    }

    public function insertUser($firstname, $lastname, $pseudo, $email, $birthday, $password, $authority = "W")
    {
        $doInsert = $this->pdo->prepare("INSERT INTO User(firstname,lastname,pseudo,email,birthday,password,authority)
            VALUES(?,?,?,?,?,?,?);SELECT LAST_INSERT_ID()");
        $doInsert->execute(array($firstname, $lastname, $pseudo, $email, $birthday, $password, $authority));
        return $this->pdo->lastInsertId();
    }

    public function insertUserImage($targetFile, $description)
    {
        $targetFile=str_replace('../public/', '', $targetFile);
        $_SESSION["uploadImageOk"] = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        $userPhoto = $this->pdo->prepare("INSERT INTO 
        Photos(name,path_image,date_upload,valid) 
        VALUES(:name,:path_image,:date_upload,:valid)");
        $userPhoto->bindValue("name", $description, \PDO::PARAM_STR);
        $userPhoto->bindValue("path_image", $targetFile, \PDO::PARAM_STR);
        $userPhoto->bindValue("date_upload", date("Y-m-d"));
        $userPhoto->bindValue("valid", 0, \PDO::PARAM_INT);
        $userPhoto->execute();
        $_SESSION["lastInsertID"]=$this->pdo->lastInsertId();
    }
}
