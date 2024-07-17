<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeedbackExport implements FromCollection, WithHeadings
{
    protected $feedback;

    public function __construct(array $feedback)
    {
        $this->feedback = $feedback;
    }

    public function collection()
    {
        return collect($this->feedback);
    }

    public function headings(): array
    {
        return [
            'Category',
            'Subcategory',
            'Subject',
            'Name',
            'Email',
            'Feedback',
            'Status',
        ];
    }
}
