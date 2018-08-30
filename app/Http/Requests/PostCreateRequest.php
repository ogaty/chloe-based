<?php

namespace App\Http\Requests;

use App\Helpers\CanvasHelper;
use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => 'required|unique:posts',
            'published_at' => 'required',
        ];
    }

    /**
     * Return the fields and values to create a new post from.
     */
    public function postFillData()
    {
        return [
            'user_id' => $this->user_id,
            'custom_code' => $this->custom_code,
            'title' => $this->title,
            'slug' => $this->slug,
            'custom_code' => 'blog',
            'page_image' => $this->page_image,
            'description_raw' => $this->description_raw,
            'content_raw' => $this->content_raw,
            'meta_description' => $this->meta_description,
            'is_published' => (bool) $this->is_published,
            'published_at' => $this->published_at,
            'layout' => 'default',
        ];
    }
}
