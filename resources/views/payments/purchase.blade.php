@extends('layouts.app')

@section('title', 'Buy Video')

@section('content')
<div class="container">
    <h1>{{ $video->title }}</h1>
    <p>Price: {{ $video->price == 0 ? 'Free' : 'Rp. ' . number_format($video->price, 0, ',', '.') }}</p>

    @if($video->price > 0)
        <button id="pay-button" class="btn btn-primary">Buy Now</button>
    @else
        <a href="{{ route('download', $video->id) }}" class="btn btn-success">Download</a>
    @endif
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Request token dari server Laravel
        fetch('{{ route('payment.create', $video->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                video_id: '{{ $video->id }}',
                amount: '{{ $video->price }}',
                video_title: '{{ $video->title }}'
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Menampilkan data yang diterima dari server
            // Pastikan data.video_id ada
            if (data.snap_token && data.video_id) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        // Redirect ke halaman video setelah sukses
                        window.location.href = '{{ url('/video') }}/' + data.video_id;
                    },
                    onPending: function(result) {
                        alert("Waiting for your payment!");
                    },
                    onError: function(result) {
                        alert("Payment failed!");
                    },
                    onClose: function() {
                        alert('You closed the popup without finishing the payment');
                    }
                });
            } else {
                console.error('Invalid response from payment API:', data);
                alert('Payment failed: invalid response.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error occurred while processing payment: ' + error.message);
        });
    });
</script>
@endsection
