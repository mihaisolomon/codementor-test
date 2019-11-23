<?php


namespace App\Services;

use Illuminate\Http\JsonResponse;

interface BaseServiceInterface
{

    /**
     * Calls the repository to retrieve a list with all the items
     * @param array $orderByColumns
     * @return mixed
     */
    public function index(array $orderByColumns = []);

    /**
     * Calls the repository to retrieve a paginated list
     * @param $perPage
     * @param $page
     * @param array $orderByColumns
     * @return Factory|View
     */
    public function indexPaginated($perPage, $page, array $orderByColumns = []);

    /**
     * Calls the repository to store a new record
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * Calls the repository to update a record
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Calls the repository to delete a record
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id);

    /**
     * Calls the repository to retrieve a certain record
     * @param $id
     * @return JsonResponse
     */
    public function show($id);
}
