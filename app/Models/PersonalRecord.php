<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalRecord extends Model
{
    use HasFactory;

    protected $table = 'personal_record';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function user() {
		return $this->belongsTo(User::class);
	}

    public function movement() {
		return $this->belongsTo(Movement::class);
	}
}
