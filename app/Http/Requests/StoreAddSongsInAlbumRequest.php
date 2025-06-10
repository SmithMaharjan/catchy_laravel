<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddSongsInAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'album_name' => ['required', 'string', 'max:255'],

            'songs' => ['required', 'array', 'min:1'],

            'songs.*.id' => ['nullable', 'integer', 'exists:songs,id'],  // nullable for new songs, must exist if given

            'songs.*.name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
