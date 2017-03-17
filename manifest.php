<?php
/**  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2017 (original work) Breakthrough Technologies;
 *               
 * 
 */

/**
 * Generated using taoDevTools 2.15.0
 */
return array(
    'name' => 'taoNeo4J',
    'label' => 'TAO Neo4J Driver',
    'description' => '',
    'license' => 'GPL-2.0',
    'version' => '0.0.1',
    'author' => 'Breakthrough Technologies',
    'requires' => array(
        'tao' => '>=2.15.6'
    ),
    'managementRole' => 'http://www.tao.lu/Ontologies/generis.rdf#taoNeo4JManager',
    'acl' => array(
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#taoNeo4JManager', array('ext'=>'taoNeo4J')),
    ),
    'install' => array(
        'php' => dirname(__FILE__) . '/scripts/install.php',
    ),
    'uninstall' => array(
    ),
    'routes' => array(
        '/taoNeo4J' => 'bt\\taoNeo4J\\controller'
    ),    
    'constants' => array(
        # views directory
        "DIR_VIEWS" => dirname(__FILE__).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR,
        
        #BASE URL (usually the domain root)
        'BASE_URL' => ROOT_URL.'taoNeo4J/',
        
        #BASE WWW required by JS
        'BASE_WWW' => ROOT_URL.'taoNeo4J/views/'
    ),
    'extra' => array(
        'structures' => dirname(__FILE__).DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'structures.xml',
    )
);