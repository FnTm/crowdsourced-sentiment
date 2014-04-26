<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


    protected function _initDoctype()
    {
        $doctypeHelper = new Zend_View_Helper_Doctype();
        $doctypeHelper->doctype('XHTML1_STRICT');
    }

    protected function _initTitle()
    {
        $view = new Zend_View($this->getOptions());
        $view->headTitle('Multilingual sentiment analysis');
    }

    protected function _initDefaultHelpers()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->addHelperPath( APPLICATION_PATH . '/modules/default/views/helpers', 'Default_View_Helper');
    }


    protected function _initConfig()
    {
        # get config
        $config = new Zend_Config_Ini(APPLICATION_PATH .
                DIRECTORY_SEPARATOR . 'configs' .
                DIRECTORY_SEPARATOR . 'application.ini', APPLICATION_ENV);

        # get registery
        $this->_registry = Zend_Registry::getInstance();

        # save new database adapter to registry
        $this->_registry->config              = new stdClass();
        $this->_registry->config->application = $config;
    }


    protected function _initDb()
    {
        $resource = $this->getPluginResource('multidb');
        Zend_Registry::set("multidb", $resource);
    }

    protected function _initLoggers()
    {
        $loggers = array('access', 'database', 'import',);
        Zend_Registry::set('loggers', $loggers);
        $logFormat = date('r') . ', "%message%" (%priorityName%)' . PHP_EOL;
        $simpleFormatter = new Zend_Log_Formatter_Simple($logFormat);
        foreach ($loggers as $aLogger) {
            $loglevel = 'DEBUG';
            $class = new ReflectionClass('Zend_Log');
            $priorities = array_flip($class->getConstants());
            $loglevel = array_search($loglevel, $priorities);
            $fileFilter = new Zend_Log_Filter_Priority($loglevel, '<=');
            $fileWriter = new Zend_Log_Writer_Stream(
                APP_LOG_PATH . '/' . $aLogger . '.log');

            $fileWriter->setFormatter($simpleFormatter);
            $fileWriter->addFilter($fileFilter);
            $logger = new Zend_Log();

            $logger->addWriter($fileWriter);
            Zend_Registry::set('log' . ucfirst($aLogger), $logger);
        }
    }



}
