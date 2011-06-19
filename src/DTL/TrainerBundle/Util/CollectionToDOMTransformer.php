<?php

namespace DTL\TrainerBundle\Util;
use Doctrine\ODM\MongoDB\DocumentManager;
use \DOMDocument;
use \DOMXPath;

class CollectionToDOMTransformer
{
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function toDOM($collection)
    {
        $dom = new DOMDocument("1.0")
    }
}
