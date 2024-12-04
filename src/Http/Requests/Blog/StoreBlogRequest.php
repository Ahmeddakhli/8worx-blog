<?php

namespace a8worx\Blogs\Http\Requests\Blog;

use App\Http\Requests\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception;
use Illuminate\Validation\Rule;

class StoreBlogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $translations = $this->request->get('translations') ? $this->request->get('translations') : $this->input('translations');
        if (is_array($translations)) {
            $exists = false;
            for ($i = 0; $i < count($translations); $i++) {
                if ($translations[$i] && isset($translations[$i]['language_id']) && $translations[$i]['language_id'] == 1) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $errors = [];
                $errors[] = [
                    'field' => 'translations',
                    'message' => 'Translations must contain English language'
                ];

                throw new HttpResponseException(response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
            }
        }

        $array = array();
        // Translations
        $array['trans'] = 'required|array';
        // $array['trans.*.language_id'] = "required|exists:languages,id";
        $array['trans.*.title'] = "required|string|max:191";
        $array['trans.*.description'] = "required|string|max:4294967295";
        $array['trans.*.slug'] = 'nullable|string|max:255|unique:blog_trans,slug,Null,id,deleted_at,NULL';
        $array['trans.*.short_description'] = 'nullable|string|max:255';
        $array['trans.*.meta_title'] = 'nullable|string|max:255';
        $array['trans.*.meta_description'] = 'nullable|string|max:16777215';
        // $array['media_type_id'] = "required|exists:lookups,id,deleted_at,NULL";
        $array['media_type'] = ['nullable', 'string', 'in:image,video'];
        $array['video_type'] =['nullable', 'string', 'in:url,iframe'];
        $array['featured_image_id'] = 'nullable|array';
        // $array['featured_image_id.*'] = "required|exists:media,id";
        $array['card_image_id'] = 'nullable|array';
        // $array['card_image_id.*'] = "required|exists:media,id";
        $array['video'] = 'nullable|string|max:4294967295';
        $array['is_featured'] = 'nullable|boolean';
        $array['is_published'] = 'nullable|boolean';
        $array['is_show_creator'] = 'nullable|boolean';
        $array['is_show_date'] = 'nullable|boolean';
        // $array['tag_ids'] = "nullable|exists:lookups,id,deleted_at,NULL";
        // $array['category_id'] = "nullable|exists:lookups,id,deleted_at,NULL";
        $array['start_date'] = 'nullable|date|before:end_date';
        $array['end_date'] = 'nullable|date|after:start_date';
        $array['order'] =['required', 'integer', 'min:0'];
        $array['tags'] = 'nullable|array';
        $array['comments'] = 'nullable|array';
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
