<div class="form-group mt-2">
    <label class="form-label" for="{{ $name }}">
        {{ $title }}
    </label>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
            <i class="fa-solid fa-brazilian-real-sign"></i>
        </span>
        <input type="text" class="form-control" name="{{ $name }}" maxlength="10"
               id="{{ $name }}" onkeyup="formatValueToBr('{{ $name }}')" required>
    </div>
</div>