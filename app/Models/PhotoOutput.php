<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoOutput extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function hamparan()
    {
        return $this->belongsTo(PhotoHamparan::class, 'photo_hamparan_id');
    }
}
