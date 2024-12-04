<?php

namespace a8worx\Blogs\Http\Resources;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserMinimalResource;
use a8worx\Attachments\Http\Resources\AttachmentableResource;
use a8worx\Lookups\Http\Resources\LookupResource;
use a8worx\Users\Http\Resources\UserMinilResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'video_type' => $this->video_type,
            'video' => $this->video,
            'views' => $this->views,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'is_show_date' => $this->is_show_date,
            'is_show_creator' => $this->is_show_creator,
            'start_date' => $this->start_date ?? null,
            'end_date' => $this->end_date  ?? null, 
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'trans' => $this->trans ? $this->trans : [],
            'featured_image_id' => $this->getFirstMedia('blogs.blog.featured_image')?[$this->getFirstMedia('blogs.blog.featured_image')->id]:[],
            'featured_image' => $this->getFirstMedia('blogs.blog.featured_image'),
            'card_image_id' => $this->getFirstMedia('blogs.blog.card_image')?[$this->getFirstMedia('blogs.blog.card_image')->id]:[],
            'card_image' => $this->getFirstMedia('blogs.blog.card_image'),
            // 'category' =>  new LookupResource($this->category) ,
            'category_id' =>  $this->category_id,
            'media_type' =>$this->media_type,
            // 'tag_ids' => $this->tags->pluck('id'),
            // 'tags' => LookupResource::collection($this->tags),
            // 'comments' => CommentResource::collection($this->comments),
            // 'creator' => $this->creator ? new UserMinilResource($this->creator) : null,
            // 'created_at' => $this->created_at ? $this->created_at->timezone(auth()->user() ? auth()->user()->timezone : 'Africa/Cairo')->toDateTimeString() : null,
            // 'updated_at' => $this->updated_at ? $this->updated_at->timezone(auth()->user() ? auth()->user()->timezone : 'Africa/Cairo')->toDateTimeString() : null,
            // 'created_since' => $this->created_at ? $this->created_at->timezone(auth()->user() ? auth()->user()->timezone : 'Africa/Cairo')->diffForHumans() : null,
            // 'updated_since' => $this->updated_at ? $this->updated_at->timezone(auth()->user() ? auth()->user()->timezone : 'Africa/Cairo')->diffForHumans() : null,
        ];
    }
}
