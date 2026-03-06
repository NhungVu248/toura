@component('mail::message')

# Xin chào {{ $contact->name }}

Cảm ơn bạn đã liên hệ với chúng tôi.

### Nội dung bạn đã gửi

> {{ $contact->message }}

---

### Phản hồi từ đội ngũ hỗ trợ

{!! nl2br(e($adminReply)) !!}

---

Nếu bạn cần hỗ trợ thêm vui lòng phản hồi email này.

Trân trọng,

{{ config('app.name') }}

@endcomponent