<?php

// Register simple class autoloader
spl_autoload_register(function($className)
{
    $namespace = str_replace("\\","/",__NAMESPACE__);
    $className = str_replace("\\","/", $className);
    $class = PROJECTROOT . '/classes/' . (empty($namespace) ? '' : $namespace . '/') . "{$className}.php";
    include_once($class);
});