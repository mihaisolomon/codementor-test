<?php


namespace App\Services;

use App\Repository\BaseRepositoryInterface;

class BaseService
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Calls the repository to retrieve a list with all the items
     * @param array $orderByColumns
     * @return mixed
     */
    public function index(array $orderByColumns = [])
    {
        return $this->repository->index($orderByColumns);
    }

    /**
     * Calls the repository to retrieve a paginated list
     * @param $perPage
     * @param $page
     * @param array $orderByColumns
     * @return Factory|View
     */
    public function indexPaginated($perPage, $page, array $orderByColumns = [])
    {
        return $this->repository->indexPaginated($perPage, $page, $orderByColumns);
    }

    /**
     * Calls the repository to store a new record
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    /**
     * Calls the repository to update a record
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id) {
        return $this->repository->update($data, $id);
    }

    /**
     * Calls the repository to delete a record
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id) {
        return $this->repository->destroy($id);
    }

    /**
     * Calls the repository to retrieve a certain record
     * @param $id
     * @return JsonResponse
     */
    public function show($id) {
        return $this->repository->show($id);
    }
}
