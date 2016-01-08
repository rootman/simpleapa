<?php

namespace Rootman\Simpleapa;

use ApaiIO\Operations\Lookup;
use ApaiIO\ApaiIO;
use Config;

/**
 * Class SimpleAPA
 * @package Rootman\Simpleapa
 */
class SimpleAPA
{

    /**
     * @var ApaiIO
     */
    private $apaiIO;

    /**
     * @param ApaiIO $apaIO
     */
    public function __construct(ApaiIO $apaIO)
    {
        $this->apaiIO = $apaIO;
    }

    /**
     * @param $asin
     * @return mixed
     * @throws \Exception
     */
    public function offers($asin)
    {
        $response = $this->runLookup($asin);

        return isset($response['Items']['Item']['Offers']) ? $response['Items']['Item']['Offers'] : null;
    }

    /**
     * @param $asin
     * @return float
     * @throws \Exception
     */
    public function bestPrice($asin)
    {
        $response = $this->runLookup($asin);

        return isset($response['Items']['Item']['OfferSummary']['LowestNewPrice']['Amount']) ? $response['Items']['Item']['OfferSummary']['LowestNewPrice']['Amount']/100 : null;
    }

    /**
     * @param $asin
     * @return mixed
     * @throws \Exception
     */
    protected function runLookup($asin)
    {
        $lookup = new Lookup();
        $lookup->setItemId($asin);
        $lookup->setResponseGroup(array('OfferSummary'));

        return $this->apaiIO->runOperation($lookup);
    }
    /**
     * @param $asin
     * @return mixed
     * @throws \Exception
     */
    protected function runImageLookup($asin)
    {
        $lookup = new Lookup();
        $lookup->setItemId($asin);
        $lookup->setResponseGroup(array('Images'));
        return $this->apaiIO->runOperation($lookup);
    }

    /**
     * @param $asin
     * @return null
     */
    public function allImages($asin)
    {
        $response = $this->runImageLookup($asin);
        return isset($response['Items']['Item']['ImageSets']['ImageSet']) ? $response['Items']['Item']['ImageSets']['ImageSet'] : null;
    }

}