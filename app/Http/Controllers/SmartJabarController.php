<?php

namespace App\Http\Controllers;

use App\Models\SmartjabarJoinedApp;
use Illuminate\Http\Request;

class SmartJabarController extends Controller
{
    protected $smartJabarId = 2;

    // GET /smartjabar/joined-apps
    public function index()
    {
        $data = SmartjabarJoinedApp::where('service_type_id', $this->smartJabarId)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('smartjabar.joined-apps.index', compact('data'));
    }

    // GET /smartjabar/joined-apps/create
    public function create()
    {
        return view('smartjabar.joined-apps.create');
    }

    // POST /smartjabar/joined-apps
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year'       => 'required|integer|min:2000|max:2099',
            'month'      => 'required|integer|min:1|max:12',
            'total_apps' => 'required|integer|min:0',
        ]);

        $validated['service_type_id'] = $this->smartJabarId;

        SmartjabarJoinedApp::create($validated);

        return redirect()->route('smartjabar.joined-apps.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    // GET /smartjabar/joined-apps/{id}/edit
    public function edit($id)
    {
        $item = SmartjabarJoinedApp::findOrFail($id);
        return view('smartjabar.joined-apps.edit', compact('item'));
    }

    // PUT /smartjabar/joined-apps/{id}
    public function update(Request $request, $id)
    {
        $item = SmartjabarJoinedApp::findOrFail($id);

        $validated = $request->validate([
            'year'       => 'required|integer|min:2000|max:2099',
            'month'      => 'required|integer|min:1|max:12',
            'total_apps' => 'required|integer|min:0',
        ]);

        $item->update($validated);

        return redirect()->route('smartjabar.joined-apps.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    // DELETE /smartjabar/joined-apps/{id}
    public function destroy($id)
    {
        $item = SmartjabarJoinedApp::findOrFail($id);
        $item->delete();

        return redirect()->route('smartjabar.joined-apps.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
