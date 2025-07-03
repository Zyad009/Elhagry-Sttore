<form wire:submit.prevent='submit'>
    @csrf
    <x-error></x-error>
    <div class="form-group">
        <label for="singin-email-2"> Email <span class="text-danger">*</span></label>
        <input type="text" class="form-control" wire:model.blur='email'>
    </div><!-- End .form-group -->

    <div class="form-group">
        <label for="singin-password-2">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" wire:model.blur='password'>
    </div><!-- End .form-group -->

    <div class="form-footer">
        <button type="submit" class="btn btn-outline-primary-2">
            <span>LOG IN</span>
            <i class="icon-long-arrow-right"></i>
        </button>
    </div><!-- End .form-footer -->
</form>