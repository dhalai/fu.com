<?php

/**
 * Abstract controller
 *
 */

Class ControllerAbstract {

    protected $template;

    public function __construct()
    {
        $this->template = 'layout';
    }

}
?>
