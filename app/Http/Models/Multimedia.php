<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Image
 * @package App\Http\Models
 *
 * @property Company company
 * @property int id
 * @property int entity_id
 * @property string file_name
 * @property string type
 */
class Multimedia extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'multimedia';

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
        'entity_id',
        'entity_type',
        'type',
        'file_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'entity_id' => 'integer',
        'entity_type' => 'string',
        'type' => 'string',
        'file_name' => 'string'
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
     * Generate url for image
     */
    public function getUrlAttribute()
    {
        $folderName = 'site';
        if ($this->entity()->getModel()->table != 'sites') {
            $folderName = $this->entity()->getModel()->table;
        }
        $folder = "$folderName/{$this->entity_id}";
        $fileName = $this->file_name;
        $url = Storage::disk('s3')->url("{$folder}/{$fileName}");
        return $url;
    }

    /**
     * Get all of the owning models.
     */
    public function entity()
    {
        return $this->morphTo('entity');
    }
}
