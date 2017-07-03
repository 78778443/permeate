<?php

class user
{
    function __construct(){

    }

    public function lists()
    {
        displayTpl('user/lists',['a'=>123]);
    }
}

