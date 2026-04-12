<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $users;
    protected $total_users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
        $this->total_users = $users->count();
    }

    /**
     * Return the collection of users.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Add a total row at the end of the collection
        $this->users->push((object)[
            'farmer_number' => '',
            'owner_name' => 'जम्मा', // Total in Nepali
            'location' => '',
            'gender' => '',
            'phone_number' => '',
            'status' => $this->convertToNepali($this->total_users), // Total user count in Nepali numerals
        ]);

        return $this->users;
    }

    /**
     * Return the headings for the export file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            ['कृषकहरूको विवरण'], // Top heading
            [
                'कृषक नम्बर', // Farmer number
                'नाम',          // Name
                'ठेगाना',       // Location
                'लिङ्ग',         // Gender
                'फोन',          // Phone number
                'अवस्था',        // Status
            ],
        ];
    }

    /**
     * Map the data to the export file.
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->farmer_number,
            $user->owner_name,
            $user->location,
            $user->gender,
            $user->phone_number,
            $user->status,
        ];
    }

    /**
     * Apply styles to the spreadsheet.
     *
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->users->count()+1; // Total rows including the data and total row
        $lastRow = $rowCount + 1; // Account for the headings

        // Style for the top heading
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Bold the column headings
        $sheet->getStyle('A2:F2')->getFont()->setBold(true);

        // Left-align all rows except the top heading
        $sheet->getStyle('A3:F' . $lastRow)->getAlignment()->setHorizontal('left');

        // Bold the total row
        $sheet->getStyle("A{$lastRow}:F{$lastRow}")->getFont()->setBold(true);
    }

    /**
     * Set column widths for better readability.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // Farmer Number
            'B' => 30, // Name
            'C' => 25, // Location
            'D' => 15, // Gender
            'E' => 20, // Phone Number
            'F' => 20, // Status
        ];
    }

    /**
     * Convert numbers to Nepali numerals.
     *
     * @param int $number
     * @return string
     */
    private function convertToNepali(int $number): string
    {
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $nepaliNumbers = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
        return str_replace($englishNumbers, $nepaliNumbers, (string)$number);
    }
}