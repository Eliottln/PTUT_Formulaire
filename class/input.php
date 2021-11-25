<?php
class Input{
    
    private $type;
    private $name;
    private $subInput;
    private $value;

    //CONSTRUCTOR
    function __construct($type = "text",$name = "New Title",$value = null){
        $this->type = $type;
        $this->name = $name;

        if($this->type == "select"){
            $this->subInput = array();
        }
        if($this->type == "radio" || $this->type == "checkbox"){
            $this->value = array();
            array_push($this->value, $value);
        }
    }

    function optionConstructor($value){
        $newOption = new Input("option",null);
        $newOption->value = $value;
        return $newOption;
    }

    //SET
    public function set_name($name) {
        $this->name = $name;
    }

    public function set_type($type) {
        $this->type = $type;
    }

    //GET
    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getSubInput() {
        return $this->subInput;
    }

    public function getValue() {
        return $this->value;
    }

    //FUNCTION
    public function addOption($value = "0") {
        if($this->type == "select"){
            array_push($this->subInput, $this->optionConstructor($value));
        }
    }

    public function addValue($value) {
        if($this->type == "radio" || $this->type == "checkbox"){
            array_push($this->value, $value);
        }
    }
    
}