<?php
// ============================================================
// FILE: app/Http/Controllers/SadajabarController.php
// ============================================================
namespace App\Http\Controllers;

use App\Models\SadajabarAppIntegration;
use App\Models\SadajabarEncryptionStat;
use App\Models\SadajabarInstitutionCategory;
use Illuminate\Http\Request;

class SadajabarController extends Controller
{
    protected $sadajabarId = 1;

    // INDEX GABUNGAN — enkripsi + integrasi dalam satu halaman
    public function index()
    {
        $enkripsi  = SadajabarEncryptionStat::where('service_type_id', $this->sadajabarId)
                        ->orderByDesc('year')->orderByDesc('month')->get();

        $integrasi = SadajabarAppIntegration::with('institutionCategory')
                        ->where('service_type_id', $this->sadajabarId)
                        ->orderByDesc('year')->orderByDesc('month')->get();

        return view('sadajabar.index', compact('enkripsi', 'integrasi'));
    }

    // ── APP INTEGRATIONS ────────────────────────

    public function integrasiCreate()
    {
        $categories = SadajabarInstitutionCategory::all();
        return view('sadajabar.integrasi.create', compact('categories'));
    }

    public function integrasiStore(Request $request)
    {
        $validated = $request->validate([
            'year'                                => 'required|integer|min:2000|max:2099',
            'month'                               => 'required|integer|min:1|max:12',
            'app_count'                           => 'required|integer|min:0',
            'sadajabar_institution_categories_id' => 'required|exists:sadajabar_institution_categories,id',
        ]);
        $validated['service_type_id'] = $this->sadajabarId;
        SadajabarAppIntegration::create($validated);
        return redirect()->route('sadajabar.index')->with('success', 'Data integrasi berhasil ditambahkan.');
    }

    public function integrasiEdit($id)
    {
        $item       = SadajabarAppIntegration::findOrFail($id);
        $categories = SadajabarInstitutionCategory::all();
        return view('sadajabar.integrasi.edit', compact('item', 'categories'));
    }

    public function integrasiUpdate(Request $request, $id)
    {
        $item      = SadajabarAppIntegration::findOrFail($id);
        $validated = $request->validate([
            'year'                                => 'required|integer|min:2000|max:2099',
            'month'                               => 'required|integer|min:1|max:12',
            'app_count'                           => 'required|integer|min:0',
            'sadajabar_institution_categories_id' => 'required|exists:sadajabar_institution_categories,id',
        ]);
        $item->update($validated);
        return redirect()->route('sadajabar.index')->with('success', 'Data integrasi berhasil diperbarui.');
    }

    public function integrasiDestroy($id)
    {
        SadajabarAppIntegration::findOrFail($id)->delete();
        return redirect()->route('sadajabar.index')->with('success', 'Data integrasi berhasil dihapus.');
    }

    // ── ENCRYPTION STATS ────────────────────────

    public function enkripsiCreate()
    {
        return view('sadajabar.enkripsi.create');
    }

    public function enkripsiStore(Request $request)
    {
        $validated = $request->validate([
            'year'      => 'required|integer|min:2000|max:2099',
            'month'     => 'required|integer|min:1|max:12',
            'app_count' => 'required|integer|min:0',
        ]);
        $validated['service_type_id'] = $this->sadajabarId;
        SadajabarEncryptionStat::create($validated);
        return redirect()->route('sadajabar.index')->with('success', 'Data enkripsi berhasil ditambahkan.');
    }

    public function enkripsiEdit($id)
    {
        $item = SadajabarEncryptionStat::findOrFail($id);
        return view('sadajabar.enkripsi.edit', compact('item'));
    }

    public function enkripsiUpdate(Request $request, $id)
    {
        $item      = SadajabarEncryptionStat::findOrFail($id);
        $validated = $request->validate([
            'year'      => 'required|integer|min:2000|max:2099',
            'month'     => 'required|integer|min:1|max:12',
            'app_count' => 'required|integer|min:0',
        ]);
        $item->update($validated);
        return redirect()->route('sadajabar.index')->with('success', 'Data enkripsi berhasil diperbarui.');
    }

    public function enkripsiDestroy($id)
    {
        SadajabarEncryptionStat::findOrFail($id)->delete();
        return redirect()->route('sadajabar.index')->with('success', 'Data enkripsi berhasil dihapus.');
    }
}