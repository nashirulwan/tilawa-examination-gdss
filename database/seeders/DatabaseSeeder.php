<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Period;
use App\Models\Participant;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\Assessment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // 1. Users
            $admin = User::create([
                'name' => 'Committee Admin',
                'email' => 'admin@mtq.com',
                'password' => Hash::make('password'),
                'role' => 'committee',
            ]);

            $appraiser1 = User::create([
                'name' => 'Appraiser 1',
                'email' => 'appraiser1@mtq.com',
                'password' => Hash::make('password'),
                'role' => 'appraiser',
            ]);

            $appraiser2 = User::create([
                'name' => 'Appraiser 2',
                'email' => 'appraiser2@mtq.com',
                'password' => Hash::make('password'),
                'role' => 'appraiser',
            ]);

            $appraiser3 = User::create([
                'name' => 'Appraiser 3',
                'email' => 'appraiser3@mtq.com',
                'password' => Hash::make('password'),
                'role' => 'appraiser',
            ]);

            // 2. Period
            $period = Period::create([
                'name' => 'Tahun 2021',
                'year' => 2021,
                'is_active' => true,
            ]);

            // 3. Participants
            $departments = ['Computer Science', 'Information Systems', 'Information Technology', 'Software Engineering'];
        
            $participantData = [
                ['name' => 'Dewi Kartika', 'gender' => 'female', 'student_id' => '1001', 'period_id' => $period->id, 'department' => 'Computer Science'],
                ['name' => 'Anggraeni', 'gender' => 'female', 'student_id' => '1002', 'period_id' => $period->id, 'department' => 'Information Systems'],
                ['name' => 'Dedyka Syahputra', 'gender' => 'male', 'student_id' => '1003', 'period_id' => $period->id, 'department' => 'Information Technology'],
                ['name' => 'Adam Syahputra', 'gender' => 'male', 'student_id' => '1004', 'period_id' => $period->id, 'department' => 'Computer Science'],
                ['name' => 'Diana Asmarani Siregar', 'gender' => 'female', 'student_id' => '1005', 'period_id' => $period->id, 'department' => 'Software Engineering'],
            ];

            $participants = [];
            foreach ($participantData as $index => $p) {
                $participants['P' . ($index + 1)] = Participant::create($p);
            }

            // 4. Criteria & Sub-Criteria
            $criteriaData = [
                ['code' => 'K1', 'name' => 'Fashah', 'weight' => 30],
                ['code' => 'K2', 'name' => 'Tajweed', 'weight' => 35],
                ['code' => 'K3', 'name' => 'Voice', 'weight' => 20],
                ['code' => 'K4', 'name' => 'Song', 'weight' => 25],
            ];

            $subCriteriaOptions = [
                ['name' => 'Very precise', 'value' => 85],
                ['name' => 'Appropriate', 'value' => 65],
                ['name' => 'Not exactly', 'value' => 45],
                ['name' => 'Very Incorrect', 'value' => 25],
            ];

            $criteriaModels = [];
            foreach ($criteriaData as $c) {
                $crit = Criteria::create($c);
                $criteriaModels[$c['code']] = $crit;
                foreach ($subCriteriaOptions as $sc) {
                    SubCriteria::create(array_merge($sc, ['criteria_id' => $crit->id]));
                }
            }

            // 5. Assessments
            // Appraiser 1
            $scoresA1 = [
                'P1' => ['K1' => 65, 'K2' => 65, 'K3' => 65, 'K4' => 65],
                'P2' => ['K1' => 25, 'K2' => 25, 'K3' => 65, 'K4' => 45],
                'P3' => ['K1' => 25, 'K2' => 25, 'K3' => 65, 'K4' => 25],
                'P4' => ['K1' => 45, 'K2' => 45, 'K3' => 45, 'K4' => 45],
                'P5' => ['K1' => 25, 'K2' => 65, 'K3' => 65, 'K4' => 65],
            ];

            // Appraiser 2 (Updated P5 K4 to 25)
            $scoresA2 = [
                'P1' => ['K1' => 45, 'K2' => 45, 'K3' => 45, 'K4' => 45],
                'P2' => ['K1' => 45, 'K2' => 45, 'K3' => 45, 'K4' => 25],
                'P3' => ['K1' => 45, 'K2' => 45, 'K3' => 65, 'K4' => 65],
                'P4' => ['K1' => 45, 'K2' => 25, 'K3' => 45, 'K4' => 45],
                'P5' => ['K1' => 25, 'K2' => 45, 'K3' => 45, 'K4' => 45],
            ];

            // Appraiser 3 (New)
            $scoresA3 = [
                'P1' => ['K1' => 65, 'K2' => 65, 'K3' => 65, 'K4' => 45],
                'P2' => ['K1' => 45, 'K2' => 45, 'K3' => 45, 'K4' => 45],
                'P3' => ['K1' => 65, 'K2' => 45, 'K3' => 85, 'K4' => 65],
                'P4' => ['K1' => 25, 'K2' => 25, 'K3' => 45, 'K4' => 25],
                'P5' => ['K1' => 45, 'K2' => 65, 'K3' => 65, 'K4' => 45],
            ];

            foreach ($scoresA1 as $pKey => $scores) {
                foreach ($scores as $cKey => $val) {
                    Assessment::create([
                        'appraiser_id' => $appraiser1->id,
                        'participant_id' => $participants[$pKey]->id,
                        'criteria_id' => $criteriaModels[$cKey]->id,
                        'value' => $val, 
                    ]);
                }
            }

            foreach ($scoresA2 as $pKey => $scores) {
                foreach ($scores as $cKey => $val) {
                    Assessment::create([
                        'appraiser_id' => $appraiser2->id,
                        'participant_id' => $participants[$pKey]->id,
                        'criteria_id' => $criteriaModels[$cKey]->id,
                        'value' => $val,
                    ]);
                }
            }

            foreach ($scoresA3 as $pKey => $scores) {
                foreach ($scores as $cKey => $val) {
                    Assessment::create([
                        'appraiser_id' => $appraiser3->id,
                        'participant_id' => $participants[$pKey]->id,
                        'criteria_id' => $criteriaModels[$cKey]->id,
                        'value' => $val,
                    ]);
                }
            }
        } catch (\Exception $e) {
            fwrite(STDERR, "Seeder Error: " . $e->getMessage() . "\n");
            throw $e;
        }
    }
}
