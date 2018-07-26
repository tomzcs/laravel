@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  {{ $title }}
                </div>

                <div class="card-body">
                  <form action="{{ url('edit_save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$user['id']}}">
                    <div class="form-group row">
                      <label  class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$user['email']}}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{$user['name']}}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-2 col-form-label">Roles</label>
                      <div class="col-sm-10">

                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" value="{{$role->id}}" name="roles[]"
                                @if(in_array($role->name, $user['role']))
                                  checked
                                @endif
                                >
                                <label class="form-check-label" for="exampleCheck1">{{$role->name}}</label>
                            </div>
                        @endforeach
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ URL::previous() }}">
                      <button type="button" class="btn btn-primary">Back</button>
                    </a>
                  </form>
              </div>{{-- end card --}}
          </div>{{-- end col-8 --}}

    </div>
</div>
@endsection
