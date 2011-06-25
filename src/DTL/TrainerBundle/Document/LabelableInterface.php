<?php

namespace DTL\TrainerBundle\Document;

interface LabelableInterface
{
    public function getLabels();

    public function setLabels(array $labels = array());
}
