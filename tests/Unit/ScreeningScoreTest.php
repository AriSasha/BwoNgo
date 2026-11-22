<?php

namespace Tests\Unit;

use App\Support\Screening;
use PHPUnit\Framework\TestCase;

class ScreeningScoreTest extends TestCase
{
    public function test_phq9_bands_follow_published_cut_offs(): void
    {
        $this->assertSame('Minimal', Screening::phq9Band(4)[0]);
        $this->assertSame('Mild', Screening::phq9Band(5)[0]);
        $this->assertSame('Moderate', Screening::phq9Band(10)[0]);
        $this->assertSame('Moderately severe', Screening::phq9Band(15)[0]);
        $this->assertSame('Severe', Screening::phq9Band(20)[0]);
    }

    public function test_gad7_bands_follow_published_cut_offs(): void
    {
        $this->assertSame('Minimal', Screening::gad7Band(4)[0]);
        $this->assertSame('Mild', Screening::gad7Band(9)[0]);
        $this->assertSame('Moderate', Screening::gad7Band(14)[0]);
        $this->assertSame('Severe', Screening::gad7Band(15)[0]);
    }
}
