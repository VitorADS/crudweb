<?php

require 'vendor/autoload.php';

use Config\EntityManager\EntityManagerCreator;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;

$config = new PhpFile(__DIR__ . '/migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders

$entityManager = EntityManagerCreator::getEntityManager();

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));