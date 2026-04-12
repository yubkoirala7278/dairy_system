<div>
    <button class="no-print" onclick="window.print()" style="background-color: #32705F;color:white;padding:10px;font-size:15px;border-radius:10px;cursor: pointer;">प्रिन्ट गर्नुहोस्</button>
    <div class="printable-content">
        <h1 style="text-align: center">कृषकहरूको सूची</h1>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>कृषक नम्बर</th>
                    <th>नाम</th>
                    <th>ठेगाना</th>
                    <th>लिङ्ग</th>
                    <th>फोन</th>
                    <th>अवस्था</th>
                </tr>
            </thead>
            <tbody>
                @if (count($users) > 0)
                    @foreach ($users as $key => $user)
                        <tr wire:key="{{ $key }}" style="text-align: center;">
                            <td>{{ $user->farmer_number }}</td>
                            <td>{{ $user->owner_name }}</td>
                            <td>{{ $user->location }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                <span class="badge {{ $user->status == 'चालू' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="20">प्रदर्शन गर्नको लागि कृषकहरू छैनन्..</td>
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

        th, td {
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
