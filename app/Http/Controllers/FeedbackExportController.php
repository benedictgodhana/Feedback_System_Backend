<?php

namespace App\Http\Controllers;

use App\Exports\FeedbackExport;
use Maatwebsite\Excel\Facades\Excel;

class FeedbackExportController extends Controller
{
    public function export()
    {
        return Excel::download(new FeedbackExport(), 'feedback.xlsx');
    }
}
