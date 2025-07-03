@extends('layouts.app')
@section('admin-title', 'All Messages')
@section('admin-content')

<div class="card-body">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">All Messages</h2>

      </div>
      <x-error></x-error>

      <x-table.index :items="$messages">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 10px">ID</th>
              <th class="text-center">Name</th>
              <th class="text-center">Email</th>
              <th class="text-center">Phone</th>
              <th class="text-center">Subject</th>
              <th class="text-center">Message</th>
              <th class="text-center">Delete</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($messages as $message)
            <tr>
              <td>{{ $message->id }} || </td>
              <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                <strong>{{
                  $message->name
                  }}</strong>
              </td>

              <td class="text-center">{{ $message->email }}</td>
              <td class="text-center">{{ $message->phone }}</td>
              <td class="text-center">{{ $message->subject }}</td>
              <td class="text-center">
                <textarea class="form-control" rows="3" style="width: 100%; height: 100px; resize: none;"
                  readonly>{{$message->message}}</textarea>
              </td>
              <td class="text-center">
                <form action="{{route(" admin-dashboard.message.delete", $message)}}" method="post"
                  data-confirm-delete="true">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-icon btn-outline-danger confirm-delete">
                    <i class="bx bx-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
          <h5 class="text-center">Total: {{ $messages->total() }}</h5>
        </table>

      </x-table.index>

      <div class="text-center p-3">
        {{ $messages->links() }}
      </div>
    </div>
  </div>
</div>





@endsection