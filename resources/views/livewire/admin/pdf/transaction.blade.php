<div>
    <button class="no-print" onclick="window.print()"
        style="background-color: #32705F;color:white;padding:10px;font-size:15px;border-radius:10px;cursor: pointer;">प्रिन्ट
        गर्नुहोस्</button>
    <div class="printable-content">
        <h1 style="text-align: center;">कृषकको वित्तीय विवरण रिपोर्ट</h1>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>कृषक नम्बर</th>
                    <th>कृषकको नाम</th>
                    <th> फोन नम्बर</th>
                    <th>स्थान</th>
                    <th>कुल रकम(रु)</th>
                </tr>
            </thead>
            <tbody>
                @if (count($usersWithTransaction) > 0)
                    @foreach ($usersWithTransaction as $key => $user)
                        <tr wire:key="{{ $key }}">
                            <td>{{ $user->user->farmer_number }}</td>
                            <td>{{ $user->user->owner_name }}</td>
                            <td>{{ $user->user->phone_number }}</td>
                            <td>{{ $user->user->location }}</td>
                            <td>{{ $user->nepali_balance }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="background-color: #E9ECEF; font-size: 1.25rem;font-weight: 600;">
                            कुल बचत
                        </td>
                        <td colspan="20" style="background-color: #E9ECEF; font-size: 1.25rem;font-weight: 600;">
                            रु {{$totalBalance}}
                        </td>
                    </tr>
                @endif
                @if (count($usersWithTransaction) <= 0)
                    <tr class="text-center">
                        <td colspan="20">प्रदर्शन गर्नका लागि कुनै किसान छैनन्</td>
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
