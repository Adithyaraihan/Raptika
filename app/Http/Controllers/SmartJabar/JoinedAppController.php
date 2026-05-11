<?php

namespace App\Http\Controllers\SmartJabar;

use App\Http\Controllers\Controller;
use App\Models\SmartjabarJoinedApp;
use Illuminate\Http\Request;

class JoinedAppController extends Controller
{
    protected $smartJabarId = 2;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year'       => 'required|integer|min:2000|max:2099',
            'month'      => 'required|integer|min:1|max:12',
            'total_apps' => 'required|integer|min:0',
        ]);

        $validated['service_type_id'] = $this->smartJabarId;

        SmartjabarJoinedApp::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $item = SmartjabarJoinedApp::findOrFail($id);
        return response()->json(compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = SmartjabarJoinedApp::findOrFail($id);

        $validated = $request->validate([
            'year'       => 'required|integer|min:2000|max:2099',
            'month'      => 'required|integer|min:1|max:12',
            'total_apps' => 'required|integer|min:0',
        ]);

        $item->update($validated);

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $item = SmartjabarJoinedApp::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
