<?php


namespace App\Controller\Capture;

use App\Controller\AbstractController;
use App\Model\Element\CaptureManager;

class CaptureController extends AbstractController
{
    public function count()
    {
        $captureManager = new CaptureManager();
        $captureChanteur=$captureManager->selectCaptureChanteur(1);
        echo $captureChanteur;




                $captureManager->updateCaptureChanteurs((int)$_POST['chanteur'], 1);
                header("location: /");
    }
}
