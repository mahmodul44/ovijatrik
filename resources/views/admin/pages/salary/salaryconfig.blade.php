@extends('backend.master')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<section class="content pt-2">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card card-primary">
  <div class="card-header">
    <div class="row">
        <div class="col-md-6 text-left">
            <h3 class="card-title">Salary Configure</h3>
        </div>
    </div>
  </div>

  <!-- form start -->
<form role="form" id="salaryConfigureForm" method="POST" action="{{ route('salaryconfigupdate') }}">
    @csrf
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->mobile_no }}</td>
                        <td>
                            <input type="hidden" name="customers[{{ $customer->customer_id }}][id]" value="{{ $customer->customer_id }}">
                            <input type="number" name="customers[{{ $customer->customer_id }}][salary]" class="form-control" required value="{{ $customer->sallery ?? 0 }}" placeholder="Enter salary">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">
          <span class="esc-loading-button d-none">
              <i class="fa fa-spinner fa-spin"></i>
          </span>
          <span class="submit-btn">
              Submit
          </span>
      </button>
    </div>
</form>

</div>
</div>
</div>
</div>
</section>

@endsection


@section('script')
<script>
    $(document).ready(function() {
    $('#purchaseInsertForm').on('submit', function(e) {
        e.preventDefault();
        let thisForm = $(this);

        // Prepare purchase data
        var purchaseData = [];
        $('#purchase-table-body tr').each(function() {
            var row = $(this);
            var rowData = {
                'product_id': row.data('product-id'),
                'countingunitbuy': row.find('.cunit_id_buy').val(),
                'cunit_id': row.find('.cunit_id').val(),
                'price': row.find('.price').val(),
                'multiply_by': row.find('.multiply_by').val(),
                'buyunitquantity': row.find('.buyunit-quantity').val(),
                'basecunitQuantity': row.find('.basecunit-quantity').val(),
                'discount': row.find('.discount').val(),
                'subtotal': row.find('.subtotal').text(),
            };
            purchaseData.push(rowData);
        });

        // Append purchase data to form data
        var formData = new FormData(thisForm[0]);
        formData.append('purchase_data', JSON.stringify(purchaseData));

        // Send Ajax request
        $.ajax({
            type: "POST",
            url: "{{ route('purchase.store') }}",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                thisForm.find(".esc-loading-button").removeClass('d-none');
                thisForm.find('button[type="submit"]').html('Submitting...');
                thisForm.find('button[type="submit"]').prop("disabled", true);
                thisForm.find(".alert-success").removeClass('d-none');
                thisForm.find(".alert-danger").removeClass('d-none');
                thisForm.find(".alert-success").addClass('d-none');
                thisForm.find(".alert-danger").addClass('d-none');
                thisForm.find('.error').text('');
            },
            success: function(response) {
                thisForm.find(".esc-loading-button").addClass('d-none');
                thisForm.find('button[type="submit"]').html('Submitted');
                thisForm.find('button[type="submit"]').prop("disabled", false);
                thisForm.find(".alert-success").removeClass('d-none');
                toastr.success(response.message);

                setTimeout(function() {
                    location.href = "{{ route('purchase.index') }}";
                }, 1000);
            },
            error: function(xhr, status, error) {
                thisForm.find(".esc-loading-button").addClass('d-none');
                thisForm.find('button[type="submit"]').html('Submit');
                thisForm.find('button[type="submit"]').prop("disabled", false);
                thisForm.find(".alert-danger").removeClass('d-none');

                var responseText = jQuery.parseJSON(xhr.responseText);
                toastr.error(responseText.message);

                $.each(responseText.errors, function(key, val) {
                    thisForm.find("." + key + "-error").text(val[0]);
                });
            }
        });
    });
});
        
</script>
@endsection
