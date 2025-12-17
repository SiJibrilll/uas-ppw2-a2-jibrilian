<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {

        $dbResult = Pegawai::select('gender', DB::raw('COUNT(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();

        foreach ($dbResult as $gender => $total) {
            $genderData[$gender] = $total;
        }

        $jobStats = Pegawai::join('jibrilian_542393_pekerjaan', 'jibrilian_542393_pegawai.pekerjaan_id', '=', 'jibrilian_542393_pekerjaan.id')
            ->select('jibrilian_542393_pekerjaan.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('jibrilian_542393_pekerjaan.nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        return view('index', [
            'jobStats' => $jobStats,
            'genderLabels' => array_keys($genderData),
            'genderCounts' => array_values($genderData),
        ]);
    }
}
