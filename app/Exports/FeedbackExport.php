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
                                return Feedback::with('category', 'subcategory')->get();
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
