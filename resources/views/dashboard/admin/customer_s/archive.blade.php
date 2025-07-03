@extends('layouts.app')
@section('admin-title', 'Archive Customer Services')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Deleted Customer Services</h2>
                <a href="{{ route('admin-dashboard.customer_s.all') }}" class="btn btn-primary">
                    <i class='bx bx-collection'></i> Customer Services
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$customerServices">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Whatsapp</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center" style="width: 200px;">Address</th>
                            <th class="text-center">Deleted-At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($customerServices as $customerService)
                        <tr>
                            <td class="text-center">
                                @php
                                if($customerService->gender == "male"){
                                $defaultImage = config("default-image.male-image");
                                }else{
                                $defaultImage = config("default-image.female-image");
                                }
                                @endphp
                                <div class="d-flex align-items-center">
                                    {{ $customerService->id }} ||
                                    <img src="{{ asset($customerService->images->first()?->main_image ?? $defaultImage ) }}"
                                        class="rounded-circle ms-2" alt="avatar"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </td>
                            <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $customerService->name
                                    }}</strong>
                            </td>
                            <td class="text-center">{{ $customerService->email }}</td>
                            <td class="text-center">{{ $customerService->phone }}</td>
                            <td class="text-center">{{ $customerService->whatsapp }}</td>
                            <td class="text-center">{{ $customerService->gender }}</td>
                            <td class="text-center">
                                <textarea class="form-control" rows="3"
                                    style="width: 100%; min-width: 200px; resize: none;" readonly>
                                            {{ $customerService->address }}
                                </textarea>
                            </td>
                            <td class="text-center">
                                <b class="badge bg-label-danger me-1 fw-bold">
                                    {{ $customerService->deleted_at }}
                                </b>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <form
                                        action="{{ route('admin-dashboard.customer_s.restore', $customerService->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-undo"></i>
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('admin-dashboard.customer_s.remove', $customerService->id) }}"
                                        method="post" data-confirm-delete="true">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <h5 class="text-center">Total: {{ $customerServices->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $customerServices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection