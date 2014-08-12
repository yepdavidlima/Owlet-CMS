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
 * Blog module
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model
 * @uses \Lib\Data
 * @version r1.0
 * @license Apache 2.0
 */
class Blog extends Base
{

    /**
     * Table do save data
     */
    const TABLE = "blog";

    /**
     * Available properties
     *
     * @var array
     */
    public $properties = array(
        "title" => null,
        "preview" => null,
        "body" => null,
        "slug" => null,
        "head" => null,
        "tags" => null,
        "category" => null,
        "timestamp" => null
    );

    /**
     * Extension of the Save method
     * 
     * @see \Model\Base::Save()
     */
    public function Save()
    {
        $required = array(
            "title" => "Título",
            "body" => "Conteúdo"
        );
        $this->setSlug(\Extensions\Strings::Slug($this->title));
        $this->validateData($required);
        parent::Save();
    }
}