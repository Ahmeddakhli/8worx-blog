<?php

namespace a8worx\Blogs\Http\Requests\Blog;

use App\Http\Requests\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Check English language does exist
        $trans = $this->request->get('trans') ? $this->request->get('trans') : $this->input('trans');
        if (is_array($trans)) {
            $exists = false;
            for ($i = 0; $i < count($trans); $i++) {
                if ($trans[$i] && isset($trans[$i]['language_id']) && $trans[$i]['language_id'] == 1) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $errors = [];
                $errors[] = [
                    'field' => 'trans',
                    'message' => 'Trans must contain English language'
                ];

                throw new HttpResponseException(response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
            }
        }

        $array = array();
        $array['id'] = "required|exists:blogs,id,deleted_at,NULL";
        $array['trans'] = 'nullable|array';
        $array['trans.*.language_id'] = "required|exists:languages,id";
        $array['trans.*.title'] = "required|string|max:191";
        $array['trans.*.description'] = "required|string|max:4294967295";
        $array['trans.*.slug'] =['nullable', 'string', 'max:255', Rule::unique('blog_trans')->ignore($this->id,'blog_id')->where(fn ($query) => $query->where('deleted_at', NULL))];
        $array['trans.*.short_description'] = 'nullable|string|max:255';
        $array['trans.*.meta_title'] = 'nullable|string|max:255';
        $array['trans.*.meta_description'] = 'nullable|string|max:16777215';
        $array['media_type'] = ['nullable', 'string', 'in:image,video'];
        $array['featured_image_id'] = 'nullable|array';
        // $array['featured_image_id.*'] = "required|exists:media,id";
        $array['card_image_id'] = 'nullable|array';
        // $array['card_image_id.*'] = "required|exists:media,id";
        $array['video'] = 'nullable|string|max:4294967295';
        $array['video_type'] =['nullable', 'string', 'in:url,iframe'];
        $array['is_featured'] = 'nullable|boolean';
        $array['is_published'] = 'nullable|boolean';
        $array['is_show_date'] = 'nullable|boolean';
        $array['is_show_creator'] = 'nullable|boolean';
        $array['tag_ids'] = "nullable|exists:lookups,id,deleted_at,NULL";
        $array['category_id'] = "nullable|exists:lookups,id,deleted_at,NULL";
        $array['start_date'] = 'nullable|date|before:end_date';
        $array['end_date'] = 'nullable|date|after:start_date';
        $array['order'] =['nullable', 'integer', 'min:0'];
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
