<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Columns that are allowed to be mass-assigned (Task::create($data))
    protected $fillable = ['task_name', 'description', 'status', 'due_date'];

    // Turn due_date into a Carbon date object automatically
    protected $casts = [
        'due_date' => 'date',
    ];

    // A task is overdue if it is still Pending and its deadline is before today
    public function isOverdue(): bool
    {
        return $this->status === 'Pending' && $this->due_date->lt(today());
    }
}