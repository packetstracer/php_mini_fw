<?php

class anotherController extends Controller
{

    public function indexAction()
    {
d::fp($this->getParams());

        return "index Action from another controller <br/>";
    }


    public function anotherAction()
    {
        return "this is another action from another controller <br/>";
    }

}

?>