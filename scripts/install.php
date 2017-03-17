<?php

require_once dirname(__FILE__) . '/../../tao/includes/raw_start.php';

// copy extension configuration file
$extension = common_ext_ExtensionsManager::singleton()->getExtensionById('taoNeo4J');
$newConfig = dirname($extension->getDir()) . '/config/taoNeo4J/default.conf.php';
$directory = dirname($newConfig);

// Create the bare directory before trying to write to it.
if(!file_exists($directory)) {
    mkdir($directory);
}

// Copy the sample config to the new config.
$extensionConfigWriter = new tao_install_utils_ConfigWriter(
    $extension->getDir() . 'includes/sample.conf.php',
    $newConfig
);
$extensionConfigWriter->createConfig();