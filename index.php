<?php
/*
$subtpl1 = new Template('view/templates/sub_1.phtml',
                        array('content' => '<b>Subplantilla 111</b>'));

$subtpl2 = new Template('view/templates/sub_2.phtml',
                        array('content' => '<b>Subplantilla 222</b>'));

$tpl = new Template('view/templates/body.phtml',
                    array('content' => '<b>Plantilla Body</b>'));
$tpl->setChildViews(array('st1' => $subtpl1, 'st2' => $subtpl2));
$tpl_html = $tpl->render();
//$tpl->showHtml();


$layout = new Layout('view/layouts/main.phtml', array('title' => 'Titulo Pagina'), array('body' => $tpl));
//$layout->setParams(array('title' => 'Titulo Pagina', 'body' => $tpl_html));
$html = $layout->render();
$layout->showHtml();
//$tpl->showChildViews();

echo $html;*/


//BOOTSTRAP

//Basic paths
define('APP_PATH', getcwd().DIRECTORY_SEPARATOR);
define('CONF_PATH', APP_PATH.'conf'.DIRECTORY_SEPARATOR);

require_once('includes/init.php');

            //Debug request params
            //d::setEnabled(true);
            //d::gs('Initial Request');
            //d::fp($_GET, 'Request GET');
            //d::fp($_POST, 'Request POST');

//Run Application
d::fp(null, 'Executing app', 'i');
d::ge();
$app = new Application($conf, $_GET, $_POST);
$app->execute();

?>