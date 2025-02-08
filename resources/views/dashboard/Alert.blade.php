<div>
    @foreach (['user_id', 'name', 'password', 'email', 'role', 'class', 'class*'] as $field)
        @error($field)
            <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
                <p>{{ $message }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
    @endforeach
</div>
