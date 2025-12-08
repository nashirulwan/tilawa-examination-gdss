<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Period;
use App\Services\BordaCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculationVerificationTest extends TestCase
{
    // Do not verify DB here, just use the seeded data.
    // We assume Seed ran successfully. If we use RefreshDatabase, we need to run seeder.
    // But since we are testing against "seeded" state, we can skip RefreshDatabase if we just migrated.
    // Or better: use RefreshDatabase and $this->seed().
    
    use RefreshDatabase;

    public function test_journal_data_calculations()
    {
        $this->seed();
        
        $period = Period::where('year', 2021)->first();
        $service = app(BordaCalculationService::class);
        $results = $service->calculate($period);
        
        // Expected Results (from Journal "Hasil Akhir")
        // Dewi Kartika (P1): 780 (or 781.82? Journal table says 780, text says 781.82. I will log the output).
        // Dedyka Syahputra (P3): 518
        // Diana Asmarani Siregar (P5): 375
        // Anggraeni (P2): 236
        // Adam Syahputra (P4): 243.5 
        
        // Ranking: 1. P1, 2. P3, 3. P5, 4. P2/P4?
        // Journal Table 9 says: 1. P1, 2. P3, 3. P5, 4. P2 (236), 5. P4 (243.5).
        // Warning: 243.5 > 236. So P4 should be Rank 4? Journal Note: "Terdapat ketidaksesuaian urutan ranking 4 dan 5... urutan yang benar adalah..."
        // "Anggraeni (236.36) dan Adam Syahputra (161.37)" -> wait, different numbers in text?
        // Text: Adam 161.37?
        // I will just print the results to see what MY implementation yields using the Journal's FORMULA.
        
        echo "\n\nCalculation Results:\n";
        foreach ($results as $res) {
            echo "Rank " . $res['final_rank'] . ": " . $res['participant']->name . " (" . $res['total_borda_score'] . ")\n";
        }
        
        $this->assertCount(5, $results);
        $this->assertEquals('Dewi Kartika', $results[0]['participant']->name);
        $this->assertEquals(1, $results[0]['final_rank']);
    }
}
