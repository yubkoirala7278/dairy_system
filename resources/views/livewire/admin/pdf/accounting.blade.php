<div>
    <button class="no-print" onclick="window.print()"
        style="background-color: #32705F;color:white;padding:10px;font-size:15px;border-radius:10px;cursor: pointer;">प्रिन्ट
        गर्नुहोस्</button>
    <div class="printable-content">
        <h1 style="text-align: center;">दुध सङ्कलन रिपोर्ट</h1>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>कृ.न.</th>
                    <th>कृषक नाम</th>
                    <th>फोन नम्बर</th>
                    <th>मिति</th>
                    <th>प्रहर</th>
                    <th>दूध लि.</th>
                    <th>जम्मा(रु)</th>
                </tr>
            </thead>
            <tbody>
                @if (count($milkDepositsIncome) > 0)
                    @foreach ($milkDepositsIncome as $key => $milkIncome)
                        <tr wire:key="{{ $key }}">
                            <td>{{ $milkIncome->user->farmer_number }}</td>
                            <td>{{ $milkIncome->user->owner_name }}</td>
                            <td>{{ $milkIncome->user->phone_number }}</td>
                            <td>{{ $milkIncome->milkDeposits->milk_deposit_date }}</td>
                            <td>{{ $milkIncome->milkDeposits->milk_deposit_time }}</td>
                            <td>{{ $milkIncome->milkDeposits->milk_quantity_nepali }}</td>
                            <td>{{ $milkIncome->deposit_nepali }}</td>
                        </tr>
                    @endforeach
                    <tr class="text-white" style="background-color: #32705f">
                        <td colspan="2" style="color:white">कुल दूध संकलन: {{ $totalMilkQuantity }} लिटर </td>
                        <td colspan="20" style="color:white">कुल मूल्य: {{ $totalMilkTotalPrice }} रुपैया</td>
                    </tr>
                @endif
                @if (count($milkDepositsIncome) <= 0)
                    <tr class="text-center">
                        <td colspan="20">प्रदर्शन गर्न दुध डिपोजिट आय उपलब्ध छैन।</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <style>
        /* General styles */
        body {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        /* Hide elements not meant for print */
        @media print {
            .no-print {
                display: none;
            }

            /* Ensure printable-content is visible */
            .printable-content {
                display: block;
                margin: 10px;
                padding: 0;
            }

            /* Remove page margins */
            @page {
                margin: 0;
            }

            body {
                margin: 0;
            }
        }
    </style>
</div>
