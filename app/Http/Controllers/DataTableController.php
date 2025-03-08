<?php

namespace App\Http\Controllers;

use App\Models\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataTableController extends Controller
{
    const STRING_VALIDATION = 'required|string|max:255';

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_provinsi' => self::STRING_VALIDATION,
            'nama_provinsi' => self::STRING_VALIDATION,
            'kode_kabupaten_kota' => self::STRING_VALIDATION,
            'nama_kabupaten_kota' => self::STRING_VALIDATION,
            'nilai_ikm' => 'required|numeric',
            'satuan' => self::STRING_VALIDATION,
            'tahun' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = DataTable::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $data = DataTable::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->kode_provinsi = $request->input('kode_provinsi', $data->kode_provinsi);
        $data->nama_provinsi = $request->input('nama_provinsi', $data->nama_provinsi);
        $data->kode_kabupaten_kota = $request->input('kode_kabupaten_kota', $data->kode_kabupaten_kota);
        $data->nama_kabupaten_kota = $request->input('nama_kabupaten_kota', $data->nama_kabupaten_kota);
        $data->nilai_ikm = $request->input('nilai_ikm', $data->nilai_ikm);
        $data->satuan = $request->input('satuan', $data->satuan);
        $data->tahun = $request->input('tahun', $data->tahun);

        $data->save();

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $data], 200);
    }

    public function destroy($id)
    {
        $data = DataTable::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    public function show($id)
    {
        $data = DataTable::where('id', $id)->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['message' => 'Data berhasil ditemukan', 'data' => $data], 200);
    }

    public function index()
    {
        $data = DataTable::orderBy('id', 'asc')->get();

        return response()->json(['message' => 'Data berhasil ditemukan', 'data' => $data], 200);
    }
}
