<?php

namespace a8worx\Blogs\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Wildside\Userstamps\Userstamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use a8worx\Languages\Models\Language;
use App;
use Illuminate\Database\Eloquent\Model;
use a8worx\Lookups\Models\Lookup;
use a8worx\Users\Models\User;
use Illuminate\Support\Facades\Cache;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Blog extends Model 
{
   

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
    public $cacheTags = ['blogs'];
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
        return "a8worx\Users\Models\User";
    }

    protected $table = 'blogs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'order', 'media_type', 'video', 'views', 'category_id', 'is_featured', 'is_published', 'start_date', 'end_date', 'video_type', 'is_show_date', 'is_show_creator'
    ];
    protected $appends = [
        'title', 'sub_title', 'slug', 'description', 'short_description', 'meta_title', 'meta_description',
    ];

    // protected $softCascade = ['translations'];
    // Deleting translations manually to overcome laravel issue with composite primary key
    protected $softCascade = ['comments'];

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
    protected static $logName = 'blog_log';
    protected $language_id;



  

    // public function blog()
    // {
    //     return $this->belongsTo(Blog::class, 'blog_id', 'id');
    // }

    // Scope to select published data
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    // Scope to select all data
    public function scopeAllData($query)
    {
        return $query;
    }

    // Laravel Media Library
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('blogs.blog')->useDisk('public');
        $this->addMediaCollection('blogs.blog.featured_image')->useDisk('public')->singleFile();
        $this->addMediaCollection('blogs.blog.card_image')->useDisk('public')->singleFile();
    }

    public static function boot()
    {
        parent::boot();
        static::created(function () {
            Cache::forget('blogs_module_blogs_sections_ar');
            Cache::forget('blogs_module_blogs_sections_en');
        });
        static::updated(function () {
            Cache::forget('blogs_module_blogs_sections_ar');
            Cache::forget('blogs_module_blogs_sections_en');
        });

        static::deleted(function () {
            Cache::forget('blogs_module_blogs_sections_ar');
            Cache::forget('blogs_module_blogs_sections_en');
        });

        static::saved(function () {
            Cache::forget('blogs_module_blogs_sections_ar');
            Cache::forget('blogs_module_blogs_sections_en');
        });

    }
}
