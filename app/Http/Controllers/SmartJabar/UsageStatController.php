<?php

namespace App\Http\Controllers\SmartJabar;

use App\Http\Controllers\Controller;
use App\Models\GeneralOpd;
use App\Models\SmartjabarUsageStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsageStatController extends Controller
{
    protected $smartJabarId = 2;

    private function getOpdList()
    {
        return [
            "BADAN PENGHUBUNG",
            "SEKRETARIAT DPRD",
            "DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL",
            "DINAS PEMUDA DAN OLAHRAGA",
            "DINAS PEMBERDAYAAN MASYARAKAT DAN DESA",
            "BADAN PENANGGULANGAN BENCANA DAERAH",
            "INSPEKTORAT DAERAH",
            "BADAN PENGEMBANGAN SUMBER DAYA MANUSIA",
            "SATUAN POLISI PAMONG PRAJA",
            "DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU",
            "BADAN KESATUAN BANGSA DAN POLITIK",
            "BADAN PENELITIAN DAN PENGEMBANGAN DAERAH",
            "BADAN PERENCANAAN PEMBANGUNAN DAERAH",
            "DINAS KOMUNIKASI DAN INFORMATIKA",
            "DINAS PARIWISATA DAN KEBUDAYAAN",
            "DINAS SOSIAL",
            "BADAN KEPEGAWAIAN DAERAH",
            "DINAS KEHUTANAN",
            "DINAS PERINDUSTRIAN DAN PERDAGANGAN",
            "DINAS PERPUSTAKAAN DAN KEARSIPAN DAERAH",
            "DINAS KELAUTAN DAN PERIKANAN",
            "DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK, DAN KELUARGA BERENCANA",
            "DINAS PERKEBUNAN",
            "DINAS KOPERASI DAN USAHA KECIL",
            "DINAS KETAHANAN PANGAN DAN PETERNAKAN",
            "DINAS PERHUBUNGAN",
            "DINAS SUMBER DAYA AIR",
            "DINAS BINA MARGA DAN PENATAAN RUANG",
            "DINAS TANAMAN PANGAN DAN HORTIKULTURA",
            "DINAS LINGKUNGAN HIDUP",
            "DINAS PERUMAHAN DAN PERMUKIMAN",
            "BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH",
            "DINAS TENAGA KERJA DAN TRANSMIGRASI",
            "DINAS ENERGI DAN SUMBER DAYA MINERAL",
            "BADAN PENDAPATAN DAERAH",
            "SEKRETARIAT DAERAH",
            "DINAS KESEHATAN",
            "DINAS PENDIDIKAN"
        ];
    }

    public function create()
    {
        $opds = $this->getOpdList();
        return response()->json(compact('opds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|integer',
            'year'  => 'required|integer',
            'stats' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->stats as $opdName => $values) {
                $opd = GeneralOpd::where('name', $opdName)->first();

                if ($opd) {
                    SmartjabarUsageStat::create([
                        'service_type_id' => $this->smartJabarId,
                        'opd_id'          => $opd->id,
                        'month'           => $request->month,
                        'year'            => $request->year,
                        'total_asn'       => $values['total_asn'] ?? 0,
                        'active_users'    => $values['active_users'] ?? 0,
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Data statistik berhasil disimpan ke database (Relational).'], 201);
    }

    public function edit($id)
    {
        $stat = SmartjabarUsageStat::findOrFail($id);
        $opds = $this->getOpdList();
        return response()->json(compact('stat', 'opds'));
    }

    public function update(Request $request, $id)
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

        return response()->json(['message' => 'Statistik berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        SmartjabarUsageStat::findOrFail($id)->delete();
        return response()->json(['message' => 'Statistik berhasil dihapus.']);
    }
}
