<?php

namespace Tests\Feature;

use App\Models\Referral;
use App\Models\Screening;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BwongoFlowTest extends TestCase
{
    use RefreshDatabase;

    private function student(): User
    {
        return User::factory()->create(['role' => 'student']);
    }

    private function answers(array $phq, array $gad): array
    {
        return ['kind' => 'both', 'phq9' => $phq, 'gad7' => $gad, 'difficulty' => 1];
    }

    public function test_low_scores_show_self_help_and_no_referral_prompt(): void
    {
        $student = $this->student();

        $this->actingAs($student)
            ->post('/check-in', $this->answers(array_fill(0, 9, 0), array_fill(0, 7, 1)))
            ->assertRedirect();

        $s = Screening::first();
        $this->assertSame(0, $s->phq9_score);
        $this->assertSame(7, $s->gad7_score);
        $this->assertFalse($s->referral_suggested);

        $this->actingAs($student)->get("/results/{$s->id}")
            ->assertOk()
            ->assertSee('Things that may help')
            ->assertDontSee('Please reach out today');
    }

    public function test_self_harm_answer_shows_crisis_lines_and_marks_referral_urgent(): void
    {
        $student = $this->student();
        $phq = array_fill(0, 9, 0);
        $phq[8] = 1;

        $this->actingAs($student)->post('/check-in', $this->answers($phq, array_fill(0, 7, 0)));
        $s = Screening::first();
        $this->assertTrue($s->referral_suggested);

        $this->actingAs($student)->get("/results/{$s->id}")
            ->assertSee('Please reach out today')
            ->assertSee('0800 211 306');

        $this->actingAs($student)->post("/results/{$s->id}/referral", [
            'full_name' => 'Test Student', 'contact' => '0700000000', 'contact_method' => 'Phone call', 'consent' => '1',
        ])->assertRedirect();

        $this->assertSame('urgent', Referral::first()->urgency);

        $counselor = User::factory()->create(['role' => 'counselor']);
        $this->actingAs($counselor)->get('/office/referrals')->assertOk()->assertSee('Test Student');
        $this->actingAs($counselor)->get('/office/referrals/'.Referral::first()->id)->assertOk()->assertSee('Self-harm item answered');
        $this->actingAs($counselor)->get('/office/overview')->assertOk();
    }

    public function test_threshold_comes_from_settings(): void
    {
        Setting::put(['phq9_threshold' => '5']);
        $phq = [1, 1, 1, 1, 1, 0, 0, 0, 0];

        $this->actingAs($this->student())->post('/check-in', $this->answers($phq, array_fill(0, 7, 0)));

        $this->assertTrue(Screening::first()->referral_suggested);
    }

    public function test_referral_requires_consent(): void
    {
        $student = $this->student();
        $this->actingAs($student)->post('/check-in', $this->answers(array_fill(0, 9, 2), array_fill(0, 7, 2)));
        $s = Screening::first();

        $this->actingAs($student)->post("/results/{$s->id}/referral", [
            'full_name' => 'Test Student', 'contact' => '0700000000', 'contact_method' => 'Phone call',
        ])->assertSessionHasErrors('consent');

        $this->assertSame(0, Referral::count());
    }

    public function test_students_cannot_see_each_others_results_or_the_office(): void
    {
        $owner = $this->student();
        $this->actingAs($owner)->post('/check-in', $this->answers(array_fill(0, 9, 0), array_fill(0, 7, 0)));
        $s = Screening::first();

        $other = $this->student();
        $this->actingAs($other)->get("/results/{$s->id}")->assertNotFound();
        $this->actingAs($other)->get('/office/referrals')->assertForbidden();
    }

    public function test_office_sees_alias_not_name_in_messages_and_can_reply(): void
    {
        $student = $this->student();
        $this->actingAs($student)->post('/messages', ['body' => 'Hello, can I talk to someone?']);

        $counselor = User::factory()->create(['role' => 'counselor']);
        $conversation = $student->conversation()->first();

        $this->actingAs($counselor)->get("/office/messages/{$conversation->id}")
            ->assertOk()
            ->assertSee($student->alias())
            ->assertDontSee($student->name);

        $this->actingAs($counselor)->post("/office/messages/{$conversation->id}", ['body' => 'Yes, we are here.']);
        $this->actingAs($student)->get('/messages')->assertSee('Yes, we are here.');
    }

    public function test_only_admins_change_settings(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'counselor']))->get('/office/settings')->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'admin']))->get('/office/settings')->assertOk();
    }
}
