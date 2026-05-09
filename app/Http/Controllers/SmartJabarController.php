<?php

namespace App\Http\Controllers;

use App\Models\SmartjabarJoinedApp;
use App\Models\SmartjabarUsageStat;
use Illuminate\Http\Request;


class SmartJabarController extends Controller
{
    protected $smartJabarId = 2;

    private function getOpdList()
    {
        return [
            "DINAS KOMUNIKASI DAN INFORMATIKA",
            "DINAS PEMUDA DAN OLAHRAGA",
            "DINAS LINGKUNGAN HIDUP",
            "DINAS TENAGA KERJA DAN TRANSMIGRASI",
            "DINAS KOPERASI DAN USAHA KECIL",
            "BADAN PENGHUBUNG",
            "DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL",
            "INSPEKTORAT DAERAH",
            "SEKRETARIAT DPRD",
            "DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK DAN KELUARGA BERENCANA",
            "DINAS KELAUTAN DAN PERIKANAN",
            "DINAS PEMBERDAYAAN MASYARAKAT DAN DESA",
            "DINAS KEHUTANAN",
            "DINAS PERINDUSTRIAN DAN PERDAGANGAN",
            "DINAS SOSIAL",
            "DINAS SUMBER DAYA AIR",
            "DINAS ENERGI DAN SUMBER DAYA MINERAL",
            "DINAS PERHUBUNGAN",
            "DINAS TANAMAN PANGAN DAN HORTIKULTURA",
            "DINAS KETAHANAN PANGAN DAN PETERNAKAN",
            "DINAS BINA MARGA DAN PENATAAN RUANG",
            "DINAS PERUMAHAN DAN PERMUKIMAN",
            "BADAN KEPEGAWAIAN DAERAH",
            "DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU",
            "SEKRETARIAT DAERAH",
            "BADAN PENGEMBANGAN SUMBER DAYA MANUSIA",
            "DINAS PARIWISATA DAN KEBUDAYAAN",
            "BADAN PENANGGULANGAN BENCANA DAERAH",
            "DINAS PERKEBUNAN",
            "DINAS PENDIDIKAN",
            "BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH",
            "DINAS PERPUSTAKAAN DAN KEARSIPAN DAERAH",
            "SATUAN POLISI PAMONG PRAJA",
            "DINAS KESEHATAN",
            "BADAN PENELITIAN DAN PENGEMBANGAN DAERAH",
            "BADAN PERENCANAAN PEMBANGUNAN DAERAH",
            "BADAN PENDAPATAN DAERAH",
            "BADAN KESATUAN BANGSA DAN POLITIK"
        ];
    }
    // GET /smartjabar/joined-apps
    public function index()
    {
        $data = SmartjabarJoinedApp::where('service_type_id', $this->smartJabarId)
            ->orderByDesc('year')->orderByDesc('month')->get();

        // Kita ambil juga data statistik penggunaan untuk ditampilkan di view yang sama atau berbeda
        $stats = SmartjabarUsageStat::where('service_type_id', $this->smartJabarId)
            ->orderByDesc('year')->orderByDesc('month')->get();

        return view('smartjabar.joined-apps.index', compact('data', 'stats'));
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

    // baru========================================================================
    public function createStat()
    {
        $opds = $this->getOpdList();
        return view('smartjabar.stats.create', compact('opds'));
    }

    public function storeStat(Request $request)
    {
        $request->validate([
            'month' => 'required|integer',
            'year'  => 'required|integer',
            'stats' => 'required|array',
        ]);

        // Bungkus dengan Database Transaction demi keamanan data
        \DB::transaction(function () use ($request) {
            foreach ($request->stats as $opdName => $values) {
                // Ambil ID dari database berdasarkan nama yang dikirim dari form
                $opd = \App\Models\SmartjabarOpd::where('name', $opdName)->first();

                if ($opd) {
                    \App\Models\SmartjabarUsageStat::create([
                        'service_type_id' => $this->smartJabarId,
                        'opd_id'          => $opd->id, // Sekarang yang masuk adalah ANGKA (ID)
                        'month'           => $request->month,
                        'year'            => $request->year,
                        'total_asn'       => $values['total_asn'] ?? 0,
                        'active_users'    => $values['active_users'] ?? 0,
                    ]);
                }
            }
        });

        return redirect()->route('smartjabar.joined-apps.index')
            ->with('success', 'Data statistik berhasil disimpan ke database (Relational).');
    }

    public function editStat($id)
    {
        $stat = SmartjabarUsageStat::findOrFail($id);
        $opds = $this->getOpdList();
        return view('smartjabar.stats.edit', compact('stat', 'opds'));
    }

    public function updateStat(Request $request, $id)
    {
        $stat = SmartjabarUsageStat::findOrFail($id);

        $validated = $request->validate([
            'opd_id'       => 'required',
            'month'        => 'required|integer|min:1|max:12',
            'year'         => 'required|integer|min:2000|max:2099',
            'total_asn'    => 'required|integer|min:0',
            'active_users' => 'required|integer|min:0|lte:total_asn',
        ]);

        $stat->update($validated);

        return redirect()->route('smartjabar.joined-apps.index')
            ->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroyStat($id)
    {
        SmartjabarUsageStat::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Statistik berhasil dihapus.');
    }
}
