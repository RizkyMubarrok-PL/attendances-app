<div>
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
        <p>{{ session('msg') }}</p>
        <button type="button" class="button-alert btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<div>
    @if (session('statuss'))
    <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
        <p>{{ session('emesge') }}</p>
        <button type="button" class="button-alert btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

{{-- <div>
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show alert-custom d-flex align-items-center" role="alert">
        <i class="fa fa-smile"></i>
        <p class="mb-0">{{ session('msg') }}</p>
        <button type="button" class=" btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div> --}}
