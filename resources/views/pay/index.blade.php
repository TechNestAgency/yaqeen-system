@php

    $hasUnpaidBillings = \App\Models\Billings::where('student_id', $student->id)
    ->whereMonth('created_at', $month)
    ->where('is_paid', 0)
    ->exists();

@endphp
@if(!$hasUnpaidBillings)
    <script>window.location.href = "/success/{{$month}}";</script>
@else
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="display: flex;align-items: center;justify-content: center">
                <div class="card" >
                    <h3 style="font-family: Calibri">Hello : {{$student->user_name}} </h3>
                    <h3 style="font-family: Calibri">This is month {{$month}} billings amount</h3>
                    <h3 style="font-family: Calibri">Total Amount : {{$amount}} {{$student->currency}}</h3>
                    <div class="card-body">
                        <div id="paypal-button-container"  style="width: 150%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=ASeD-03sWG_P6Z6jjRt_swDo9BNeUNheMvV4dBgStoT-3-NtR2YezHwni3eKI7oxoWAqLyMPGlku4SgZ&components=buttons&currency={{$currency}}"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                // Set up the transaction
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ $amount }}',
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function(details) {
                    // Redirect to success page or display success message
                    window.location.href = '/success/{{$month}}?student_id={{ $student->id }}';
                });
            }
        }).render('#paypal-button-container');
    </script>
    </body>
    </html>
@endif


