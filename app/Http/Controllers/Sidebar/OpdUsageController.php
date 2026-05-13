<?php

namespace App\Http\Controllers\Sidebar;

use App\Http\Controllers\Controller;
use App\Models\SidebarOpdUsage;
use Illuminate\Http\Request;

class OpdUsageController extends Controller
{
    protected $sidebarId = 6;

    public function index()
    {
        $items = SidebarOpdUsage::with('serviceType')->where('service_type_id', $this->sidebarId)->latest('id')->get();
        return response()->json(compact('items'));
    }

    public function create()
    {
        return response()->json(['message' => 'Success']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'opd_id'          => 'required|integer',
            'month'           => 'required|integer|min:1|max:12',
            'year'            => 'required|integer|min:2000|max:2099',
            'active_count'    => 'required|integer|min:0',
        ]);

        $validated['service_type_id'] = $this->sidebarId;

        SidebarOpdUsage::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $item = SidebarOpdUsage::with('serviceType')->where('service_type_id', $this->sidebarId)->findOrFail($id);
        return response()->json(compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'opd_id'          => 'required|integer',
            'month'           => 'required|integer|min:1|max:12',
            'year'            => 'required|integer|min:2000|max:2099',
            'active_count'    => 'required|integer|min:0',
        ]);

        $item = SidebarOpdUsage::with('serviceType')->where('service_type_id', $this->sidebarId)->findOrFail($id);
        $item->update($validated);
        $validated['service_type_id'] = $this->sidebarId;

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $item = SidebarOpdUsage::where('service_type_id', $this->sidebarId)
            ->where('id', $id)
            ->firstOrFail();

        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
