<?php

namespace a8worx\Blogs\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use a8worx\Lookups\Traits\LookupsTrait;

class BlogTagsLookupsDataTableSeeder extends Seeder
{
    use LookupsTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $blog_class = \a8worx\Blogs\Models\Blog::class;

        // Blog Category Types
        $blog_tag = $this->createLookup('Blogs tags', 'فئات المنشورات', $blog_class);
        if($blog_tag):
            $this->createLookup('Bed rooms', 'عرف النوم', $blog_class, $blog_tag);
            $this->createLookup('Living Rooms', 'غرف المعيشه', $blog_class, $blog_tag);
            $this->createLookup('Living Rooms', 'غرف المعيشه', $blog_class, $blog_tag);
        endif;
    }
}
