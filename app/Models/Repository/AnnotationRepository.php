<?php

namespace App\Models\Repository;

use App\Models\Entitys\Annotation;
use App\Models\Repository\AbstractRepository;
use Doctrine\ORM\EntityManager;

class AnnotationRepository extends AbstractRepository
{
    public function __construct(?EntityManager $em = null)
    {
        parent::__construct(Annotation::class, $em);
    }
}