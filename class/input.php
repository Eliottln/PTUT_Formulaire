<?php
class Input{
    private $name;
    private $type;
    private $subInput;

    function __construct($type = "text",$name = "New Title"){
        $this->type = $type;
        $this->name = $name;

        if($this->type == "select"){
            $this->subInput = array();
        }
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

    //FUNCTION
    public function addInput($type = "text") {
        array_push($this->subInput, new Input($type));
    }
    
}