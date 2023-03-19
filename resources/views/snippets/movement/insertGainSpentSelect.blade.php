<div class="form-group mt-2">
    <label class="form-label" for="{{ $name }}">
        {{ $title }}
    </label>
    <select class="form-control" name="{{ $name }}" required>
        @foreach($wallets as $wallet)
            <option value="{{ $wallet->getId() }}">{{ $wallet->getName() }}</option>
        @endforeach
    </select>
</div>