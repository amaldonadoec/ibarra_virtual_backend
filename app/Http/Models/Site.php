<?php

namespace App\Http\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Site
 * @package App\Http\Models
 *
 * @property int id
 * @property string name
 * @property point location
 * @property string description
 * @property boolean status
 */
class Site extends Model
{
    use SpatialTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'sites';

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
        'name',
        'location',
        'description',
        'status'
    ];

    /**
     * @var array
     */
    protected $spatialFields = [
        'location',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'location' => 'point',
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'sites_by_categories',
            'site_id', 'category_id'
        );
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function audio()
    {
        return $this->morphOne(Multimedia::class, 'entity')
            ->where('type', 'AUDIO');
    }
}
