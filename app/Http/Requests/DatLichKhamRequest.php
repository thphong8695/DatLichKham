<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DatLichKhamRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'ngaykham' => 'required|date',
            'khunggio_id' => 'required|integer',
            'benhvien_id' => 'required|integer',
            'chuyenkhoa_id' => 'required|integer',
            'name' => ['required','max:191',Rule::unique('mysql.datlichkhams')->where(function ($query) {
                        return $query->where('ngaykham', Carbon::parse($this->get('ngaykham'))->format('Y-m-d'))
                        ->where('name', $this->get('name'))
                        ->where('khunggio_id', $this->get('khunggio_id'))
                        ->where('chuyenkhoa_id', $this->get('chuyenkhoa_id'))
                        ->where('benhvien_id', $this->get('benhvien_id'));
                    })->ignore($this->dat_lich_kham->id),
            ],
            'namsinh' => 'min:0',
            'gioitinh' => 'max:6',
            'bacsi_id' => 'min:0',
            'phone' => 'required|max:191|digits_between:9,15',
            'sonha'=> 'max:191',
            'diachi'=> 'max:191',
            'mayte'=> 'max:191',
            'sobaohiem'=> 'max:191',
            
        ];
    }
    public function messages()
    {
        return [
            'required' => ":attribute không được bỏ trống!",
            'unique' => ":attribute đã tồn tại, vui lòng kiểm tra lại!",
            'integer' => ":attribute phải là số!",
            'date' => ":attribute phải đúng định dạng ngày!",
            'max' => ":attribute không vượt quá :max!",
            'digits_between' => ":attribute phải trên :min số và nhỏ hơn :max số!",
        ];
    }
    public function attributes()
    {
        return [
                'name' => 'Họ & Tên',
                'namsinh' => 'Năm sinh',
                'gioitinh' => 'Giới tính',
                'phone' => 'Số điện thoại',
                'sonha'=> 'Số nhà',
                'diachi'=> 'Địa chỉ',
                'mayte'=> 'Mã y tế',
                'sobaohiem'=> 'Số bảo hiểm',
                'ngaykham' => 'Ngày khám',
                'khunggio_id' => 'Khung giờ',
                'benhvien_id' => 'Bệnh viện',
                'bacsi_id' => 'Bác sĩ',

        ];
    }
}
