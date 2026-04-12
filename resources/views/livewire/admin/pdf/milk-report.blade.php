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
                    <th>मिति</th>
                    <th>प्रहर</th>
                    <th>कृषक नाम</th>
                    <th>प्रकार</th>
                    <th>दूध लि.</th>
                    <th>FAT</th>
                    <th>SNF</th>
                    <th>मूल्य(रु)</th>
                    <th>कुल कमिशन(रु)</th>
                    <th>प्र.लि(रु)</th>
                    <th>जम्मा(रु)</th>
                </tr>
            </thead>
            <tbody>
                @if (count($milkDeposits) > 0)
                    @foreach ($milkDeposits as $key => $deposit)
                        <tr wire:key="{{ $key }}">
                            <td>{{ $deposit->user->farmer_number }}</td>
                            <td>{{$deposit->milk_deposit_date}}</td>
                            <td>{{$deposit->milk_deposit_time}}</td>
                            <td>{{ $deposit->user->owner_name }}</td>
                            <td>{{ $deposit->milk_type }}</td>
                            <td>{{ $deposit->milk_quantity }}</td>
                            <td>{{ $deposit->milk_fat }}</td>
                            <td>{{ $deposit->milk_snf }}</td>
                            <td>{{$deposit->milk_price_per_ltr}}</td>
                            <td>{{$deposit->per_ltr_commission}}</td>
                            <td>{{ $deposit->milk_per_ltr_price_with_commission }}</td>
                            <td>{{ $deposit->milk_total_price }}</td>
                        </tr>
                    @endforeach
                    <tr >
                        <td colspan="2" >कुल दूध संकलन: {{$totalMilkQuantity}} लिटर </td>
                        <td colspan="20">कुल मूल्य: {{$totalDepositIncome}} रुपैया</td>
                    </tr>
                @endif
                @if (count($milkDeposits) <= 0)
                    <tr class="text-center">
                        <td colspan="20">दूध सङ्कलन देखाउनको लागि कुनै डेटा छैन..</td>
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
