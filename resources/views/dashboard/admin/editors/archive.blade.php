@extends('layouts.app')
@section("admin-title", "Archive Editors")
@section('admin-content')


<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Deleted Editors</h2>
                <a href="{{ route('admin-dashboard.customer_s.all') }}" class="btn btn-primary">
                    <i class='bx bx-collection'></i> All Editors
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$editors">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            {{-- <th class="text-center">Branch</th> --}}
                            <th class="text-center">Phone</th>
                            <th class="text-center">Whatsapp</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center" style="width: 200px;">Address</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Deleted-At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($editors as $editor)
                        <tr>
                            <td class="text-center">
                                @php
                                if($editor->gender == "male"){
                                $defaultImage = config("default-image.male-image");
                                }else{
                                $defaultImage = config("default-image.female-image");
                                }
                                @endphp
                                <div class="d-flex align-items-center">
                                    {{ $editor->id }} ||
                                    <img src="{{ asset($editor->images->first()?->main_image ?? $defaultImage) }}"
                                        class="rounded-circle ms-2" alt="avatar"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </td>
                            <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $editor->name
                                    }}</strong>
                            </td>
                            <td class="text-center">{{ $editor->email }}</td>
                            {{-- <td class="text-center">
                                @if ($editor->branch)
                                <b class="badge bg-label-primary me-1 fw-bold">
                                    {{ $editor->branch->name }}
                                </b>
                                @else
                                <b class="badge bg-label-danger me-1">No Branch</b>
                                @endif
                            </td> --}}
                            <td class="text-center">{{ $editor->phone }}</td>
                            <td class="text-center">{{ $editor->whatsapp }}</td>
                            <td class="text-center">{{ $editor->gender }}</td>
                            <td class="text-center">
                                <textarea class="form-control" rows="3"
                                    style="width: 100%; min-width: 200px; resize: none;" readonly>
                                        {{ $editor->address }}
                                    </textarea>
                            </td>
                            <td class="text-center">{{ $editor->role }}</td>
                            <td class="text-center">
                                <b class="badge bg-label-danger me-1 fw-bold">
                                    {{ $editor->deleted_at }}
                                </b>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route('admin-dashboard.editors.restore', $editor->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-undo"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin-dashboard.editors.remove', $editor->id) }}"
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
                    <h5 class="text-center">Total: {{ $editors->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $editors->links() }}
            </div>
        </div>
    </div>
</div>












@endsection