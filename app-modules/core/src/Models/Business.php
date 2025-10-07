<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Malhal\Geographical\Geographical;
use Modules\Moonlaunch\Models\User;

class Business extends Model
{
    use Geographical, HasFactory;

    protected static $kilometers = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image',
        'phone',
        'email',
        'status',
        'status_description',
        'address',
        'longitude',
        'latitude',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'longitude' => 'double',
        'latitude' => 'double',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function promotion(): HasOne
    {
        return $this->hasOne(Promotion::class);
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'business_types');
    }

    public function getImageURL()
    {
        if ($this->image) {
            return url('/storage/businesses/'.$this->image);
        }
    }
}
