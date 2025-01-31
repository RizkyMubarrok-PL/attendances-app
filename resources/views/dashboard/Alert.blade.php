<div>
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ session('msg') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @foreach (['user_id', 'name', 'password', 'email', 'role', 'class', 'class*'] as $field)
        @error($field)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>{{ $message }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
    @endforeach
</div>
