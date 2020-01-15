<?php namespace App\Controller\Map;

use App\Controller\AbstractController;
use App\Model\Element\ConcertsManager;
use DateTime;

class MapController extends AbstractController
{
    public function map($concerts)
    {
        // NOTE Prepare green marker link
        $greenIcon = 'https://maps.google.com/mapfiles/marker_green.png';
        // NOTE Init new list
        $listConcerts = [];
        // NOTE For each concert
        foreach ($concerts as $con) {
            // NOTE Check date
            $green = false;
            if (new DateTime() <= new DateTime($con['date_concert'])) {
                $green = true;
            }
            // NOTE Add formated address to list
            $listConcerts[] = [
                'address' => $con['zipcode'] .' '. $con['ville'] .' '. $con['addresse'] . ', France',
                'icon'    => $green ? $greenIcon : ''
            ];
        }
        // NOTE Convert list into JSON string
        return json_encode($listConcerts);
    }
}
