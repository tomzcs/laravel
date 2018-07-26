@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                  Dashboard {{ $title }}
                </div>

                <div class="card-body">
                      @if(in_array('manager', $roles))
                      You are manager
                      <table class="table">
                        <thead>
                          <tr>
                            <th>id</th>
                            <th>Firstname</th>
                            <th>email</th>
                            <th>role</th>
                            <th>***</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                              <tr>
                                <td>{{$user['id']}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>
                                  @foreach ($user['role'] as $role)
                                    @if($role == 'manager')
                                      <span class="badge badge-danger">{{ $role }}</span>
                                    @elseif($role == 'mobile')
                                      <span class="badge badge-success">{{ $role }}</span>
                                    @else
                                      <span class="badge badge-primary">{{ $role }}</span>
                                    @endif
                                  @endforeach
                                </td>
                                <td>
                                  <a href="{{ url('edit_form/' . $user['id']) }}">
                                    <svg id="i-edit" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z" />
                                    </svg>
                                  </a>
                                </td>
                              </tr>
                          @endforeach
                        </tbody>
                      </table>
                    {{-- @elseif($roles[0] == 'employee')
                      You are employee --}}
                    @endif
                </div>
            </div>{{-- end card --}}
        </div>{{-- end col-8 --}}
    </div>
</div>

@endsection
@push('scripts')
@endpush
