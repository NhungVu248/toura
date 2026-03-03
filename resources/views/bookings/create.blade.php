{{-- resources/views/bookings/create.blade.php --}}
<x-app-layout>
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl overflow-hidden">

        {{-- HEADER --}}
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <div>
                <h2 class="text-2xl font-bold text-pink-600">Đặt tour</h2>
                <div class="text-gray-500 text-sm">{{ $tour->title }}</div>
            </div>

            {{-- nút đóng -> quay về danh sách tours --}}
            <a href="/tours" class="text-gray-400 hover:text-gray-600 text-xl">✕</a>
        </div>

        <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="grid grid-rows-[auto_1fr_auto]">
            @csrf
            <input type="hidden" name="tour_id" value="{{ $tour->id }}">

            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-8">

                    {{-- LEFT --}}
                    <div>
                        <h3 class="font-semibold mb-4 text-lg">Thông tin liên hệ</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm mb-1">Họ và tên *</label>
                                <input type="text" name="full_name"
                                    value="{{ old('full_name', optional(auth()->user())->name) }}"
                                    class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 outline-none"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Email *</label>
                                <input type="email" name="email"
                                    value="{{ old('email', optional(auth()->user())->email) }}"
                                    class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 outline-none"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Số điện thoại *</label>
                                <input type="text" name="phone"
                                    value="{{ old('phone') }}"
                                    class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 outline-none"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Số lượng khách *</label>
                                <input id="guestQuantity" type="number" min="1" name="guest_quantity"
                                    value="{{ old('guest_quantity',1) }}"
                                    class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 outline-none"
                                    required>
                                <div id="seatsInfo" class="text-xs text-gray-400 mt-1">
                                    {{ optional($tour->upcomingSchedules->first())->seats_available ?? 0 }} chỗ còn trống
                                </div>
                                <div id="seatError" class="text-xs text-red-600 mt-1 hidden">Không đủ chỗ cho lựa chọn này.</div>
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Ngày khởi hành *</label>
                                <select id="scheduleSelect" name="schedule_id"
                                    class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 outline-none"
                                    required>
                                    <option value="">-- Chọn ngày khởi hành --</option>
                                    @foreach($tour->upcomingSchedules as $schedule)
                                        <option value="{{ $schedule->id }}"
                                            data-seats="{{ $schedule->seats_available }}"
                                            data-date="{{ $schedule->departure_date->format('d/m/Y') }}">
                                            {{ $schedule->departure_date->format('d/m/Y') }}
                                            (Còn {{ $schedule->seats_available }} chỗ)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div>
                        <h3 class="font-semibold mb-4 text-lg">Dịch vụ bổ sung</h3>

                        <div class="space-y-4">
                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-gray-50">
                                <input id="addonInsurance" name="travel_insurance" data-price="100000" type="checkbox" class="mt-1 addon">
                                <div>
                                    <div class="font-medium">Bảo hiểm du lịch</div>
                                    <div class="text-sm text-gray-500">+100.000 đ / khách</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-gray-50">
                                <input id="addonGuide" name="private_guide" data-price="500000" type="checkbox" class="mt-1 addon">
                                <div>
                                    <div class="font-medium">Hướng dẫn viên riêng</div>
                                    <div class="text-sm text-gray-500">+500.000 đ / khách</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-gray-50">
                                <input id="addonPickup" name="airport_pickup" data-price="300000" type="checkbox" class="mt-1 addon">
                                <div>
                                    <div class="font-medium">Đưa đón sân bay</div>
                                    <div class="text-sm text-gray-500">+300.000 đ / khách</div>
                                </div>
                            </label>

                            <div class="mt-4">
                                <label class="block text-sm mb-1">Mã khuyến mãi</label>
                                <div class="flex gap-2">
                                    <input id="couponInput" type="text" name="coupon_code"
                                        value="{{ old('coupon_code') }}"
                                        placeholder="Nhập mã..."
                                        class="flex-1 bg-gray-100 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 outline-none">
                                    <button id="applyCoupon" type="button" class="px-4 py-2 bg-pink-500 text-white rounded-lg">Áp dụng</button>
                                </div>
                                <div id="couponMsg" class="text-xs mt-1 hidden"></div>
                                <div class="text-xs text-gray-400 mt-2">
                                    Mã khả dụng: SUMMER2026 (-10%), WELCOME (-5%), VIP20 (-20%)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="bg-gray-50 p-6 border-t">
                <div class="mb-4">
                    <div class="font-medium text-sm mb-2">Tóm tắt đặt tour</div>

                    <div id="summaryList" class="bg-white border rounded p-4 space-y-2">
                        {{-- JS sẽ populate vào đây --}}
                    </div>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <div class="text-sm text-gray-600">Tổng cộng</div>
                    <div id="totalAmount" class="text-pink-600 font-bold text-xl">0 đ</div>
                </div>

                <div class="flex gap-4 mt-6">
                    <a href="/tours" class="flex-1 border rounded-lg py-3 text-center">Hủy</a>

                    <button id="submitBooking" type="submit" class="flex-1 py-3 rounded-lg text-white bg-gradient-to-r from-pink-500 to-yellow-400 hover:opacity-90">
                        Tiếp tục thanh toán →
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- helper format --}}
<script>
function formatVND(n){
    return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + ' đ';
}
</script>

{{-- Main JS --}}
<script>
(function(){
    // elements
    const pricePerGuest = parseFloat(@json((float)$tour->price_adult)); // đảm bảo là số
    const qtyEl = document.getElementById('guestQuantity');
    const scheduleSelect = document.getElementById('scheduleSelect');
    const seatsInfo = document.getElementById('seatsInfo');
    const seatError = document.getElementById('seatError');
    const addonEls = Array.from(document.querySelectorAll('.addon'));
    const couponInput = document.getElementById('couponInput');
    const applyCouponBtn = document.getElementById('applyCoupon');
    const couponMsg = document.getElementById('couponMsg');
    const summaryList = document.getElementById('summaryList');
    const totalAmount = document.getElementById('totalAmount');
    const submitBtn = document.getElementById('submitBooking');
    const bookingForm = document.getElementById('bookingForm');

    // coupons rules
    const coupons = {
        'SUMMER2026': { type: 'percent', value: 10, text: 'Giảm 10% với mã SUMMER2026' },
        'WELCOME': { type: 'percent', value: 5, text: 'Giảm 5% với mã WELCOME' },
        'VIP20': { type: 'percent', value: 20, text: 'Giảm 20% với mã VIP20' }
    };
    let appliedCoupon = null;

    function getSelectedSeatsAvailable(){
        const opt = scheduleSelect.selectedOptions[0];
        if(!opt) return null;
        return parseInt(opt.dataset.seats ?? 0);
    }

    function recalc(){
        const qty = Math.max(1, parseInt(qtyEl.value || 1));
        const seats = getSelectedSeatsAvailable();

        // seats info & validate
        if(seats !== null){
            seatsInfo.textContent = seats + ' chỗ còn trống';
            if(qty > seats){
                seatError.classList.remove('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50','cursor-not-allowed');
            } else {
                seatError.classList.add('hidden');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50','cursor-not-allowed');
            }
        }

        // base
        const base = pricePerGuest * qty;

        // addons
        const selectedAddons = [];
        let addonTotal = 0;
        addonEls.forEach(el=>{
            if(el.checked){
                const unit = parseFloat(el.dataset.price || 0);
                selectedAddons.push({
                    label: el.closest('label').innerText.replace(/\s+/g,' ').trim().split('+')[0].trim(),
                    unit, qty, total: unit * qty
                });
                addonTotal += unit * qty;
            }
        });

        // coupon discount
        let discount = 0;
        if(appliedCoupon){
            if(appliedCoupon.type === 'percent'){
                discount = (base + addonTotal) * (appliedCoupon.value / 100);
            } else if(appliedCoupon.type === 'fixed'){
                discount = appliedCoupon.value;
            }
        }

        const subtotal = base + addonTotal;
        const total = Math.max(0, subtotal - discount);

        // render summary
        summaryList.innerHTML = '';

        // base line
        const baseRow = document.createElement('div');
        baseRow.className = 'flex justify-between text-sm';
        baseRow.innerHTML = `<div>Giá tour × ${qty} khách</div><div>${formatVND(base)}</div>`;
        summaryList.appendChild(baseRow);

        // addon lines
        selectedAddons.forEach(a=>{
            const r = document.createElement('div');
            r.className = 'flex justify-between text-sm';
            r.innerHTML = `<div>${a.label} × ${a.qty}</div><div>${formatVND(a.total)}</div>`;
            summaryList.appendChild(r);
        });

        // subtotal row (optional)
        const sep = document.createElement('div');
        sep.className = 'border-t my-1';
        summaryList.appendChild(sep);

        // discount row
        if(discount > 0){
            const d = document.createElement('div');
            d.className = 'flex justify-between text-sm text-green-600';
            const text = appliedCoupon.type === 'percent' ? `Giảm giá (${appliedCoupon.value}%)` : 'Giảm giá';
            d.innerHTML = `<div>${text}</div><div>-${formatVND(discount)}</div>`;
            summaryList.appendChild(d);
        }

        // total shown at bottom
        totalAmount.innerText = formatVND(total);
    }

    // events
    qtyEl.addEventListener('input', recalc);
    scheduleSelect.addEventListener('change', recalc);
    addonEls.forEach(el=>el.addEventListener('change', recalc));

    applyCouponBtn.addEventListener('click', function(){
        const code = (couponInput.value || '').trim().toUpperCase();
        if(!code){
            appliedCoupon = null;
            couponMsg.classList.add('hidden');
            recalc();
            return;
        }
        if(coupons[code]){
            appliedCoupon = coupons[code];
            couponMsg.classList.remove('hidden');
            couponMsg.classList.remove('text-red-600');
            couponMsg.classList.add('text-green-600');
            couponMsg.textContent = '✓ ' + coupons[code].text;
            recalc();
        } else {
            appliedCoupon = null;
            couponMsg.classList.remove('hidden');
            couponMsg.classList.remove('text-green-600');
            couponMsg.classList.add('text-red-600');
            couponMsg.textContent = 'Mã không hợp lệ';
            recalc();
        }
    });

    // double-check on submit
    bookingForm.addEventListener('submit', function(e){
        const qty = Math.max(1, parseInt(qtyEl.value || 1));
        const seats = getSelectedSeatsAvailable();
        if(seats !== null && qty > seats){
            e.preventDefault();
            alert('Số lượng khách vượt quá chỗ trống. Vui lòng chọn lịch khác hoặc giảm số lượng.');
            return false;
        }

        // before submit, if coupon applied we keep code in couponInput so backend can validate again
        // also ensure addon checkboxes have value '1' when checked (they already have name attr)
    });

    // initial calc
    recalc();
})();
</script>

</x-app-layout>