<?php

namespace App\Imports;

use App\Models\Site;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SitesImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; 
    }

    public function model(array $row)
    {
        if (empty($row[0])) {
            return null;
        }

        // updateOrCreate: Jika site_id sudah ada, maka data akan diupdate.
        // Jika belum ada, maka data akan dibuat baru.
        return Site::updateOrCreate(
            [
                'site_id' => trim($row[0]) // Kolom kunci untuk pencarian
            ],
            [
                'site_code'     => trim($row[0]),
                // 'location_id' => null, // Biarkan null jika sudah menjalankan opsi A (nullable)
                
                'sitename'      => $row[1] ?? null,
                'tipe'          => $row[2] ?? null,
                'batch'         => $row[3] ?? null,
                'latitude'      => $row[4] ?? null,
                'longitude'     => $row[5] ?? null,
                'provinsi'      => $row[6] ?? null,
                'kab'           => $row[7] ?? null,
                'kecamatan'     => $row[8] ?? null,
                'kelurahan'     => $row[9] ?? null,
                'alamat_lokasi' => $row[10] ?? null,
                'nama_pic'      => $row[11] ?? null,
                'nomor_pic'     => $row[12] ?? null,
                'sumber_listrik'=> $row[13] ?? null,
                'gateway_area'  => $row[14] ?? null,
                'beam'          => $row[15] ?? null,
                'hub'           => $row[16] ?? null,
                'kodefikasi'    => $row[17] ?? null,
                'sn_antena'     => $row[18] ?? null,
                'sn_modem'      => $row[19] ?? null,
                'sn_router'     => $row[20] ?? null,
                'sn_ap1'        => $row[21] ?? null,
                'sn_ap2'        => $row[22] ?? null,
                'sn_tranciever' => $row[23] ?? null,
                'sn_stabilizer' => $row[24] ?? null,
                'sn_rak'        => $row[25] ?? null,
                'ip_modem'      => $row[26] ?? null,
                'ip_router'     => $row[27] ?? null,
                'ip_ap1'        => $row[28] ?? null,
                'ip_ap2'        => $row[29] ?? null,
                'expected_sqf'  => $row[30] ?? null,
            ]
        );
    }
}