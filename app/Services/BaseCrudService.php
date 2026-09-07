<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

abstract class BaseCrudService
{
    /**
     * Get the model class for this service.
     */
    abstract protected function model(): string;

    /**
     * Get default relationships to eager load.
     *
     * @return array<int, string>
     */
    protected function relations(): array
    {
        return [];
    }

    /**
     * Get per-page count for pagination.
     */
    protected function perPage(): int
    {
        return 10;
    }

    /**
     * Get a paginated list of records.
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model()::with($this->relations())
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find a record by ID.
     */
    public function find(int|string $id): ?Model
    {
        return $this->model()::with($this->relations())->find($id);
    }

    /**
     * Transform data before create/update (e.g. strip empty passwords).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function transformData(array $data, bool $isUpdate = false): array
    {
        unset($data['password_confirmation']);

        if ($isUpdate && array_key_exists('password', $data) && ($data['password'] === null || $data['password'] === '')) {
            unset($data['password']);
        }

        return $data;
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Model
    {
        return $this->model()::create($this->transformData($data));
    }

    /**
     * Update an existing record.
     */
    public function update(int|string $id, array $data): Model
    {
        $model = $this->find($id);

        if (! $model) {
            throw new \InvalidArgumentException(
                sprintf('%s not found for id [%s]', $this->model(), $id)
            );
        }

        $model->update($this->transformData($data, isUpdate: true));

        return $model->refresh();
    }

    /**
     * Delete a record by ID.
     */
    public function delete(int|string $id): bool
    {
        $model = $this->find($id);

        if (! $model) {
            return false;
        }

        return $model->delete();
    }
}
