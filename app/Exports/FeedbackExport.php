<?php

namespace App\Exports;

use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class FeedbackExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    public function collection()
    {
        return Feedback::with('category')->get();
    }

    public function map($feedback): array
    {
        return [
            $feedback->category->name,
            $feedback->subject,
            $feedback->name,
            $feedback->email,
            $feedback->feedback,
            $feedback->status,
            // Add other fields as needed
        ];
    }

    public function headings(): array
    {
        return [
            'Feedback Category',
            'Subject',
            'Name',
            'Email',
            'Feedback',
            'Status',
            // Add other headings as needed
        ];
    }

    public function styles($sheet)
    {
        return [
            'A1:F1' => ['font' => ['bold' => true]],
        ];
    }
}
