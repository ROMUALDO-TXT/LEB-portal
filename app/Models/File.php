<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'path',
        'description',
    ];

    public $rules = [
        'name' => 'required',
        'path' => 'required',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o modelo Folder
    public function folder() : BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * The attributes that control the modifications.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
