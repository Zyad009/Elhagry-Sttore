@push("admin-cdn")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold py-3 mb-4">My Account</h3>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">


                            <img src="{{asset($newImage ? $newImage->temporaryUrl() : ($image ?:  $defaultImage) ) }}" alt="user-avatar"
                                class="d-block rounded" height="100" width="100" id="uploadedAvatar"
                                wire:listen="imageUpdated('image')" />
                            <x-message.error name="newImage"></x-message.error>

                            <div class="button-wrapper">
                                <form wire:submit.prevent="uploadImage" enctype="multipart/form-data"
                                    class="d-flex gap-2">

                                    @if ($newImage)
                                    <button type="submit" class="btn btn-success">
                                        Save Image
                                    </button>
                                    @endif

                                    <label class="btn btn-secondary mb-0">
                                        <span class="text-white" wire:loading.remove wire:target='newImage'>Choose
                                            Image</span>
                                        <input type="file" class="account-file-input" wire:model="newImage"
                                            wire:loading='' hidden />
                                        <div class="text-center" wire:loading wire:target='newImage'>
                                            <div class="spinner-border spinner-border-sm text-white" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </label>

                                    @if (isset($image))
                                    <button type="button" class="btn btn-danger" wire:click="deleteImage">
                                        Delete
                                    </button>
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>


                    <hr class="my-0" />
                    <div class="card-body">
                        <form wire:submit.prevent='submit'>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Your Position</label>
                                    <div>
                                        <b class="badge bg-label-primary me-1">
                                            {{$position}}
                                        </b>
                                    </div>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Name <span class="text-danger">*</label>
                                    <input class="form-control" type="text" wire:model.blur="name"
                                        value="{{$data->name}}" />
                                    <x-message.error name="name"></x-message.error>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">E-mail <span class="text-danger">*</label>
                                    <input class="form-control" type="email" wire:model.blur="email"
                                        value="{{$data->email}}" placeholder="john.doe@example.com" />
                                    <x-message.error name="email"></x-message.error>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Gender <span class="text-danger">*</label>
                                    <select wire:model.blur="gender" class="form-control mb-3">
                                        <option value="{{ $data->gender }}" selected>{{ ucfirst($data->gender) }}
                                        </option>
                                        @if($data->gender == "male")
                                        <option value="female">Female</option>
                                        @else
                                        <option value="male">Male</option>
                                        @endif
                                        <x-message.error name="gender"></x-message.error>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Phone Number <span class="text-danger">*</label>
                                    <input type="tel" wire:model.blur="phone" value="{{$data->phone}}"
                                        class="form-control" placeholder="202 555 0111" />
                                    <x-message.error name="phone"></x-message.error>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Whatsapp <span class="text-danger">*</label>
                                    <input type="tel" wire:model.blur="whatsapp" value="{{$data->whatsapp}}"
                                        class="form-control" placeholder="202 555 0111" />
                                    <x-message.error name="whatsapp"></x-message.error>
                                </div>


                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Address <span class="text-danger">*</label>
                                    <textarea class="form-control" wire:model.blur="address">
                                            {{$data->address}}
                                        </textarea>
                                    <x-message.error name="address"></x-message.error>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" wire:click='refres'
                                    class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to change password?
                                </h6>
                                <p class="mb-0">If you change your password, you will be logged out immediately and you
                                    will have to log in again with the new password..
                                </p>
                            </div>
                        </div>


                        <form wire:submit.prevent='submitPassword'>
                            <div class="row mb-3">

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Old Password <span class="text-danger">*</label>
                                    <input class="form-control" type="password" wire:model="oldPassword"
                                        placeholder="john.doe@example.com" />
                                    <x-message.error name="oldPassword"></x-message.error>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">New Password <span class="text-danger">*</label>
                                    <input class="form-control" type="password" wire:model="password"
                                        placeholder="john.doe@example.com" />
                                    <x-message.error name="password"></x-message.error>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Confirm Password <span class="text-danger">*</label>
                                    <input class="form-control" type="password" wire:model="password_confirmation"
                                        placeholder="john.doe@example.com" />
                                    <x-message.error name="password_confirmation"></x-message.error>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-danger">Change Password </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push("admin-js")
<script>
    window.addEventListener("successUpdated", () => {
        Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Updated successfully",
            showConfirmButton: false,
            timer: 1500
        });
    });

    window.addEventListener("updatedImage", () => {
        Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Updated Image successfully",
            showConfirmButton: false,
            timer: 2000
        });
    });

    window.addEventListener("deletedImage", () => {
        Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Deleted successfully",
            showConfirmButton: false,
            timer: 1500
        });
    });

    window.addEventListener("errorPassword", () => {
        Swal.fire({
        icon: "error",
        title: "Error!",
        text: "The old password is incorrect. ",
        showConfirmButton: false,
        timer: 3000
        });
        });
</script>

@endpush