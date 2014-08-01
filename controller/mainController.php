<?php

class mainController extends Controller
{

    public function indexAction()
    {   
        //echo $this->view->render();
        echo $this->view->render('content', array(
            'param1'    => 'valor_del_param1',
            'param2'    => 'valor_del_param2'
        ));

//d::fp($this->model->getArrayContent(), 'modelo dentro del controlador');
d::fp($this->model->getCentros(), 'valor del getCentros');
d::fp($this->model->getCentroById(2), 'valor del centro con id 2');
d::fp($this->model->getCentrosTransaction(), 'valor del getCentrosTransaction');
    }


    public function anotherAction()
    {
        return "this is another action <br/>";
    }

}

?>