<?php

namespace App\Http\Controllers\Rekayasa;

use App\Http\Controllers\Controller;
use App\Models\RekayasaApplicationReplication;
use Illuminate\Http\Request;

class ApplicationReplicationController extends Controller
{
    protected $rekayasaId = 3;

    public function index()
    {
        $items = RekayasaApplicationReplication::with('serviceType')->where('service_type_id', $this->rekayasaId)->latest('id')->get(); 
        return response()->json(compact('items'));
    }

    public function create()
    {
        return response()->json(['message' => 'Success']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution_id'      => 'required|integer',
            'year'                => 'required|integer|min:2000|max:2099',
            'month'               => 'required|integer|min:1|max:12',
            'total_replications'  => 'required|integer|min:0',
        ]);

        $validated['service_type_id'] = $this->rekayasaId;

        RekayasaApplicationReplication::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $item = RekayasaApplicationReplication::with('serviceType')->where('service_type_id', $this->rekayasaId)->findOrFail($id);
        return response()->json(compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'institution_id'      => 'required|integer',
            'year'                => 'required|integer|min:2000|max:2099',
            'month'               => 'required|integer|min:1|max:12',
            'total_replications'  => 'required|integer|min:0',
        ]);

        $item = RekayasaApplicationReplication::with('serviceType')->where('service_type_id', $this->rekayasaId)->findOrFail($id);
        $item->update($validated);
        $validated['service_type_id'] = $this->rekayasaId;

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        RekayasaApplicationReplication::with('serviceType')->where('service_type_id', $this->rekayasaId)->delete($id);
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
