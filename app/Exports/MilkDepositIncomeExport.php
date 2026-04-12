<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class MilkDepositIncomeExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $milkDepositsIncome, $total_milk_quantity_nepali, $total_milk_price_nepali;

    public function __construct(Collection $milkDepositsIncome, $totals)
    {
        $this->milkDepositsIncome = $milkDepositsIncome;
        $this->total_milk_quantity_nepali = $totals['total_milk_quantity_nepali'];
        $this->total_milk_price_nepali = $totals['total_milk_price_nepali'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->milkDepositsIncome;
    }

    /**
     * Define the headings for the export file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'कृ.न.',            // Farmer Number
            'कृषक नाम',         // Farmer Name
            'फोन नम्बर',        // Phone Number
            'मिति',              // Date
            'प्रहर',             // Time
            'दूध लि.',          // Milk Quantity
            'जम्मा(रु)',        // Total Amount
        ];
    }

    /**
     * Map the data to Excel columns.
     *
     * @param mixed $milkIncome
     * @return array
     */
    public function map($milkIncome): array
    {
        return [
            $milkIncome->user->farmer_number,          // Farmer Number
            $milkIncome->user->owner_name,             // Farmer Name
            $milkIncome->user->phone_number,           // Phone Number
            $milkIncome->milkDeposits->milk_deposit_date,  // Milk Deposit Date
            $milkIncome->milkDeposits->milk_deposit_time,  // Milk Deposit Time
            $milkIncome->milkDeposits->milk_quantity_nepali, // Milk Quantity in Nepali
            $milkIncome->deposit_nepali,               // Total Deposit in Nepali Rupees
        ];
    }

    /**
     * Apply styles to the exported Excel sheet.
     *
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        // Set bold for the headings
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(15); // Farmer Number
        $sheet->getColumnDimension('B')->setWidth(20); // Farmer Name
        $sheet->getColumnDimension('C')->setWidth(15); // Phone Number
        $sheet->getColumnDimension('D')->setWidth(15); // Date
        $sheet->getColumnDimension('E')->setWidth(15); // Time
        $sheet->getColumnDimension('F')->setWidth(15); // Milk Quantity
        $sheet->getColumnDimension('G')->setWidth(15); // Total Amount
    }

    /**
     * Register events for the export.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Calculate the row number for totals
                $lastRow = $this->milkDepositsIncome->count() + 2;

                // Add totals to the last row
                $sheet->setCellValue('E' . $lastRow, 'जम्मा (Total)'); // Label for totals in Nepali
                $sheet->setCellValue('F' . $lastRow, $this->total_milk_quantity_nepali); // Total Milk Quantity
                $sheet->setCellValue('G' . $lastRow, $this->total_milk_price_nepali);    // Total Milk Price

                // Style the headings and totals row
                $sheet->getStyle('A1:G1')->getFont()->setBold(true); // Bold for headings
                $sheet->getStyle('A' . $lastRow . ':G' . $lastRow)->getFont()->setBold(true); // Bold for totals row

                // Set normal font weight for other rows
                $sheet->getStyle('A2:G' . ($lastRow - 1))->getFont()->setBold(false);
            },
        ];
    }
}