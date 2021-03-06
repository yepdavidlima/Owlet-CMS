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
 * Generate and retrieve PagSeguro orders
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model\PagSeguro
 * @uses \Lib\Data
 * @version r1.0
 * @license Apache 2.0
 */
class PagSeguroOrder extends \Model\Base
{

    /**
     * Table to save data
     */
    const TABLE = "pagseguroorders";

    /**
     * Directory of the PagSeguroLibrary.php file
     */
    const PAGSEGURO_LIBRARY_DIR = "../../Extensions/PagSeguroLibrary";

    /**
     * Possible properties
     *
     * @var array
     */
    public $properties = array(
        "reference" => null,
        "items" => null,
        "customer" => null
    );

    /**
     * PagSeguro's statuses dictionary
     *
     * @var array
     */
    public $transactionStatuses = array(
        1 => "Aguardando Pagamento",
        2 => "Em Análise",
        3 => "Pago",
        4 => "Pago",
        5 => "Em disputa",
        6 => "Devolvido",
        7 => "Cancelado"
    );

    /**
     * \PagSeguroLibrary instance
     *
     * @staticvar \PagSeguroLibrary
     */
    public static $pagseguro;

    /**
     * PagSeguroConfig instance
     *
     * @staticvar PagSeguroConfig
     */
    public static $pagseguroconfig;

    /**
     * \PagSeguroAccountCredentials instance
     *
     * @staticvar \PagSeguroAccountCredentials
     */
    public static $credentials;

    /**
     * Requires the PagSeguroLibrary.php file and hidrate all variables
     */
    public function __construct()
    {
        require_once (__DIR__ . "/" . self::PAGSEGURO_LIBRARY_DIR . "/PagSeguroLibrary.php");
        self::$pagseguro = \PagSeguroLibrary::init();
        self::$pagseguroconfig = new PagSeguroConfig();
        self::$pagseguroconfig = self::$pagseguroconfig->getById(1);
        self::$credentials = new \PagSeguroAccountCredentials(self::$pagseguroconfig->getEmail(), self::$pagseguroconfig->getToken());
    }

    /**
     * Return a link to user make the payment
     *
     * @return Ambigous <string, boolean, mixed>
     */
    public function getPaymentLink()
    {
        $paymentRequest = new \PagSeguroPaymentRequest();
        
        $this->setOrderReference(\Extensions\Strings::randomString(32));
        
        $paymentRequest->setSender($this->getCustomer()
            ->getName(), $this->getCustomer()
            ->getEmail(), $this->getCustomer()
            ->getAreaCode(), $this->getCustomer()
            ->getPhone());
        $paymentRequest->setShippingAddress($this->getCustomer()
            ->getCEP(), $this->getCustomer()
            ->getAddress(), $this->getCustomer()
            ->getNumber(), $this->getCustomer()
            ->getAddressComplement(), $this->getCustomer()
            ->getNeighborhood(), $this->getCustomer()
            ->getCity(), $this->getCustomer()
            ->getState(), $this->getCustomer()
            ->getCountry());
        $paymentRequest->setCurrency("BRL");
        $paymentRequest->setShippingType(3);
        $paymentRequest->setReference($this->getOrderReference());
        foreach ($this->getItems() as $item) {
            $paymentRequest->addItem($item['id'], $item['title'], $item['quantity'], $item['value']);
        }
        return $paymentRequest->register(self::$credentials);
    }
}