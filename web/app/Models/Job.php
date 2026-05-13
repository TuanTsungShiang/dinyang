<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job_openings';

    protected $fillable = [
        'title', 'department', 'location', 'type',
        'description', 'requirements', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'full-time' => '正職',
            'part-time' => '兼職',
            'contract'  => '合約',
            default     => $this->type,
        };
    }
}
