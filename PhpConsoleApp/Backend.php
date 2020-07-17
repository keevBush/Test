<?php
namespace Data;
include_once("Card.php");

use Exception;
use Model\Card;


class Backend {

    /**
    * Static method for read data on json file
    *
    * @return array
    */
    public static function readData() :array {

        if(file_exists("data/data.json")){
            $data = file_get_contents("data/data.json");
            $tab = json_decode($data, true);
            $array = [];
            foreach($tab as $t){
                $card = new Card($t['from'], $t['to'],$t['vehicle_key'],$t['vehicle_Detail'],$t['vehicle'],$t['bagage_description']=="none"?FALSE: TRUE,$t['seat'],$t['bagage_description']);
                array_push($array, $card);
            }
            return $array;
        }else
        {
            echo "File doesn't exist";
            return [];
        }
         
    }
    /**
     * Static method for first sorting : Set to first index (0) one Trip(card)
     * 
     * @param array $array
     * @param Card $value
     * 
     * @return array
     */
    public static function GoToFirst(array $array , Card $value) : array{
        if(!in_array($value, $array))
            throw new Exception("Trip not found");
        $array = array_diff($array , [$value]);
        $finalArray = array();
        array_push($finalArray, $value);
        array_push($finalArray, ...$array);
        return $finalArray;
    }

    /**
     * Static method for get first trip with destination
     * 
     * @param string $destination
     * 
     * @return Card
     */
    public static function GetFirstTripByDestination(string $destination){
        $allTrips = Backend::readData();
        foreach($allTrips as $trip){
            if($trip->getTo() === $destination){
                return $trip;
            }
        }
        return NULL;
    }

    /**
     * Static method for get trip with $from
     * 
     * @return Card
     */
    public static function GetFirstTripByFrom(string $from){
        $allTrips = Backend::readData();
        foreach($allTrips as $trip){
            if($trip->getFrom() === $from){
                return $trip;
            }
        }
        return NULL;
    }

    /**
     * Static method for search route
     * 
     * @param string $from 
     * @param string $to
     * 
     * @return array 
     */
    public static function SearchGoodRoute($from, $to): array{
        try {
            //Get all trip
            $allTraject = Backend::readData();
            
            //Get one trip having this from
            $trajectFrom = reset(array_filter($allTraject , function($c) use($from){
                return $c->getFrom() === $from;
            }));
            
            //Get one trip having this destination
            $trajectTo =  reset(array_filter($allTraject , function($c) use($to){
                return $c->getTo() === $to;
            }));
            
            
            //Check if(one of theses trips exists)
            if($trajectFrom === false || $trajectTo === false){
                throw new Exception("We don't know any way to go from $from to $to. ");
            }

            //Set to first index trip(from and destination)
            $trajectsForFrom = Backend::GoToFirst($allTraject, $trajectFrom);
            $trajectsForTo = Backend::GoToFirst($allTraject, $trajectTo);
    
            //All trip have source from
            $fileOne = [];
            //All trip have source destination
            $fileTwo = [];
            
            //Save initial from and destination
            $to1 = $to;
            $from1 = $from;
            
            //Set all trip have $from for source (Like tree search algorithme)
            foreach($trajectsForFrom as $card){
                //Check if we have a direct trip
                if($card->getTo() == $to1 && $card->getFrom() == $from1){
                    return [$card];
                }
            }

            for($i=0; $i<count ($trajectsForFrom); $i++){
                
                if($trajectsForFrom[$i]->getFrom() == $from){
                    $fileTemp = array_filter($trajectsForFrom, function($c) use($from) {
                        return $c->getFrom() === $from;
                    });
                    array_push($fileOne, ...$fileTemp);
                    $from = $trajectsForFrom[$i]->getTo();
                    array_splice($trajectsForFrom, $i,1);
                    if(Backend::GetFirstTripByFrom($from) == NULL){
                        continue;
                    }
                    $trajectsForFrom[$i] =  Backend::GetFirstTripByFrom($from);
                    $i--;
                }

            }

            //Set all trip have $to for destination (Like tree search algorithme by end)
            for($i=0; $i<count ($trajectsForTo); $i++){
                
                if($trajectsForTo[$i]->getTo() == $to){
                    $fileTemp2 = array_filter($trajectsForTo, function($c) use($to) {
                        return $c->getTo() === $to;
                    });
                    array_push($fileTwo, ...$fileTemp2);
                    $to = $trajectsForTo[$i]->getFrom();
                    array_splice($trajectsForTo, $i,1);
                    if(Backend::GetFirstTripByDestination($to) == NULL){
                        continue;
                    }
                    $trajectsForTo[$i] =  Backend::GetFirstTripByDestination($to);
                    $i--;
                }
            }
            //Intersection is way to get
            $sameTraject = array_intersect($fileOne,$fileTwo);
            
            //Get first node(trip) for travel
            $firstTraject = reset (array_filter($allTraject, function($c) use($sameTraject, $from1){
                foreach($sameTraject as $traject){
                    if($c->getFrom() == $from1 && $c->getTo() == $traject->getFrom())
                    {
                        return true;
                    }
                }
                return false;
            }));
            $intersect = [];
            if($firstTraject === false){
                throw new Exception("\n====================We don't know any way to go from $from1 to $to1 =====================\n");
            }
            array_push ($intersect, $firstTraject);
            array_push ($intersect, ...array_intersect($fileOne,$fileTwo)); 
            return array_unique ($intersect);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo "\n ====================== $message ===================== ";
            return [];
        }
    }

    
}