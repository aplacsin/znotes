<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function save(Task $task): Task
    {
        $task->save();

        return $task;
    }

    public function removeById(int $id): void
    {
        Task::query()
            ->findorfail($id)
            ->delete();
    }

    public function findById(int $id)
    {
       return Task::query()
           ->where('id', $id)
           ->first();
    }

    public function list(array $filter): Collection
    {
        $task = Task::query()
            ->where('user_id', $filter['user_id'])
            ->where('status', 'ToDo');

        if ($title = $filter['title']) {
            $task->where('title', 'like', "%{$title}%");
        }

        if ($priority = $filter['priority']) {
            $task->where('priority', $priority);
        }

        if ($filter['sort'] && $filter['method']) {
            $task->orderBy("{$filter['sort']}", "{$filter['method']}");
        }

        return $task->orderBy('created_at', 'DESC')->get();
    }

    public function findCompleteByUserId(int $userId): LengthAwarePaginator
    {
        return Task::query()
            ->where('user_id', $userId)
            ->where('status', 'Completed')
            ->orderBy('updated_at', 'DESC')
            ->paginate(15);
    }
}
