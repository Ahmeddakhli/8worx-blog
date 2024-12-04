<?php

namespace Modules\Blogs\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Support\Facades\Event;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Wildside\Userstamps\Userstamps;

class BlogTranslation extends BaseModel
{
    use HasCompositePrimaryKey, Userstamps, QueryCacheable;

    const CREATED_BY = 'created_by';
    const UPDATED_BY = 'updated_by';
    const DELETED_BY = 'deleted_by';
     /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     *
     * @var int|\DateTime
     */
    public $cacheFor = 21600;

    /**
     * The tags for the query cache. Can be useful
     * if flushing cache for specific tags only.
     *
     * @var null|array
     */
    public $cacheTags = ['BlogTranslation'];
        /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;
    /**
     * Get the class being used to provide a User.
     *
     * @return string
     */
    protected function getUserClass()
    {
        return "Modules\Users\Models\User";
    }

    protected $table = 'blog_trans';
    protected $primaryKey = ['blog_id', 'language_id'];
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_id', 'language_id', 'slug', 'title', 'description','sub_title', 'short_description', 'meta_title', 'meta_description', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $softCascade = [];

    protected $dates = ['deleted_at'];
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = [];
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected static $ignoreChangedAttributes = [];
    protected static $logOnlyDirty = true;
    protected static $logName = 'blog_translation_log';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Blog Translation " . $this->title . " has been {$eventName}";
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
    }
}
