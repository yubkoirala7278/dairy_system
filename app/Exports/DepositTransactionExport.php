<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Bsdate;

class DepositTransactionExport implements FromCollection, WithHeadings, WithColumnWidths
{
    protected $depositTransactions;
    protected $sumDepositAmount;

    // Constructor to inject the data
    public function __construct($depositTransactions, $sumDepositAmount)
    {
        $this->depositTransactions = $depositTransactions;
        $this->sumDepositAmount = $sumDepositAmount;
    }

    /**
     * Return the collection of data to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = collect($this->depositTransactions)->map(function ($transaction) {
            // Convert created_at date to Nepali
            $year = $transaction->created_at->format('Y');
            $month = $transaction->created_at->format('m');
            $day = $transaction->created_at->format('d');
            $date = Bsdate::eng_to_nep($year, $month, $day);

            // Return the data for each row
            return [
                $transaction->account->user->farmer_number,
                $transaction->account->user->owner_name,
                $transaction->account->user->phone_number,
                $transaction->account->user->location,
                $transaction->nepali_amount,  // Assuming the amount is already converted to Nepali format
                html_entity_decode($date['date']) . ' ' . html_entity_decode($date['nmonth']) . ' ' . html_entity_decode($date['year']) . ', ' . $date['day'] // Nepali date in last column
            ];
        });

        // Adding the total balance row at the end
        $data->push([
            'कुल बचत', // Column 1 (will leave it empty for total row)
            '',
            '',
            '',
            $this->sumDepositAmount, // The total balance in the last column
            '', // Empty cell for the date in the last row
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
            'निक्षेप रकम(रु)',
            'मिति',  // Add Nepali date heading
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
            'F' => 20, // Width for column F (मिति)
        ];
    }
}

