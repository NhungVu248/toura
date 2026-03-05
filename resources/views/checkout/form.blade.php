<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

{{-- LEFT PAYMENT --}}
<div class="md:col-span-2">

<h2 class="text-2xl font-bold text-pink-600 mb-1">
Thanh toán
</h2>

<p class="text-gray-500 mb-6">
Hoàn tất đặt tour của bạn
</p>

<form method="POST" action="{{ route('checkout.store',$booking->id) }}">
@csrf

<h3 class="font-semibold mb-4">
Chọn phương thức thanh toán
</h3>

{{-- CARD --}}
<label class="border rounded-lg p-4 flex items-center gap-3 cursor-pointer mb-3 payment-option">

<input type="radio" name="payment_method" value="card" checked>

<img src="https://img.icons8.com/color/48/visa.png" width="28">

<img src="https://img.icons8.com/color/48/mastercard.png" width="28">

<span class="ml-2">Thẻ tín dụng/Ghi nợ</span>

</label>


{{-- BANK --}}
<label class="border rounded-lg p-4 flex items-center gap-3 cursor-pointer mb-3 payment-option">

<input type="radio" name="payment_method" value="bank_transfer">

<img src="https://img.icons8.com/color/48/bank.png" width="28">

<span class="ml-2">Chuyển khoản ngân hàng</span>

</label>


{{-- EWALLET --}}
<label class="border rounded-lg p-4 flex items-center gap-3 cursor-pointer mb-3 payment-option">

<input type="radio" name="payment_method" value="ewallet">

<img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" width="28">

<span class="ml-2">Ví điện tử</span>

</label>


{{-- CASH --}}
<label class="border rounded-lg p-4 flex items-center gap-3 cursor-pointer mb-3 payment-option">

<input type="radio" name="payment_method" value="cash">

<img src="https://img.icons8.com/color/48/cash.png" width="28">

<span class="ml-2">Thanh toán tiền mặt</span>

</label>


{{-- CARD FORM --}}
<div id="cardForm" class="bg-gray-100 p-4 rounded-lg mt-4">

<h4 class="font-semibold mb-2">
Thông tin thẻ
</h4>

<label class="text-sm">Số thẻ</label>
<input type="text"
name="card_number"
placeholder="1234 5678 9012 3456"
class="border w-full p-2 rounded mb-3">

<div class="flex gap-3">

<div class="w-1/2">
<label class="text-sm">Ngày hết hạn</label>
<input type="text"
name="card_expiry"
placeholder="MM/YY"
class="border w-full p-2 rounded">
</div>

<div class="w-1/2">
<label class="text-sm">CVV</label>
<input type="text"
name="card_cvv"
placeholder="123"
class="border w-full p-2 rounded">
</div>

</div>

<p class="text-xs text-gray-500 mt-2">
🔒 Thông tin thẻ được mã hóa an toàn
</p>

</div>


{{-- BANK FORM --}}
<div id="bankForm" class="bg-blue-50 p-4 rounded-lg mt-4 hidden">

<h4 class="font-semibold mb-2">
Thông tin chuyển khoản
</h4>

<p><strong>Ngân hàng:</strong> {{ $bank['name'] }}</p>

<p><strong>Số tài khoản:</strong> {{ $bank['account_number'] }}</p>

<p><strong>Chủ tài khoản:</strong> {{ $bank['account_name'] }}</p>

<p><strong>Nội dung chuyển khoản:</strong> {{ $transferContent }}</p>

<div class="text-center mt-4">

<img src="{{ $qrUrl }}" width="220" class="mx-auto">

<p class="text-sm text-gray-600 mt-2">
Quét QR để thanh toán nhanh
</p>

</div>

<p class="text-sm text-red-500 mt-2">
⏰ Vui lòng thanh toán trong vòng 24 giờ để giữ chỗ
</p>

</div>


{{-- EWALLET FORM --}}
<div id="walletForm" class="bg-gray-100 p-4 rounded-lg mt-4 hidden">

<h4 class="font-semibold mb-2">
Chọn ví điện tử
</h4>

<select name="wallet_provider"
class="border p-2 w-full rounded">

<option value="momo">MoMo</option>
<option value="zalopay">ZaloPay</option>
<option value="vnpay">VNPay</option>

</select>

</div>


{{-- CASH FORM --}}
<div id="cashForm" class="bg-yellow-50 p-4 rounded-lg mt-4 hidden">

<h4 class="font-semibold mb-2">
Thanh toán tiền mặt
</h4>

<p class="text-sm text-gray-700 mb-2">
Bạn có thể thanh toán trực tiếp tại văn phòng
hoặc cho hướng dẫn viên vào ngày khởi hành.
</p>

<p><strong>Địa chỉ:</strong> 123 Trần Phú, Hà Nội</p>

<p><strong>Hotline:</strong> 0988 888 888</p>

<p class="text-red-500 text-sm mt-2">
⏰ Booking sẽ được xác nhận sau khi thanh toán.
</p>

</div>

</div>


{{-- RIGHT SUMMARY --}}
<div>

<div class="bg-white shadow rounded-lg p-6">

<h3 class="font-semibold mb-4">
Chi tiết đặt tour
</h3>

<p class="mb-3">
Tour <br>
<strong>{{ $booking->tour->title ?? '' }}</strong>
</p>

<p class="mb-3">
Ngày khởi hành <br>
{{ \Carbon\Carbon::parse($booking->departure_date)->format('d/m/Y') }}
</p>

<p class="mb-3">
Số khách <br>
{{ $booking->guest_quantity }} người
</p>

<p class="mb-3">
Thông tin liên hệ <br>
{{ $booking->email }} <br>
{{ $booking->phone }}
</p>

@if($booking->discount_percent)

<p class="text-green-600">
Giảm giá -{{ $booking->discount_percent }}%
</p>

@endif

<hr class="my-4">

<h2 class="text-xl font-bold text-pink-600">
Tổng cộng {{ number_format($booking->total_price,0,',','.') }} đ
</h2>

<button
type="submit"
class="w-full mt-4 bg-gradient-to-r from-pink-500 to-orange-400 text-white py-2 rounded">

Xác nhận thanh toán

</button>

<p class="text-xs text-gray-400 mt-3 text-center">
Bằng việc thanh toán, bạn đồng ý với điều khoản sử dụng
</p>

</div>

</div>

</form>

</div>

</div>


<script>

const methods=document.querySelectorAll("input[name='payment_method']")

const card=document.getElementById("cardForm")
const bank=document.getElementById("bankForm")
const wallet=document.getElementById("walletForm")
const cash=document.getElementById("cashForm")

methods.forEach(m=>{

m.addEventListener("change",()=>{

card.classList.add("hidden")
bank.classList.add("hidden")
wallet.classList.add("hidden")
cash.classList.add("hidden")

if(m.value==="card") card.classList.remove("hidden")

if(m.value==="bank_transfer") bank.classList.remove("hidden")

if(m.value==="ewallet") wallet.classList.remove("hidden")

if(m.value==="cash") cash.classList.remove("hidden")

})

})

</script>

</x-app-layout>