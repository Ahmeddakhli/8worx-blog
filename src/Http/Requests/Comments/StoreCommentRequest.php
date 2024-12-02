<?php

namespace a8worx\Blogs\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;


class StoreCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $array['blog_id'] = "required|exists:blogs,id,deleted_at,NULL";
        $array['parent_id'] = "nullable|exists:comments,id,deleted_at,NULL";
        $array['content'] = 'required|string|max:65000';
        // Attachments validation

        return $array;
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
