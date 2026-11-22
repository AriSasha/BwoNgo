<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Resource;
use App\Models\Screening;
use App\Models\Setting;
use App\Support\Screening as Instrument;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScreeningController extends Controller
{
    public function home()
    {
        return view('student.home');
    }

    public function create(Request $request)
    {
        $kind = $request->query('kind', 'both');
        abort_unless(array_key_exists($kind, Instrument::KINDS), 404);

        return view('student.screening', ['kind' => $kind]);
    }

    public function store(Request $request)
    {
        $kind = $request->input('kind');
        $rules = ['kind' => ['required', Rule::in(array_keys(Instrument::KINDS))]];
        $answer = ['required', 'integer', 'between:0,3'];

        if (Instrument::includesPhq9($kind)) {
            $rules['phq9'] = ['required', 'array', 'size:9'];
            $rules['phq9.*'] = $answer;
            $rules['difficulty'] = ['nullable', 'integer', 'between:0,3'];
        }
        if (Instrument::includesGad7($kind)) {
            $rules['gad7'] = ['required', 'array', 'size:7'];
            $rules['gad7.*'] = $answer;
        }

        $data = $request->validate($rules, [
            'phq9.*.required' => 'Please answer every mood question.',
            'gad7.*.required' => 'Please answer every anxiety question.',
        ]);

        $scored = Instrument::score($kind, $data);
        $screening = $request->user()->screenings()->create($scored + [
            'answers' => array_intersect_key($data, array_flip(['phq9', 'gad7', 'difficulty'])),
        ]);

        return redirect()->route('student.screenings.show', $screening);
    }

    public function show(Request $request, Screening $screening)
    {
        abort_unless($screening->user_id === $request->user()->id, 404);

        return view('student.result', [
            's' => $screening->load('referral'),
            'resources' => Resource::orderBy('position')->get(),
            'settings' => Setting::values(),
            'contactMethods' => Referral::CONTACT_METHODS,
        ]);
    }

    public function history(Request $request)
    {
        $user = $request->user();

        return view('student.history', [
            'screenings' => $user->screenings()->latest()->get(),
            'referrals' => $user->referrals()->latest()->get(),
        ]);
    }
}
