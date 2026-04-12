<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class MilkDepositExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $milkDeposits, $total_milk_deposits, $total_milk_price, $milk_deposit_date, $milk_deposit_time;

    public function __construct(Collection $milkDeposits, $total_milk_deposits, $total_milk_price, $milk_deposit_date, $milk_deposit_time)
    {
        $this->milkDeposits = $milkDeposits;
        $this->total_milk_deposits = $total_milk_deposits;
        $this->total_milk_price = $total_milk_price;
        $this->milk_deposit_date = $milk_deposit_date;
        $this->milk_deposit_time = $milk_deposit_time;
    }

    public function collection()
    {
        $this->milkDeposits->push((object)[
            'user' => (object)[
                'farmer_number' => '',
                'owner_name' => 'कुल',
            ],
            'milk_type' => '',
            'milk_quantity' => $this->total_milk_deposits,
            'milk_fat' => '',
            'milk_snf' => '',
            'milk_per_ltr_price_with_commission' => '',
            'milk_total_price' => $this->total_milk_price,
        ]);

        return $this->milkDeposits;
    }

    public function headings(): array
    {
        $dynamicHeading = 'दूध जम्मा मिति: ' . $this->milk_deposit_date . ' ' . $this->milk_deposit_time;

        return [
            [$dynamicHeading],
            [
                'कृषक नम्बर',
                'कृषक नाम',
                'प्रकार',
                'दूध लि.',
                'FAT',
                'SNF',
                'प्र.लि(रु)',
                'जम्मा(रु)'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->milkDeposits->count() + 2; // Total rows (data + headings)
        $lastRow = $rowCount; // The last row for totals

        // Center and bold the dynamic heading
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Bold the headings
        $sheet->getStyle('A2:H2')->getFont()->setBold(true);

        // Left-align all other cells
        $sheet->getStyle('A3:H' . $lastRow)->getAlignment()->setHorizontal('left');

        // Bold the last row
        $sheet->getStyle("A{$lastRow}:H{$lastRow}")->getFont()->setBold(true);
    }

    public function map($milkDeposit): array
    {
        return [
            $milkDeposit->user->farmer_number,
            $milkDeposit->user->owner_name,
            $milkDeposit->milk_type,
            $milkDeposit->milk_quantity,
            $milkDeposit->milk_fat,
            $milkDeposit->milk_snf,
            $milkDeposit->milk_per_ltr_price_with_commission,
            $milkDeposit->milk_total_price,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Farmer Number
            'B' => 30, // Farmer Name
            'C' => 15, // Milk Type
            'D' => 15, // Milk Quantity
            'E' => 10, // FAT
            'F' => 10, // SNF
            'G' => 20, // Price per liter with commission
            'H' => 20, // Total Price
        ];
    }
}