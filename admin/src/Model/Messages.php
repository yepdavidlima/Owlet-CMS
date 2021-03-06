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
namespace Model;

use \Lib\Data;

/**
 * Manage contact messages
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @version r1.0
 * @license Apache 2.0
 */
class Messages extends Base
{

    /**
     * Table to save data
     */
    const TABLE = "messages";

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "name" => null,
        "email" => null,
        "phone" => null,
        "subject" => null,
        "body" => null,
        "isread" => null
    );

    /**
     * Extension of the Save method
     *
     * @see \Model\Base::Save()
     */
    public function Save()
    {
        $required = array(
            "name" => "Nome",
            "body" => "Mensagem"
        );
        $this->validateData($required);
        parent::Save();
    }

    /**
     * Return the number of unread messages
     *
     * @return number
     */
    public function countUnread()
    {
        return count($this->getByColumn("isread", 0));
    }

    /**
     * Check if a message is read
     *
     * @return boolean
     */
    public function isRead()
    {
        return $this->getIsRead();
    }

    /**
     * Extension of the __set method
     *
     * @see \Model\Base::__set()
     */
    public function __set($key, $value)
    {
        if ($key == "body" || $key == "subject") {
            $value = strip_tags($value);
        }
        if ($key == "subject" && ! $value) {
            $value = "Mensagem enviada através do formulário de contato";
        }
        parent::__set($key, $value);
    }
}