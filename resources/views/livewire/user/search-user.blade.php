<div>
    <x-error></x-error>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input class="form-control form-control-lg" wire:model.live='search'
                        placeholder="Search:- Phone,Name" aria-label="Search">
                </div>
            </div>
        </div>
    </div>

    <div class="card mx-auto my-4 px-3 py-2 w-100">
        <div class="table-responsive text-nowrap mt-2">
            @if (count($users) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Whatsapp</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">More Info</th>
                        {{-- <th class="text-center" style="width: 200px;">Address</th> --}}
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-center">
                            @php
                            if($user->gender == "male"){
                            $defaultImage = config("default-image.male-image");
                            }else{
                            $defaultImage = config("default-image.female-image");
                            }
                            @endphp
                            <div class="d-flex align-items-center">
                                {{ $user->id }} ||
                                <img src="{{ asset($user->images->first()?->main_image ?? $defaultImage ) }}"
                                    class="rounded-circle ms-2" alt="avatar"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                        </td>
                        <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                            <strong>{{ $user->first_name ." ". $user->last_name}}</strong>
                        </td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->phone }}</td>
                        <td class="text-center">{{ $user->whatsapp }}</td>
                        <td class="text-center">{{ $user->gender }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm "
                                wire:click.prevent="$dispatch('showDetailsUserEnent', {id: '{{ $user->id }}'})">
                                <i class='bx bx-info-circle text-primary'></i> Info
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <h5 class="text-center">" Total: {{ $users->total() }} "</h5>
            </table>
            @else
            <div class="text-center">
                <div class="alert alert-danger text-center" role="alert">This user Not Found!</div>
            </div>
            @endif
        </div>
    </div>
    <div class="text-center p-3">
        {{ $users->links() }}
    </div>

</div>