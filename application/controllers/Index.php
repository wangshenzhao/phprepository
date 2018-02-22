<?php
/**
 * Created by PhpStorm.
 * User: gcl
 * Date: 2015/4/2
 * Time: 17:27
 */

class IndexController extends BaseController {
    public function indexAction() {//默认Action
        $this->redirect("/Account/list");
    }
}
?>