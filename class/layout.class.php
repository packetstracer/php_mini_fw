<?php

/**
 * Description of Layout
 *
 * @author imerin
 */

class Layout extends View 
{

    protected function parse()
    {
        //extract params
        extract(parent::getParams());

        //render and extract child templates
        extract(parent::parseChildViews());

        //get & parse template
        ob_start();
        eval('?>'. file_get_contents(parent::getPath()));
        parent::setHtml(ob_get_contents());
        ob_end_clean();
    }

}

?>