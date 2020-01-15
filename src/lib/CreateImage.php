<?php

    namespace App\lib;

    use App\Model\Users\UsersManager;

class CreateImage
{
    private $errors;
    private $targetDir;
    private $targetFile;
    private $imageFileType;
    private $description;
        
    private $file;

    public function __construct(array $file, string $description)
    {
        $this->targetDir= "../public/assets/photos/upload/";
        $this->targetFile= $this->targetDir . basename($file["fileToUpload"]["name"]);
        $this->imageFileType= strtolower(pathinfo($this->targetFile, PATHINFO_EXTENSION));
        $this->file=$file;
        $this->description=$description;
    }
        


    
    public function doCreateImage()
    {
        $this->doCheckIsImage();
        $this->doCheckIsExist($this->targetFile);
        $this->doCheckIsToBig();
        $this->doCheckIsFileImage($this->imageFileType);

        // Check if $uploadOk is set to 0 by an error
        if (empty($this->errors)) {
            if (move_uploaded_file($this->file["fileToUpload"]["tmp_name"], $this->targetFile)) {
                $_SESSION["uploadImageOk"] = "The file "
                .basename($_FILES["fileToUpload"]["name"])
                ." has been uploaded.";
                $userManager = new UsersManager();
                $userManager->insertUserImage($this->targetFile, $this->description);
                unset($_SESSION["userId"]);
                unset($_SESSION["error"]);
                header("Location: /");
            }
        } else {
            var_dump($this->errors);
            $this->errors[] = "Sorry, your file was not uploaded.";
            $_SESSION["error"] = "Sorry, there was an error uploading your file.";
            header("Location: /Users/uploadUserImage");
        }
    }

    //############################# CHECK IMAGE #######################


    public function doCheckIsImage()
    {
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($this->file["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $_SESSION["upload_image"] = "File is an image - " . $check["mime"] . ".";
            } else {
                $this->errors[] = "File is not an image.";
                $_SESSION["uploadIsNotImage"] = "File is not an image like jpg.";
            }
        }
    }

    public function doCheckIsExist($targetFile)
    {
        // Check if file already exists
        if (file_exists($targetFile)) {
            $this->errors[] = "Sorry, filename already exists.";
            $_SESSION["uploadAlredyExist"] = "Sorry, file already exists.";
        }
    }

    public function doCheckIsToBig()
    {
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 1500000) {
            $this->errors[] = "Sorry, your file is too large. file<1,5Mb !";
            $_SESSION["uploadIsToBig"] = "Sorry, your file is too large. file<1,5Mb !";
        }
    }

    public function doCheckIsFileImage($imageFileType)
    {
        // Allow certain file formats

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
        ) {
            $this->errors[] = "jpg png gif only.";
            $_SESSION["uploadTypBad"] = "jpg png gif only.";
        }
    }
}
