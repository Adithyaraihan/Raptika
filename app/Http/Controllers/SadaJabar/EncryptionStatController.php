<?php

namespace App\Http\Controllers\SadaJabar;

use App\Http\Controllers\Controller;
use App\Models\SadajabarEncryptionStat;
use Illuminate\Http\Request;

class EncryptionStatController extends Controller
{
    protected $sadajabarId = 1;

    public function index()
    {
        $data = SadajabarEncryptionStat::where('service_type_id', $this->sadajabarId)
            ->orderByDesc('year')->orderByDesc('month')->get();

        return response()->json(compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Success']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year'      => 'required|integer|min:2000|max:2099',
            'month'     => 'required|integer|min:1|max:12',
            'app_count' => 'required|integer|min:0',
        ]);
        $validated['service_type_id'] = $this->sadajabarId;

        SadajabarEncryptionStat::create($validated);

        return response()->json(['message' => 'Data enkripsi berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $item = SadajabarEncryptionStat::findOrFail($id);
        return response()->json(compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item      = SadajabarEncryptionStat::findOrFail($id);
        $validated = $request->validate([
            'year'      => 'required|integer|min:2000|max:2099',
            'month'     => 'required|integer|min:1|max:12',
            'app_count' => 'required|integer|min:0',
        ]);
        $item->update($validated);

        return response()->json(['message' => 'Data enkripsi berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        SadajabarEncryptionStat::findOrFail($id)->delete();
        return response()->json(['message' => 'Data enkripsi berhasil dihapus.']);
    }
}
