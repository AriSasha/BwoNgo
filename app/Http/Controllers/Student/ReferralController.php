<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReferralController extends Controller
{
    public function store(Request $request, Screening $screening)
    {
        abort_unless($screening->user_id === $request->user()->id, 404);

        if ($screening->referral) {
            return redirect()->route('student.screenings.show', $screening);
        }

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'student_number' => ['nullable', 'string', 'max:30'],
            'contact' => ['required', 'string', 'max:120'],
            'contact_method' => ['required', Rule::in(Referral::CONTACT_METHODS)],
            'preferred_time' => ['nullable', 'string', 'max:120'],
            'note' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Tick the consent box so the office is allowed to contact you.',
            'contact.required' => 'Add a phone number or email so the office can reach you.',
        ]);

        $referral = $screening->referral()->create($data + [
            'ticket' => Referral::newTicket(),
            'user_id' => $request->user()->id,
            'consent' => true,
            'urgency' => Referral::urgencyFor($screening),
            'status' => 'new',
            'status_changed_at' => now(),
        ]);

        return redirect()->route('student.screenings.show', $screening)
            ->with('status', 'Referral '.$referral->ticket.' sent.');
    }
}
