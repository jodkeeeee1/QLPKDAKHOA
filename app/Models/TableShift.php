<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableShift extends Model
{
    use HasFactory;

    protected $table = 'table_shifts';

    protected $primaryKey = 'shift_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'shift_id',
        'name',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * Nếu muốn liên kết lịch làm việc theo ca
     * (Schedule dùng shift_id = SHIFT1, SHIFT2...)
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'shift_id', 'shift_id');
    }
}