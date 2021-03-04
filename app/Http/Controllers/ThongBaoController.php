<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatLichKham;
use App\Models\ThongBao;

class ThongBaoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:DlBv106x-edit', ['only' => ['thongbao_datlich','thongbao_vacxin']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function thongbao_datlich(Request $request)
    {
        $thongbao = ThongBao::first();
        return view('pages.thongbao.thongbao_datlich',compact('thongbao'));
    }
    public function thongbao_vacxin(Request $request)
    {
        $thongbao = ThongBao::first();
        return view('pages.thongbao.thongbao_vacxin',compact('thongbao'));
    }
    public function update(Request $request)
    {
        $thongbao = ThongBao::first();
        $input = $request->all();
        $thongbao->update($input);
        if($request->formdatlich == 1)
        {
            return redirect()->route('dat-lich-kham.index')
            ->with('success', 'Sửa thông báo thành công.');
        }
        return redirect()->route('vac-xin.chitiet')
            ->with('success', 'Sửa thông báo thành công.');
    }

}
