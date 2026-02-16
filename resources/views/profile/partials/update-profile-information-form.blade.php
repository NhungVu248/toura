<!-- resources/views/profile/update-profile-information-form.blade.php -->
<form id="profile-update-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $user->name)" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email (readonly) -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $user->email)" required readonly />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Phone -->
    <div class="mt-4">
        <x-input-label for="phone" :value="__('Phone')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                      :value="old('phone', $user->phone)" placeholder="Số điện thoại (ví dụ: +84901234567)" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        @if($user->phone)
            <p class="text-sm text-gray-500 mt-1">
                Trạng thái: 
                @if($user->phone_verified_at)
                    <span class="text-green-600">Đã xác thực ({{ $user->phone_verified_at->diffForHumans() }})</span>
                @else
                    <span class="text-yellow-600">Chưa xác thực</span>
                @endif
            </p>
        @endif
    </div>

    <!-- CCCD -->
    <div class="mt-4">
    <x-input-label for="cccd" :value="__('CCCD')" />

    {{-- Nếu đã có CCCD --}}
    @if($user->cccd)
        <x-text-input id="cccd"
                      name="cccd"
                      type="text"
                      class="mt-1 block w-full"
                      :value="old('cccd', $user->masked_cccd)"
                      placeholder="Nhập số CCCD (12 số)" />

        <p class="text-xs text-gray-500 mt-1">
            CCCD hiện tại đã được ẩn để bảo mật.
            Nếu bạn nhập lại số mới, hệ thống sẽ yêu cầu xác thực lại.
        </p>
    @else
        {{-- Nếu chưa có CCCD --}}
        <x-text-input id="cccd"
                      name="cccd"
                      type="text"
                      class="mt-1 block w-full"
                      :value="old('cccd')"
                      placeholder="Nhập số CCCD (12 số)" />
    @endif

    <x-input-error :messages="$errors->get('cccd')" class="mt-2" />

    {{-- Trạng thái xác thực --}}
    @if($user->cccd)
        <p class="text-sm mt-2">
            Trạng thái:
            @if($user->cccd_verified_at)
                <span class="text-green-600 font-semibold">
                    ✔ Đã xác thực
                </span>
            @else
                <span class="text-yellow-600 font-semibold">
                    ⏳ Chưa xác thực
                </span>
            @endif
        </p>
    @endif
    </div>

    <!-- Address -->
    <div class="mt-4">
        <x-input-label for="address" :value="__('Address')" />
        <textarea id="address" name="address" rows="3" class="block mt-1 w-full border rounded p-2">{{ old('address', $user->address) }}</textarea>
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <!-- Avatar -->
    <div class="mt-4">
        <x-input-label for="avatar" :value="__('Avatar (image)')" />
        @if($user->avatar_url)
            <div class="mb-2">
                <img src="{{ $user->avatar_url }}" alt="avatar" class="w-20 h-20 rounded-full object-cover">
            </div>
        @endif
        <input id="avatar" name="avatar" type="file" accept="image/*" class="block w-full" />
        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        <p class="text-sm text-gray-500 mt-1">Hỗ trợ jpg/jpeg/png. Kích thước tối đa 2MB.</p>
    </div>

    <div class="flex items-center gap-4 mt-6">
        <x-primary-button>{{ __('Lưu thay đổi') }}</x-primary-button>

        @if(session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-init="setTimeout(()=> show = false, 3000)"
               class="text-sm text-green-600">{{ __('Cập nhật thành công.') }}</p>
        @endif
    </div>
</form>
