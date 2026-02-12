<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed sample sites
        $sites = [
            [
                'site_id' => 'AMI00270000365054N',
                'sitename' => 'MS JAYA BERSAMA SEJAYAP',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365028N',
                'sitename' => 'SD NEGERI GIS TANA TIDUNG',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365045N',
                'sitename' => 'SMP NEGERI 2 TANA TIDUNG',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365062N',
                'sitename' => 'SD NEGERI GIS TANA TIDUNG',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365071N',
                'sitename' => 'MTSI AL MADAIN SEJAYAP',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365087N',
                'sitename' => 'SDN DS0 TANA TIDUNG',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365096N',
                'sitename' => 'SMP NEGERI 2 TANA TIDUNG',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365104N',
                'sitename' => 'KANTOR DESA JRATU',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365113N',
                'sitename' => 'SMP NEGERI 1 TANA TIDUNG',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
            [
                'site_id' => 'AMI00270000365121N',
                'sitename' => 'KANTOR DESA SEMUNYING',
                'tipe' => 'SEWA LAYANAN',
                'batch' => 'BATCH 2A- NEWSITE 8, 2024',
                'latitude' => '-3.60980600',
                'longitude' => '88.00780700',
                'provinsi' => 'KALIMANTAN UTARA',
                'kab' => 'KAB TANA TIDUNG',
            ],
        ];

        foreach ($sites as $site) {
            Site::create($site);
        }
    }
}
