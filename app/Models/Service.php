<?php

namespace App\Models;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use Filter;
    protected $guarded = ['id'];

    protected $hidden = [
        'category_id',
        'user_id',
    ];
    protected $casts = [
        'image' => 'json',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function addOns(): BelongsToMany
    {
        return $this->belongsToMany(AddOn::class, 'add_on_service', 'service_id', 'add_on_id')
            ->withPivot('add_on_name', 'service_name', 'add_on_price')
            ->withTimestamps();
    }
}
