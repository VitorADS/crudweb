<?php

namespace Config\EntityManager;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

class EntityManagerCreator{
    public static function getEntityManager(): EntityManager
    {
        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__."/../../app/Models/Entitys"],
            isDevMode: true,
            proxyDir: __DIR__ . '/../../Data/Proxies'
        );
        // or if you prefer annotation, YAML or XML
        // $config = ORMSetup::createAnnotationMetadataConfiguration(
        //    paths: array(__DIR__."/src"),
        //    isDevMode: true,
        // );
        // $config = ORMSetup::createXMLMetadataConfiguration(
        //    paths: array(__DIR__."/config/xml"),
        //    isDevMode: true,
        //);
        // $config = ORMSetup::createYAMLMetadataConfiguration(
        //    paths: array(__DIR__."/config/yaml"),
        //    isDevMode: true,
        // );

        // configuring the database connection
        $connection = DriverManager::getConnection([
            'dbname' => 'crudweb',
            'user' => 'postgres',
            'password' => '1234',
            'host' => 'localhost',
            'driver' => 'pdo_pgsql'
        ], $config);

        // obtaining the entity manager
        return new EntityManager($connection, $config);
    }
}