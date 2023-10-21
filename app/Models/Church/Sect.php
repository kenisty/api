<?php declare(strict_types=1);

namespace App\Models\Church;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sect extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'sects';

    protected $fillable = [
        'sect',
        'created_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];
}
