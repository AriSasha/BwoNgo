<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status', 'open');
        $query = Referral::with('screening')
            ->orderByRaw("case urgency when 'urgent' then 0 when 'high' then 1 else 2 end")
            ->latest();

        if ($filter === 'open') {
            $query->where('status', '!=', 'closed');
        } elseif (array_key_exists($filter, Referral::STATUSES)) {
            $query->where('status', $filter);
        }

        $counts = Referral::selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status');

        return view('office.referrals.index', [
            'referrals' => $query->paginate(25)->withQueryString(),
            'filter' => $filter,
            'counts' => $counts,
            'openCount' => $counts->except('closed')->sum(),
            'allCount' => $counts->sum(),
        ]);
    }

    public function show(Referral $referral)
    {
        return view('office.referrals.show', [
            'r' => $referral->load('screening', 'user.conversation', 'handler'),
        ]);
    }

    public function update(Request $request, Referral $referral)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Referral::STATUSES))],
            'counselor_notes' => ['nullable', 'string', 'max:10000'],
        ]);

        if ($data['status'] !== $referral->status) {
            $data['status_changed_at'] = now();
        }
        $data['handled_by'] = $request->user()->id;
        $referral->update($data);

        return back()->with('status', 'Referral '.$referral->ticket.' updated.');
    }
}
