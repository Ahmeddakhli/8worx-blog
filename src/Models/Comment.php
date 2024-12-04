<?php

namespace Modules\Blogs\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Wildside\Userstamps\Userstamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Languages\Models\Language;
use App;
use Modules\Lookups\Models\Lookup;
use Modules\Users\Models\User;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Comment extends BaseModel implements HasMedia
{
    use SoftDeletes, SoftCascadeTrait, LogsActivity, Userstamps, InteractsWithMedia, QueryCacheable;

    const CREATED_BY = 'created_by';
    const UPDATED_BY = 'updated_by';
    const DELETED_BY = 'deleted_by';

    /**
     * Get the class being used to provide a User.
     *
     * @return string
     */
    protected function getUserClass()
    {
        return "Modules\Users\Models\User";
    }

    protected $table = 'comments';
    protected $primaryKey = 'id';
    public $timestamps = true;
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
    public $cacheTags = ['Comment'];
        /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'content',
        'is_approved','user_id','parent_id','blog_id'
    ];
    protected $appends = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at', 'start_date', 'end_date'];
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = [];
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected static $ignoreChangedAttributes = [];
    protected static $logOnlyDirty = true;
    protected static $logName = 'comment_log';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
   // Laravel Media Library
   public function registerMediaCollections(): void
   {
       $this->addMediaCollection('comments.comment')->useDisk('public');
   }
    // Scope to select Approved data
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope to select all data
    public function scopeAllData($query)
    {
        return $query;
    }

    public static function boot()
    {
        parent::boot();
    }
}
