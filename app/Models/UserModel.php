<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMOne;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;


public function getJWTIdentifier()
{
    return $this->getKey();
}

public function getJWTCustomClaims()
{
    return [];
}
//     protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
//     protected $primaryKey = 'user_id'; // Mendefinisikan primary key tabel yang digunakan
//     public $timestamps = false; // Sesuaikan jika tabel tidak menggunakan timestamps
//     /**
//  * @var array
//  */
    
//     protected $fillable = ['level_id', 'username', 'nama', 'password'];
//     // protected $fillable = ['level_id', 'username', 'nama'];

//     public function level(): BelongsTo
//     {
//         return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
//     }

protected $table = 'm_user';        // Mendefinisikan nama tabel yang digunakan oleh model ini
protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan

// protected $fillable = ['username', 'password', 'nama', 'level_id', 'created_at', 'updated_at']; 
protected $fillable = [
    'username',
    'password',
    'nama',
    'level_id',
    'created_at',
    'updated_at',
    'image' // tambahan
];



protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts= ['password' => 'hashed']; // casting password agar otomatis di hash
    
    // Relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    protected function image():Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/'.$image),
        );
    }

    /**
     * Mendapatkan nama role
     */
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }
    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

     /**
     * Mendapatkan kode role
     */
    public function getRole()
    {
        return $this->level->level_kode;
    }

    
}
