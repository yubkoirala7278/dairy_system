<div>
    <button class="no-print" onclick="window.print()"
        style="background-color: #32705F;color:white;padding:10px;font-size:15px;border-radius:10px;cursor: pointer;">प्रिन्ट
        गर्नुहोस्</button>
    <div class="printable-content">
        <h1 style="text-align: center;">कृषकको निकासी वित्तीय विवरण रिपोर्ट</h1>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>कृषक नम्बर</th>
                    <th>कृषकको नाम</th>
                    <th>फोन नम्बर</th>
                    <th>स्थान</th>
                    <th>निकासी रकम(रु)</th>
                    <th>मिति</th>
                </tr>
            </thead>
            <tbody>
                @if (count($withdrawTransactions) > 0)
                    @foreach ($withdrawTransactions as $key => $withdraw)
                        <tr wire:key="{{ $key }}">
                            <td>{{$withdraw->account->user->farmer_number}}</td>
                            <td>{{$withdraw->account->user->owner_name}}</td>
                            <td>{{$withdraw->account->user->phone_number}}</td>
                            <td>{{$withdraw->account->user->location}}</td>
                            <td>{{$withdraw->nepali_amount}}</td>
                            @php
                                $year = $withdraw->created_at->format('Y');
                                $month = $withdraw->created_at->format('m');
                                $day = $withdraw->created_at->format('d');
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
                        रु {{$sumWithdrawAmount}}
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

