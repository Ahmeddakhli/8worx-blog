<?php

namespace a8worx\Blogs\Http\Requests\BlogCategories;

use App\Http\Requests\FormRequest;

class DeleteBlogCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => "required|exists:blog_categories,id,deleted_at,NULL"
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
