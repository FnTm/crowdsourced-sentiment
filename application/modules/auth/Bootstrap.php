<?php
class Auth_Bootstrap extends Zend_Application_Module_Bootstrap
{


    protected function _initAutoload()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => 'Auth_',
                    'basePath' => APPLICATION_PATH . '/modules/auth'));

        $moduleLoader->addResourceType('controllerhelper',
            'controllers/helpers', 'Controller_Helper');

        return $moduleLoader;
    }

}

