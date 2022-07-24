<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyRepository implements BaseFunctionNameRepository
{
    protected $model;

    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    public function all($request)
    {
        $result = $this->model->when($request->q, function ($query, $q) {
            $query->where('name', 'LIKE', '%'.$q.'%');
            $query->Orwhere('location', 'LIKE', '%'.$q.'%');
        })->orderBy('id', 'desc')->paginate(10);

        return $result;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        if (null == $company = $this->model->find($id)) {
            throw new ModelNotFoundException('Company not found');
        }

        return $company;
    }
}
