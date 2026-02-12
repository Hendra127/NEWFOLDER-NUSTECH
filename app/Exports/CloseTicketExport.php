<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;

class CloseTicketExport implements FromCollection
{
    public function collection()
    {
        return Ticket::where('status', 'close')->get();
    }
}
