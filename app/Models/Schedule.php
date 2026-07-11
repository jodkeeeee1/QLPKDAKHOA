<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    // ✅ khóa chính đúng
    protected $primaryKey = 'row_id';

    // ✅ row_id là số tự tăng
    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'shift_id',
        'specialty_id',
        'note',
        'status',
        'day',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id', 'specialty_id');
    }
}