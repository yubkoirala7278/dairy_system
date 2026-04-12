<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TransactionExport implements FromCollection, WithHeadings, WithColumnWidths
{
    protected $usersWithTransaction;
    protected $totalBalance;

    // Constructor to inject the data
    public function __construct($usersWithTransaction, $totalBalance)
    {
        $this->usersWithTransaction = $usersWithTransaction;
        $this->totalBalance = $totalBalance;
    }

    /**
     * Return the collection of data to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = collect($this->usersWithTransaction)->map(function ($user) {
            return [
                $user->user->farmer_number,
                $user->user->owner_name,
                $user->user->phone_number,
                $user->user->location,
                $user->nepali_balance,  // Assuming the balance is already converted to Nepali format
            ];
        });

        // Adding the total balance row at the end
        $data->push([
            'कुल बचत', // Column 1 (will leave it empty for total row)
            '',
            '',
            '',
            $this->totalBalance, // The total balance in the last column
        ]);

        return $data;
    }

    /**
     * Return the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'कृषक नम्बर',
            'कृषकको नाम',
            'फोन नम्बर',
            'स्थान',
            'कुल रकम(रु)',
        ];
    }

    /**
     * Return the column widths for the Excel file.
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15, // Width for column A (कृषक नम्बर)
            'B' => 25, // Width for column B (कृषकको नाम)
            'C' => 15, // Width for column C (फोन नम्बर)
            'D' => 20, // Width for column D (स्थान)
            'E' => 15, // Width for column E (कुल रकम(रु))
        ];
    }
}