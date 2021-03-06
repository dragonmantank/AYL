<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH));
        return $moduleLoader;
    }

    protected function _initFCPlugins()
    {
        $this->bootstrap('frontController');
        $this->bootstrap('RegisterNamespaces');

        $fc = $this->getResource('frontController');

        $fc->registerPlugin(new Tws_Controller_Plugin_ModuleLayout());
        $fc->registerPlugin(new AYL_Controller_Plugin_Auth());

        return $fc;
    }

    protected function _initRegisterNamespaces()
    {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('AYL_');
        $loader->registerNamespace('Tws_');
        $loader->registerNamespace('PhpORM_');
    }
}

