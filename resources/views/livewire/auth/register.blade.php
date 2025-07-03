<form wire:submit.prevent='submit' novalidate>
    {{-- <x-error></x-error> --}}

    <div class="form-group">
        <label for="register-email-2">First Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" wire:model.blur='first_name' required>
        <x-message.error name="first_name"></x-message.error>
    </div><!-- End .form-group -->

    <div class="form-group">
        <label for="register-email-2">Last Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" wire:model.blur='last_name' required>
        <x-message.error name="last_name"></x-message.error>
    </div><!-- End .form-group -->

    <div class="form-group">
        <label for="register-email-2">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" wire:model.blur='email' required>
        <x-message.error name="email"></x-message.error>
    </div><!-- End .form-group -->

    <div class="form-group">
        <label for="register-email-2">Phone <span class="text-danger">*</span></label>
        <input type="tel" class="form-control" wire:model.blur='phone' required>
        <x-message.error name="phone"></x-message.error>
    </div><!-- End .form-group -->

    <div class="form-group">
        <label for="register-email-2">whatsapp <span class="text-danger">*</span></label>
        <input type="tel" class="form-control" wire:model.blur='whatsapp' required>
        <x-message.error name="phone"></x-message.error>
    </div><!-- End .form-group -->
    
    <div class="form-group">
        <label for="register-email-2">Gender <span class="text-danger">*</span></label>
        <select name="gender" class="form-control mb-3" wire:model.blur='gender'>
            <option value="">Select Your Gander</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <x-message.error name="gender"></x-message.error>
    </div><!-- End .form-group -->
    
    <div class="form-group">
        <label for="register-email-2">Address <span class="text-danger">*</span></label>
        <textarea wire:model.blur='address'  class="form-control"></textarea>
        <x-message.error name="address"></x-message.error>
    </div><!-- End .form-group -->


    <div class="form-group">
        <label for="register-email-2">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" wire:model.blur='password' required>
        <x-message.error name="password"></x-message.error>
    </div><!-- End .form-group -->

    <div class="form-group">
        <label for="register-password-2">Confirm Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" wire:model.blur='password_confirmation' required>
    </div><!-- End .form-group -->

    <div class="form-footer">
        <button type="submit" class="btn btn-outline-primary-2">
            <span>SIGN UP</span>
            <i class="icon-long-arrow-right"></i>
        </button>

        <div class="custom-control custom-checkbox">

        </div><!-- End .custom-checkbox -->
    </div><!-- End .form-footer -->
</form>