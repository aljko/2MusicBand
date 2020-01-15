<?php

    namespace App\lib;

class VariablesList
{
    private $concertKey;
    private $clipKey;
    private $photoKey;
    private $galleryKey;

    public function __construct($concertKey, $clipKey, $photoKey, $galleryKey)
    {
        $this->concertKey=$concertKey;
        $this->clipKey=$clipKey;
        $this->photoKey=$photoKey;
        $this->galleryKey=$galleryKey;
    }
}
