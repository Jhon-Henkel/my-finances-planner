@php
    use App\Enums\ConfigEnum;
@endphp
<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
    <div>
        @if($type == ConfigEnum::WARNING_ALERT)
            <i class="fa-solid fa-circle-exclamation"></i>
        @elseif($type == ConfigEnum::ERROR_ALERT)
            <i class="fa-solid fa-circle-xmark"></i>
        @elseif($type == ConfigEnum::OK_ALERT)
            <i class="fa-solid fa-circle-check"></i>
        @elseif($type == ConfigEnum::INFO_ALERT)
            <i class="fa-solid fa-circle-info"></i>
        @endif
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>