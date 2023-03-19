@php
    use App\Enums\WalletEnum;
@endphp
<div class="form-group mt-2">
    <label class="form-label" for="{{ $name }}">
        Tipo:
    </label>
    <select class="form-control" name="{{ $name }}" id="{{{ $name }}}" required>
        @foreach(WalletEnum::getList() as $item)
            <option value="{{ WalletEnum::getCode($item) }}">{{ $item }}</option>
        @endforeach
    </select>
</div>