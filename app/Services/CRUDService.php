<?php

namespace App\Services;

use App\Models\User;
use Throwable;

class CRUDService
{
    // all . paginate . view . search . sort . conditions
    public function browse($model, $request, $id = null)
    {
        try {
            $query = $model::query();

            $query = $this->applyConditions($query, $request);

            // Find by ID
            if ($id !== null) {
                $response = $query->find($id);

                return $response ? [$response, 200] : ['Data not found', 404];
            }

            // Get All
            if ($request->has('all') && $request->boolean('all')) {
                return [$query->get(), 200];
            }

            // Get Paginated Data : default 15 per page
            return [$query->paginate($request->per_page ?? 15), 200];
        } catch (\Throwable $e) {
            return [$e->getMessage(), 500];
        }
    }

    // Save data
    public function save($model, $id, array $data)
    {
        try {
            if ($id) {
                $existingData = $model::find($id);
                if ($existingData) {
                    $existingData->update($data);

                    return [$existingData, 200];
                }

                return ['No existing data', 404];
            }

            $word = $model::create($data);

            return [$word, 201];
        } catch (Throwable $e) {
            return [$e->getMessage(), 500];
        }
    }

    public function delete($model, $id, $force = false)
    {
        try {
            $force = $force === 'true' ? true : false;
            $data = $force === true ? $model::withTrashed()->find($id) : $model::find($id);

            if (! $data) {
                return ['Data not found', 404];
            }

            $softDeleteExists = method_exists($model, 'bootSoftDeletes');

            $operationText = 'deleted';
            if ($force && $softDeleteExists) {
                $data->forceDelete();
            } else {
                $data->delete();

                if ($softDeleteExists) {
                    $operationText = 'trashed';
                }
            }

            return ['Data ' . $operationText . ' successfully', 200];
        } catch (Throwable $e) {
            return [$e->getMessage(), 500];
        }
    }

    public function restore($model, $id)
    {
        try {
            $data = $model::withTrashed()->find($id);

            if (! $data) {
                return ['Data not found', 404];
            }

            $data->restore();

            return ['Data restored successfully', 200];
        } catch (Throwable $e) {
            return [$e->getMessage(), 500];
        }
    }

    public function list($model, $labelOption = 'name', $limit = 10)
    {
        try {
            $query = $model::query()
                ->select(['id as value', $labelOption . ' as label'])
                ->limit($limit);

            // exclude some user roles
            if ($model === User::class) {
                $query->whereNotIn('user_role_id', [1, 2, 5]);
            }

            return [$query->get(), 200];
        } catch (\Throwable $e) {
            return [$e->getMessage(), 500];
        }
    }

    private function applyConditions($query, $request)
    {
        // Decode JSON fields if they are strings
        $where = is_string($request->where) ? json_decode($request->where, true) : $request->where;

        $whereIn = is_string($request->whereIn) ? json_decode($request->whereIn, true) : $request->whereIn;
        $whereNotIn = is_string($request->whereNotIn) ? json_decode($request->whereNotIn, true) : $request->whereNotIn;
        $whereHas = is_string($request->whereHas) ? json_decode($request->whereHas, true) : $request->whereHas;
        $sort = is_string($request->sort) ? json_decode($request->sort, true) : $request->sort;
        $with = is_string($request->with) ? json_decode($request->with, true) : $request->with;

        // Apply where conditions
        if (! empty($where)) {
            foreach ($where as $w) {
                if (is_array($w) && isset($w['key'], $w['value'])) {
                    $query->where($w['key'], $w['value']);
                }
            }
        }

        // Handle whereIn condition
        if (! empty($whereIn) && is_array($whereIn)) {
            $query->whereIn($whereIn['key'], $whereIn['value']);
        }

        // Handle whereNotIn condition
        if (! empty($whereNotIn) && is_array($whereNotIn)) {
            $query->whereNotIn($whereNotIn['key'], $whereNotIn['value']);
        }

        // Handle whereHas condition
        if (! empty($whereHas) && is_array($whereHas)) {
            $query->whereHas($whereHas['key'], function ($q) use ($whereHas) {
                $q->where($whereHas['where'], $whereHas['value']);
            });
        }

        // Handle search
        if (! empty($request->search)) {
            $query->where($request->search_by, 'like', '%' . $request->search . '%');
        }

        // Handle relationships
        if (! empty($with)) {
            $query->with($with);
        }

        // Handle withExists
        if (! empty($request->withExists)) {
            $query->withExists($request->withExists);
        }

        // Handle Only Trashed
        if ($request->has('onlyTrashed') && $request->boolean('onlyTrashed')) {
            $query->onlyTrashed();
        }

        // Handle sorting
        if (is_array($sort) && ! empty($sort)) {
            if (isset($sort['key'], $sort['order'])) {
                $query->orderBy($sort['key'], $sort['order']);
            }
        } else {
            $query->orderBy('id', 'desc'); // Default sorting
        }

        // Apply limit (optional)
        if (! empty($request->limit) && is_numeric($request->limit)) {
            $query->limit((int) $request->limit);
        }

        return $query;
    }
}
