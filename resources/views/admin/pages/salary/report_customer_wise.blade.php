<table class="table table-bordered">
    <thead style="text-align:center;">
        <tr>
            <th>#</th>
            <th>DSR নাম</th>
            <th>DSR মোবাইল</th>
            <th>সেলারী</th>
        </tr>
    </thead>
    <tbody>
        @php $totalSalary = 0; @endphp
        @foreach($salaries as $salary)
            @foreach($salary->salaryDetails as $key =>$detail)
                <tr>
                    <td align="center">{{ en2bn($key+1) }}</td>
                    <td>{{ $detail->customer->customer_name }}</td>
                    <td align="center">{{ en2bn($detail->customer->mobile_no) }}</td>
                    <td>{{ en2bn(number_format($detail->salary_amount,2)) }}</td>
                </tr>
                @php $totalSalary += $detail->salary_amount; @endphp
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" style="text-align: right;">মোট সেলারী</th>
            <th>{{ en2bn(number_format($totalSalary,2)) }}</th>
        </tr>
    </tfoot>
</table>
