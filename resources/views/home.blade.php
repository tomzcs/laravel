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
                      <table id="users-table" class="table">
                        <thead>
                          <th>id</th>
                          <th>name</th>
                          <th>email</th>
                          <th>role</th>
                          <th>***</th>
                        </thead>
                      </table>
                    @endif
                </div>
            </div>{{-- end card --}}
        </div>{{-- end col-8 --}}
    </div>
</div>
@endsection
