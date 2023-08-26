<?php

namespace App\Models\Service;

use App\Models\Repository\AnnotationRepository;
use Doctrine\ORM\EntityManager;

class AnnotationService extends AbstractService
{
    public function __construct(?EntityManager $em = null)
    {
        parent::__construct(AnnotationRepository::class, $em);
    }
}