<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Screening;

/** Aggregate numbers only. No names or accounts are shown here. */
class OverviewController extends Controller
{
    public function __invoke()
    {
        $bands = fn (string $column) => Screening::whereNotNull($column)
            ->selectRaw("$column as band, count(*) as n")->groupBy($column)->pluck('n', 'band');

        return view('office.overview', [
            'total' => Screening::count(),
            'lastWeek' => Screening::where('created_at', '>=', now()->subDays(7))->count(),
            'newReferrals' => Referral::where('status', 'new')->count(),
            'selfHarm' => Screening::where('phq9_item9', '>', 0)->count(),
            'phq9' => $bands('phq9_band'),
            'gad7' => $bands('gad7_band'),
            'referralRate' => Screening::where('referral_suggested', true)->count(),
        ]);
    }
}
