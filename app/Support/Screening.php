<?php

namespace App\Support;

use App\Models\Setting;

/**
 * PHQ-9 and GAD-7 questions, scoring and severity bands.
 * Wording follows the published instruments (Kroenke, Spitzer & Williams 2001; Spitzer et al. 2006).
 */
class Screening
{
    public const STEM = 'Over the last 2 weeks, how often have you been bothered by the following?';

    public const OPTIONS = ['Not at all', 'Several days', 'More than half the days', 'Nearly every day'];

    public const DIFFICULTY_QUESTION = 'If you checked off any problems, how difficult have these problems made it for you to do your work, take care of things at home, or get along with other people?';

    public const DIFFICULTY = ['Not difficult at all', 'Somewhat difficult', 'Very difficult', 'Extremely difficult'];

    public const PHQ9 = [
        'Little interest or pleasure in doing things',
        'Feeling down, depressed, or hopeless',
        'Trouble falling or staying asleep, or sleeping too much',
        'Feeling tired or having little energy',
        'Poor appetite or overeating',
        'Feeling bad about yourself, or that you are a failure or have let yourself or your family down',
        'Trouble concentrating on things, such as reading the newspaper or watching television',
        'Moving or speaking so slowly that other people could have noticed. Or the opposite: being so fidgety or restless that you have been moving around a lot more than usual',
        'Thoughts that you would be better off dead, or of hurting yourself in some way',
    ];

    public const GAD7 = [
        'Feeling nervous, anxious, or on edge',
        'Not being able to stop or control worrying',
        'Worrying too much about different things',
        'Trouble relaxing',
        'Being so restless that it is hard to sit still',
        'Becoming easily annoyed or irritable',
        'Feeling afraid, as if something awful might happen',
    ];

    public const KINDS = [
        'both' => 'Full check-in',
        'phq9' => 'Mood only',
        'gad7' => 'Anxiety only',
    ];

    /** Crisis lines shown whenever PHQ-9 question 9 is answered above zero. */
    public const CRISIS_LINES = [
        ['number' => '999 or 112', 'name' => 'Police and emergency, Uganda', 'hours' => '24 hours'],
        ['number' => '0800 211 306', 'name' => 'Butabika National Referral Mental Hospital', 'hours' => 'Toll-free'],
        ['number' => '0800 21 21 21', 'name' => 'Mental Health Uganda counselling line', 'hours' => 'Toll-free, weekdays 8:30am to 5pm'],
    ];

    public static function includesPhq9(string $kind): bool
    {
        return $kind !== 'gad7';
    }

    public static function includesGad7(string $kind): bool
    {
        return $kind !== 'phq9';
    }

    public static function phq9Band(int $score): array
    {
        return match (true) {
            $score <= 4 => ['Minimal', 'ok'],
            $score <= 9 => ['Mild', 'mild'],
            $score <= 14 => ['Moderate', 'warn'],
            $score <= 19 => ['Moderately severe', 'high'],
            default => ['Severe', 'high'],
        };
    }

    public static function gad7Band(int $score): array
    {
        return match (true) {
            $score <= 4 => ['Minimal', 'ok'],
            $score <= 9 => ['Mild', 'mild'],
            $score <= 14 => ['Moderate', 'warn'],
            default => ['Severe', 'high'],
        };
    }

    public static function toneFor(?string $band): string
    {
        return match ($band) {
            'Minimal' => 'ok',
            'Mild' => 'mild',
            'Moderate' => 'warn',
            null => 'neutral',
            default => 'high',
        };
    }

    /**
     * Score a submitted set of answers.
     *
     * @param  array{phq9?: array<int,int>, gad7?: array<int,int>, difficulty?: int|null}  $answers
     */
    public static function score(string $kind, array $answers): array
    {
        $result = [
            'kind' => $kind,
            'phq9_score' => null,
            'gad7_score' => null,
            'phq9_item9' => 0,
            'phq9_band' => null,
            'gad7_band' => null,
            'difficulty' => $answers['difficulty'] ?? null,
        ];

        if (self::includesPhq9($kind)) {
            $result['phq9_score'] = array_sum(array_map('intval', $answers['phq9']));
            $result['phq9_item9'] = (int) $answers['phq9'][8];
            $result['phq9_band'] = self::phq9Band($result['phq9_score'])[0];
        }

        if (self::includesGad7($kind)) {
            $result['gad7_score'] = array_sum(array_map('intval', $answers['gad7']));
            $result['gad7_band'] = self::gad7Band($result['gad7_score'])[0];
        }

        $result['referral_suggested'] = self::suggestsReferral($result);

        return $result;
    }

    /** True when the institution's referral threshold is met, or self-harm thoughts were reported. */
    public static function suggestsReferral(array $r): bool
    {
        $settings = Setting::values();

        return $r['phq9_item9'] > 0
            || ($r['phq9_score'] !== null && $r['phq9_score'] >= (int) $settings['phq9_threshold'])
            || ($r['gad7_score'] !== null && $r['gad7_score'] >= (int) $settings['gad7_threshold']);
    }

    public static function interpretation(string $scale, string $band): string
    {
        $what = $scale === 'phq9' ? 'Low mood' : 'Anxiety';

        return match ($band) {
            'Minimal' => 'Few signs of '.($scale === 'phq9' ? 'low mood' : 'anxiety').' right now.',
            'Mild' => 'Some signs of '.($scale === 'phq9' ? 'low mood' : 'anxiety').'. Worth keeping an eye on.',
            'Moderate' => $what.' is affecting you. Talking to a counselor is recommended.',
            'Moderately severe' => $what.' is having a real impact. Please talk to a counselor.',
            default => $what.' is having a serious impact. Please talk to a counselor soon.',
        };
    }
}
