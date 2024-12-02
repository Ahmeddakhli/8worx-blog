<?php

namespace a8worx\Blogs\Http\Requests\Comments;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IndexCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $columns = DB::getSchemaBuilder()->getColumnListing("comments");
        return [
            'sort_field' => ['nullable', Rule::in($columns)],
            'filters' => 'nullable|array',
            'current_page' => 'nullable|',
            'page_size' => 'nullable|',
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
