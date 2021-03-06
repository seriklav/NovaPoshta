<?php

namespace Daaner\NovaPoshta\Models;

use Daaner\NovaPoshta\NovaPoshta;
use Daaner\NovaPoshta\Traits\AddressSettlementProperty;
use Daaner\NovaPoshta\Traits\Limit;
use Daaner\NovaPoshta\Traits\WarehousesFilter;

class Address extends NovaPoshta
{
    use Limit, WarehousesFilter, AddressSettlementProperty;

    protected $model = 'Address';
    protected $calledMethod;
    protected $methodProperties = [];

    public function getAreas()
    {
        $this->calledMethod = 'getAreas';
        $this->methodProperties = null;

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string|null $find
     * @param bool|null $string
     * @return array
     */
    public function getCities($find = null, $string = true)
    {
        $this->calledMethod = 'getCities';
        $this->addLimit();
        $this->getPage();

        if ($find) {
            if ($string) {
                $this->methodProperties['FindByString'] = $find;
            } else {
                $this->methodProperties['Ref'] = $find;
            }
        }

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string|null $cityRef
     * @param bool|null $string
     * @return array
     */
    public function getWarehouses($cityRef = null, $string = true)
    {
        $this->calledMethod = 'getWarehouses';
        $this->addLimit();
        $this->getPage();
        $this->getTypeOfWarehouseRef();

        if ($cityRef) {
            if ($string) {
                $this->methodProperties['CityName'] = $cityRef;
            } else {
                $this->methodProperties['CityRef'] = $cityRef;
            }
        }

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string $cityRef
     * @param bool|null $string
     * @return array
     */
    public function getWarehouseTypes($cityRef, $string = true)
    {
        $this->calledMethod = 'getWarehouseTypes';

        if ($string) {
            $this->methodProperties['CityName'] = $cityRef;
        } else {
            $this->methodProperties['CityRef'] = $cityRef;
        }

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string $settlementRef
     * @return array
     */
    public function getWarehouseSettlements($settlementRef)
    {
        $this->calledMethod = 'getWarehouses';
        $this->getTypeOfWarehouseRef();

        $this->methodProperties['SettlementRef'] = $settlementRef;

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string $search
     * @return array
     */
    public function searchSettlements($search)
    {
        $this->calledMethod = 'searchSettlements';
        $this->addLimit();

        $this->methodProperties['CityName'] = $search;

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string $ref
     * @param string $street
     * @return array
     */
    public function searchSettlementStreets($ref, $street)
    {
        $this->calledMethod = 'searchSettlementStreets';
        $this->addLimit();

        $this->methodProperties['SettlementRef'] = $ref;
        $this->methodProperties['StreetName'] = $street;

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string|null $find
     * @return array
     */
    public function getSettlements($find = null)
    {
        $this->calledMethod = 'getSettlements';
        $this->methodProperties = null;

        /**
         * nit:Daan
         * $this->addLimit();.
         *
         * Нужен лимит 150, иначе значение totalCount имеет не верный формат
         * Устанавливаю насильно, возможно позже исправят
         */
        $this->methodProperties['Limit'] = 150;

        $this->getPage();

        //add AddressSettlementProperty
        $this->getAreaRef();
        $this->getRegionRef();
        $this->getWarehouse();
        $this->getRef();

        if ($find) {
            $this->methodProperties['FindByString'] = $find;
        }

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    /**
     * @param string $city
     * @param string|null $find
     * @return array
     */
    public function getStreet($city, $find = null)
    {
        $this->calledMethod = 'getStreet';
        $this->addLimit();
        $this->getPage();

        $this->methodProperties['CityRef'] = $city;
        if ($find) {
            $this->methodProperties['FindByString'] = $find;
        }

        return $this->getResponse($this->model, $this->calledMethod, $this->methodProperties);
    }

    //dev
    //Counterparty API
    public function save()
    {
        $this->calledMethod = 'save';

        return false;
    }

    public function update()
    {
        $this->calledMethod = 'update';

        return false;
    }

    public function delete()
    {
        $this->calledMethod = 'delete';

        return false;
    }
}
