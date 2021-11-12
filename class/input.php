<?php
class Input{
    private $name;
    private $type;

    function __construct(){
        $this->name = "New Title";
        $this->type = "text";
    }

    //SET
    public function set_name($name) {
        $this->name = $name;
    }

    public function set_type($type) {
        $this->type = $type;
    }

    //GET
    public function get_name() {
        return $this->name;
    }
    public function get_type() {
        return $this->type;
    }
}