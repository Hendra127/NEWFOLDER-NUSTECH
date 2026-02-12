<?php

namespace App\Imports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\ToModel;

class CloseTicketImport implements ToModel
{
    public function model(array $row)
    {
        // Ini contoh basic (karena format excel tiap project beda)
        // Kalau kamu punya template excel, kirim, nanti aku sesuaikan.
        return null;
    }
}
