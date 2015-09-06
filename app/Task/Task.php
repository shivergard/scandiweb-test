<?php

namespace ScandiWebTest\Task;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = ['description', 'time_spent'];
}
