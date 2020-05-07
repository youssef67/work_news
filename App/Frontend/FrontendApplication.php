<?php
namespace App\Frontend;

use OCFram\Application;

class FrontEndApplication extends Application
{
    public function __construct()
    {
        parent::__construct();

        $this->name = 'FrontEnd';
    }

    public function run()
    {
        $controller = $this->getController();
        $controller->execute();

        $this->httpResponse->setPage($controller->page());
        $this->httpResponse->send();
    }
}

?>