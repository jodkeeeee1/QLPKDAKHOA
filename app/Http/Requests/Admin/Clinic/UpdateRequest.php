<?php

namespace App\Http\Requests\Admin\Clinic;

use App\Models\Sclinic;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $sclinic;
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
        $id = $this->route('id');
        $this->sclinic = Sclinic::where('sclinic_id', $id)->first();
        $rules = [
            'statusSclinic' => 'boolean'
        ];

        if ($this->sclinic && $this->input('sclinicName') !== $this->sclinic->name) {
            $rules['sclinicName'] = 'required|unique:sclinics,name';
        } else {
            $rules['specialtyName'] = 'required|max:255';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'sclinicName.required' => 'Tên phòng không được bỏ trống',
            'sclinicName.unique' => 'Tên phòng đã tồn tại',
            'specialtyStatus.boolean' => 'Trạng thái phải là 0 hoặc 1',
        ];
    }
}
