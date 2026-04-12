<div>
    <button class="no-print" onclick="window.print()"
        style="background-color: #32705F;color:white;padding:10px;font-size:15px;border-radius:10px;cursor: pointer;">प्रिन्ट
        गर्नुहोस्</button>
    <div class="printable-content">
        <h1 style="text-align: center;">कृषकको निक्षेप वित्तीय विवरण रिपोर्ट</h1>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>कृषक नम्बर</th>
                    <th>कृषकको नाम</th>
                    <th>फोन नम्बर</th>
                    <th>स्थान</th>
                    <th>निक्षेप रकम(रु)</th>
                    <th>मिति</th>
                </tr>
            </thead>
            <tbody>
                @if (count($depositTransactions) > 0)
                    @foreach ($depositTransactions as $key => $deposit)
                        <tr wire:key="{{ $key }}">
                            <td>{{$deposit->account->user->farmer_number}}</td>
                            <td>{{$deposit->account->user->owner_name}}</td>
                            <td>{{$deposit->account->user->phone_number}}</td>
                            <td>{{$deposit->account->user->location}}</td>
                            <td>{{$deposit->nepali_amount}}</td>
                            @php
                                $year = $deposit->created_at->format('Y');
                                $month = $deposit->created_at->format('m');
                                $day = $deposit->created_at->format('d');
                                $date = Bsdate::eng_to_nep($year, $month, $day);
                            @endphp
                            <td style="white-space: nowrap;">
                                {{ html_entity_decode($date['date']) . ' ' . html_entity_decode($date['nmonth']) . ' ' . html_entity_decode($date['year']) . ', ' . $date['day'] }}
                            </td>
                        </tr>
                    @endforeach
                @endif

                <tr>
                    <td class="fs-5 fw-semibold  bg-body-secondary">
                        कुल बचत
                    </td>
                    <td colspan="20" class="fs-5 fw-semibold  bg-body-secondary">
                        रु {{$sumDepositAmount}}
                    </td>
                </tr>
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

