<?php

namespace App\Http\Requests\Api\V1\Membership;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'family_id' => 'required|integer',
            'title' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'nrc_or_passport_no' => 'required|string',
            'occupation' => 'required|string',
            'email' => ['required', 'string', Rule::unique('members')->ignore($this->member, 'member_id')],
            'mobile_number' => 'required|string',
        ];
    }
}
