import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import './bootstrap';

document.addEventListener("DOMContentLoaded", function(){

    const basePrice = window.baseTourPrice || 0;

    const guestInput = document.getElementById('guestInput');
    const checkboxes = document.querySelectorAll('.addon-checkbox');
    const summary = document.getElementById('summaryItems');
    const totalText = document.getElementById('totalPrice');

    if(!guestInput) return; // tránh lỗi khi không ở trang booking

    function formatMoney(num){
        return num.toLocaleString('vi-VN') + " đ";
    }

    function calculate(){

        let guests = parseInt(guestInput.value) || 1;
        let subtotal = basePrice * guests;
        let total = subtotal;

        summary.innerHTML = `
            <div class="flex justify-between">
                <span>Giá tour x ${guests}</span>
                <span>${formatMoney(subtotal)}</span>
            </div>
        `;

        checkboxes.forEach(cb=>{
            if(cb.checked){
                let price = parseInt(cb.dataset.price);
                let serviceTotal = price * guests;
                total += serviceTotal;

                summary.innerHTML += `
                    <div class="flex justify-between">
                        <span>${cb.parentElement.querySelector('.font-medium').innerText} x ${guests}</span>
                        <span>${formatMoney(serviceTotal)}</span>
                    </div>
                `;
            }
        });

        totalText.innerText = formatMoney(total);
    }

    guestInput.addEventListener("input", calculate);
    checkboxes.forEach(cb=>cb.addEventListener("change", calculate));

    calculate();
});