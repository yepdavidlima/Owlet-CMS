<?php
/**
 ************************************************************************
Copyright [2014] [David Lima]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
************************************************************************
*/
namespace Model\PagSeguro;

use \Lib\Data;

/**
 * Manage the PagSeguro's configurations
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model\PagSeguro
 * @uses \Lib\Data
 * @version r1.0
 * @license Apache 2.0
 */
class PagSeguroConfig extends \Model\Base
{

    /**
     * Table to save data
     */
    const TABLE = "pagseguroconfig";

    /**
     * Properties to save on database (DataMapper)
     *
     * @var array
     */
    public $properties = array(
        "email" => null,
        "token" => null,
        "title" => null
    );

    /**
     * Extension of the Save method
     *
     * @see \Model\Base::Save()
     */
    public function Save()
    {
        $required = array(
            "email" => "E-mail",
            "token" => "Token"
        );
        $this->validateData($required);
        parent::Save();
    }
}