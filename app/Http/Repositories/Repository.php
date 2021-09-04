<?php
/**
 * Created by PhpStorm.
 * User: Irshad Khan
 * Date: 3/27/2020
 * Time: 9:57 PM
 */

namespace App\Http\Repositories;


class Repository
{

    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database

    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        $record->update($data);
        return $record;
    }

    // update record in the database

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    function deleteAll($ids = array())
    {
        $records = $this->model->find($ids);
        foreach ($records as $record) {
            $record->delete();
        }

    }


    // remove record from the database

    public function show($id)
    {
        if ($id == 0) {
            return $this->model;
        }
        return $this->model = $this->model->findOrFail($id);
    }

    // show the record with the given id

    function find($filters, $with = [])
    {
        if (count($with) == 0) {
            $query = $this->model;
        } else {
            $query = $this->with($with);
        }


        foreach ($filters as $key => $value) {
            $query = $query->where($key, $value);
        }


        return $query->get();
    }

    // Get the associated model

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    // Set the associated model

    function saveOrUpdate($params, $filters)
    {

        $record = $this->first($filters);

        if (is_null($record)) {
            return $this->create($params);
        }
        $record->update($params);
        return $record;
    }

    // Eager load database relationships

    function first($filters)
    {

        $query = $this->model;
        foreach ($filters as $key => $value) {
            $query = $query->where($key, $value);
        }

        return $query->first();
    }

    public function create(array $data)
    {

        return $this->model->create($data);
    }

    function default($params)
    {
        $model = $this->getModel();
        foreach ($params as $key => $value) {
            $model->setAttribute($key, $value);
        }
        return $model;

    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    function applyFilters($filters)
    {
        $query = $this->model;
        foreach ($filters as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query;
    }


}
