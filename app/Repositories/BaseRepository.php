<?php

namespace App\Repositories;

use App\Services\TenantService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{

    protected $model;

    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
        $this->setModel();
    }

    abstract protected function setModel(): void;

    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }


    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->find($id);

        if (!$record) {
            return false;
        }

        return $record->update($data);
    }

    public function delete(int $id)
    {
        $record = $this->find($id);

        if (!$record) {
            return false;
        }

        return $record->delete();
    }

    public function beginTransaction()
    {
        DB::connection('tenant')->beginTransaction();
    }

    public function commit()
    {
        DB::connection('tenant')->commit();
    }

    public function rollback()
    {
        DB::connection('tenant')->rollBack();
    }
}
