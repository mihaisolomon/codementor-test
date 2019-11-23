<?php
/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 27/04/2019
 * Time: 10:18
 */

namespace App\Repository;


interface BaseRepositoryInterface
{
    public function create(array $attributes);

    public function store(array $attributes);

    public function update(array $attributes, $id);

    public function all($columns = array('*'), $orderBy = 'id', $sortBy = 'desc');

    public function find($id);

    public function findOneOrFail($id);

    public function findBy(array $data);

    public function findOneBy(array $data);

    public function findOneByOrFail(array $data);

    public function paginateArrayResults(array $data, $perPage = 50);

    public function delete($id);
}
