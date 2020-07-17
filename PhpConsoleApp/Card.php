<?php

namespace Model;

class Card {


    /**
    *This is the from 
    *
    * @var(string)
    */
    private $from;
    
    /**
    *This is the destination 
    *
    * @var(string)
    */
    private $to;

    /**
    *This is vehicle's type
    *
    * @var(string)
    */
    private $vehicleType;

    /**
    *This is details of vehicle
    *
    * @var(string)
    */
    private $vehicleDetail;

    /**
    *This is key of vehicle
    *
    * @var(string)
    */
    private $vehicleKey;

    /**
    *This is confirmation of bags presence of card
    *
    * @var(bool)
    */
    private $hasBags;
    
    /**
    *This is the seat in vehicle
    *
    * @var(string)
    */
    private $seat;

    /**
    *This is bagage description
    *
    * @var(string)
    */
    private $bagageDescription;
    
    /**
     * Constructor
     * 
     * @param string $from
     * @param string $to
     * @param string $vehicleKey
     * @param string $vehicleType
     * @param string $vehicleDetail
     * @param bool $hasBags
     * @param string $seat
     * @param string $bagageDescription
     */
    public function __construct($from, $to, $vehicleKey, $vehicleDetail, $vehicleType, $hasBags, $seat, $bagageDescription )
    {
        $this->from = $from;
        $this->to = $to;
        $this->hasBags = $hasBags;
        $this->seat = $seat;
        $this->vehicleKey = $vehicleKey;
        $this->vehicleDetail = $vehicleDetail;
        $this->vehicleType = $vehicleType;
        $this->bagageDescription = $bagageDescription;
    }

    /**
    *This is bagage description
    *
    * @return string
    */
    public function vehicleKey(){
        return $this->vehicleKey;
    }

    /**
     * Get mthod for vehicleType
     * 
     * @return string
     */
    public function vehicleType(){
        return $this->vehicleType;
    }

    /**
     * Get method for vehicle details
     * 
     * @return string
     */
    public function vehicleDetail(){
        return $this->vehicleDetail;
    }

    /**
     * Get method for from
     * 
     * @return string
     */
    public function getFrom(){
        return $this->from;
    }

    /**
     * Get method for to (destination)
     * 
     * @return string 
     */
    public function getTo(){
        return $this->to;
    }

    /**
     * Get method for $hasBags
     * 
     * @return bool
     */
    public function getHasBags()
    {
        return $this->hasBags;
    }

    /**
     * Get method for seat
     * 
     * @return string
     */
    public function getSeat(){
        return $this->seat;
    }

    /**
     * Get method for bagage description
     * 
     * @return string
     */
    public function getBagageDescription (){
        return $this->bagageDescription;
    }

    /**
     * toString method
     * 
     * @return string
     */
    public function __toString()
    {
        $seat = $this->seat === "none"?"No seat assignment":"Sit in seat $this->seat .";
        $bagDetail = $this->hasBags ? $this->bagageDescription : "";
        return "\n Take $this->vehicleType $this->vehicleKey from $this->from to $this->to .$seat $bagDetail";
    }

}