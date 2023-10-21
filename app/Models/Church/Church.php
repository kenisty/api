<?php declare(strict_types=1);

namespace App\Models\Church;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Church extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'churches';

    protected $fillable = [
        'name',
        'sect_id',
        'created_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];
}
