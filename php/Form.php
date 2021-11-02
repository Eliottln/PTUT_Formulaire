<?php

class Form
{

    public function __construct()
    {
        $this->printForm();
    }

    function printForm(){
        echo '<textarea class="question" type="text" name="question" placeholder="Question" required></textarea>';
    }
}

$formulaire=new Form();