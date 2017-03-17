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

namespace bt\taoNeo4J\controller;

use bt\Proxy\ExtensionsManager;
use bt\taoNeo4J\Neo4JQueryRunner as QueryRunner;
use GraphAware\Neo4j\Client\ClientBuilder;

/**
 * Sample controller
 *
 * @author Breakthrough Technologies
 * @package taoNeo4J
 * @license GPL-2.0
 *
 */
class TaoNeo4J extends \tao_actions_CommonModule {

    protected $client;

    /**
     * initialize the services
     */
    public function __construct(){
        parent::__construct();

        $ext = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoNeo4J');
        $username = $ext->getConfig('default')['username'];
        $password = $ext->getConfig('default')['password'];
        $host = $ext->getConfig('default')['host'];
        $port = $ext->getConfig('default')['port'];

        $this->client = ClientBuilder::create()
            ->addConnection('tao', "http://$username:$password@$host")
            ->build();
    }

    public function insert() {
        //QueryRunner::insertRecord($this->client, '', '', '', '', '', '', '');
        //return $this->client->run('CREATE (n:Person) SET n += {infos}', ['infos' => ['name' => 'Ales', 'age' => 34]]);
    }

    public function templateExample() {
        $this->setData('author', 'Breakthrough Technologies');
        $this->setView('TaoNeo4J/templateExample.tpl');
    }
}