<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $data = Pegawai::when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
        })->with('pekerjaan')->paginate(10);
        return view('pegawai.index', compact('data'));
    }

    public function add()
    {
        $pekerjaan = Pekerjaan::all();

        return view('pegawai.add', [
            'pekerjaan' => $pekerjaan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|string|email',
            'pekerjaan_id' => 'required|exists:jibrilian_542393_pekerjaan,id'
        ]);

        if ($validator->fails()) return redirect()->back()->with($validator->errors()->all());

        $data = new Pegawai();
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->pekerjaan_id = $request->pekerjaan_id;

        if ($data->save()) {
            return redirect()->route('pegawai.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('pegawai.index')->with('success', 'Data tidak tersimpan');
        }
    }

    public function edit(Request $request)
    {
        $pekerjaan = Pekerjaan::all();
        $data = Pegawai::findOrFail($request->id);
        return view('pegawai.edit', [
            'data' => $data,
            'pekerjaan' => $pekerjaan
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|string|email',
            'pekerjaan_id' => 'required|exists:jibrilian_542393_pekerjaan,id'
        ]);

        if ($validator->fails()) return redirect()->back()->with($validator->errors()->all());

        $data = Pegawai::findOrFail($request->id);
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->pekerjaan_id = $request->pekerjaan_id;

        if ($data->save()) {
            return redirect()->route('pegawai.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('pegawai.index')->with('success', 'Data tidak tersimpan');
        }
    }

    public function destroy(Request $request)
    {
        Pegawai::findOrFail($request->id)->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data terhapus');
    }
}
