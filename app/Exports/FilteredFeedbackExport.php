<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class FilteredFeedbackExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    protected $filteredFeedback;

    public function __construct(Collection $filteredFeedback)
    {
        $this->filteredFeedback = $filteredFeedback;
    }

    public function collection()
    {
        return $this->filteredFeedback;
    }

    public function map($feedback): array
    {
        $categoryName = optional($feedback->category)->name;
        $subcategoryName = optional($feedback->subcategory)->name;

        return [
            $categoryName,
            $subcategoryName,
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
            'Feedback Subcategory',
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
            'A1:G1' => ['font' => ['bold' => true]],
        ];
    }
}
