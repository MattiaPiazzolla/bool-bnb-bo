@extends('dashboard')

@section('main-content')
<div class="container py-5">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h2 class="text-center mb-4">Secure Payment</h2>
                <div id="dropin-container" class="mb-4"></div>
                <button id="submit-button" class="btn btn-primary btn-block btn-lg">Submit Payment</button>
            </div>
        </div>
    </div>
</div>

<script>
    var button = document.querySelector('#submit-button');
    braintree.dropin.create({
        authorization: '{{ $token }}',
        container: '#dropin-container'
    }, function (createErr, instance) {
        button.addEventListener('click', function () {
            instance.requestPaymentMethod(function (err, payload) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.subscriptions.braintree') }}",
                    data: {nonce: payload.nonce},
                    success: function (data) {
                        console.log('success', payload.nonce);
                    },
                    error: function (data) {
                        console.log('error', payload.nonce);
                    }
                });
            });
        });
    });
</script>
@endsection
