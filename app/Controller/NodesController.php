<?php

class NodesController extends AppController {

    var $uses = 'Nodes';

    function texto() {
        $this->layout = "textoopen";

        $this->set('puntos', $this->Nodes->find('all'));
        $this->pageTitle = "Puntos";
    }

}