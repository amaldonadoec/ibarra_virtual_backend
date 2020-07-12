<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Http\Models
 *
 * @property Category category
 * @property int id
 * @property int parent_id
 * @property string name
 * @property string description
 * @property boolean status
 */
class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'categories';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Multimedia::class, 'entity')
            ->where('type', 'IMAGE');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function image()
    {
        return $this->morphMany(Multimedia::class, 'entity')
            ->where('type', 'IMAGE')
            ->first();
    }
}
