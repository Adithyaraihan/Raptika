<?php

namespace App\Http\Controllers\Intop;

use App\Http\Controllers\Controller;
use App\Models\IntopServiceCatalog;
use Illuminate\Http\Request;

class ServiceCatalogController extends Controller
{

    protected $intopId = 4;

    public function index()
    {
        $items = IntopServiceCatalog::query()->latest('id')->get();
        return response()->json(compact('items'));
    }

    public function create()
    {
        return response()->json(['message' => 'Success']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'        => 'required|string|max:255',
            'service_name'    => 'required|string|max:255',
            'year'            => 'required|integer|min:2000|max:2099',
        ]);

        $validated["service_type_id"] = $this->intopId;

        IntopServiceCatalog::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $item = IntopServiceCatalog::findOrFail($id);
        return response()->json(compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category'        => 'required|string|max:255',
            'service_name'    => 'required|string|max:255',
            'year'            => 'required|integer|min:2000|max:2099',
        ]);

        $validated["service_type_id"] = $this->intopId;

        $item = IntopServiceCatalog::findOrFail($id);
        $item->update($validated);

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        IntopServiceCatalog::findOrFail($id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
