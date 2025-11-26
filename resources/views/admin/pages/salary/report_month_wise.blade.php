<table class="table table-bordered">
    <thead>
        <tr>
            <th>মাস</th>
            <th>মোট সেলারী (টাকা)</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @foreach($monthlySalaries as $month => $total)
            <tr>
                <td>{{ en2bn(date('F', mktime(0, 0, 0, $month, 10))) }}</td>
                <td>{{ en2bn(number_format($total,2)) }}</td>
            </tr>
            @php $grandTotal += $total; @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align:right;">সর্বমোট</th>
            <th>{{ en2bn(number_format($grandTotal,2)) }}</th>
        </tr>
    </tfoot>
</table>
