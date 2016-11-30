<?php

namespace BusuuTest\EntityRepository;

interface RepositoryInterface
{
    /**
     * Return an entity object or null if the id does not exist
     *
     * @param $entityId
     * @return mixed
     */
    public function find($entityId);

    /**
     * Save entity to database
     *
     * @param $entityObject
     * @return mixed
     */
    public function save($entityObject);
}