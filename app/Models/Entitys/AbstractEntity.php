<?php

namespace App\Models\Entitys;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

abstract class AbstractEntity
{
    /**
     * @param Collection $list
     * @return bool
     */
    protected function hasItens(Collection $list): bool
    {
        $criteria = Criteria::create();
        $criteria->setMaxResults(1);

        return (count($list->matching($criteria)) > 0);
    }
}    