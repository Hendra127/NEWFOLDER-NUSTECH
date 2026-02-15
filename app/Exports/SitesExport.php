<?php

namespace App\Exports;

use App\Models\Site;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SitesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $search = request('search');
        return Site::where('site_id', 'like', "%$search%")
                ->orWhere('sitename', 'like', "%$search%")
                ->get();
    }

    public function headings(): array
    {
        return [
            "ID", "SITE ID", "SITE CODE", "LOCATION ID", "SITENAME", "TIPE", "BATCH", "LATITUDE", "LONGITUDE", 
            "PROVINSI", "KABUPATEN", "KECAMATAN", "KELURAHAN", "ALAMAT LOKASI", 
            "NAMA PIC", "NOMOR PIC", "SUMBER LISTRIK", "GATEWAY AREA", "BEAM", 
            "HUB", "KODEFIKASI", "SN ANTENA", "SN MODEM", "SN ROUTER", "SN AP1", 
            "SN AP2", "SN TRANSCIEVER", "SN STABILIZER", "SN RAK", "IP MODEM", 
            "IP ROUTER", "IP AP1", "IP AP2", "EXPECTED SQF"
        ];
    }
}
