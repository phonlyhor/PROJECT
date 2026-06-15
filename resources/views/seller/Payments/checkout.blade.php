<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    margin: auto;
    margin-top: 50px;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    max-width: 600px;
    text-align: center;
}

/* Headings */
h1 {
    font-size: 28px;
    color: #007bff;
    margin-bottom: 20px;
}

h3 {
    font-size: 24px;
    color: #e53935;
}

/* Paragraph */
p {
    font-size: 18px;
    color: #333333;
}

/* Strong text */
strong {
    font-size: 24px;
    color: #007bff;
}

/* QR Code */
.qr-container img {
    border: 2px solid #007bff;
    border-radius: 10px;
}

.mt-3 {
    margin-top: 15px;
}

/* Countdown Timer */
#countdown {
    font-size: 48px;
    font-weight: bold;
    color: #e53935;
    margin-bottom: 15px;
}

#seconds {
    font-weight: normal;
    font-size: 18px;
    color: #888888;
}

/* Alert Box */
.alert {
    background-color: #ffcc00;
    color: #8a6d3b;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
}

.btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    font-size: 18px;
}

.btn:hover {
    background-color: #0056b3;
}

/* Responsive Styles */
@media screen and (max-width: 600px) {
    .container { width: 90%; }
    h1 { font-size: 24px; }
    h3 { font-size: 20px; }
    #countdown { font-size: 36px; }
}
</style>
<div class="container text-center">
    <h1 style="text-align: center">Scan KHQR to Pay</h1>

    <p>
        <strong>{{ $cart->sum('quantity') }}</strong> — {{ number_format($totalAmount, 2) }} ៛
    </p>

    @if ($qr)
        <p>{!! QrCode::size(200)->generate($qr) !!}</p>
        <p class="mt-3">MD5: {{ $md5 }}</p>
        <p class="text-muted">Scan this QR code using the Bakong App to make a payment.</p>
    @else
        <p class="alert alert-danger">⚠ Failed to generate KHQR.</p>
    @endif

    <div class="mt-4">
        <h3 id="countdown" class="text-danger fw-bold">60</h3>
        <p class="text-muted">
            ទំព័រនេះនឹងផុតកំណត់ក្នុង <span id="seconds">60</span> វិនាទី
        </p>
    </div>

    <a href="{{ route('seller.cart.view') }}" class="btn">Back</a>
</div>

<script>
let timeLeft = 60;
const countdownElement = document.getElementById('countdown');
const secondsText = document.getElementById('seconds');

const timer = setInterval(() => {
    timeLeft--;
    countdownElement.textContent = timeLeft;
    secondsText.textContent = timeLeft;

    if (timeLeft % 5 === 0) { // Check every 5 seconds
        fetch("{{ route('verify.transaction') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ md5: "{{ $md5 }}" })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'SUCCESS') {
                clearInterval(timer);
                alert(`✅ ការទូទាត់បានជោគជ័យ!\nទឹកប្រាក់: ${data.amount} KHR\nអតិថិជន: ${data.customer_name}`);
                window.location.href = "{{ route('seller.cart.view') }}";
            } else if (data.status === 'FAILED') {
                clearInterval(timer);
                alert("❌ ការទូទាត់បរាជ័យ។ សូមព្យាយាមម្តងទៀត។");
                window.location.href = "{{ route('seller.cart.view') }}";
            }
        })
        .catch(error => console.error('Error:', error));
    }

    if(timeLeft <= 0){
        clearInterval(timer);
        alert("⌛ ពេលវេលាបញ្ចប់។ ទំព័រត្រឡប់ទៅ cart។");
        window.location.href = "{{ route('seller.cart.view') }}";
    }
}, 1000);
</script>