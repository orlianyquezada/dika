@extends('adminlte::page')
@section('title', 'Admin - Create users')
@section('content_header')
    <h1>Create users</h1>
@stop
@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show col-sm-12" role="alert">
            @foreach ($errors->all() as $error)
                <span class="d-block">{{$error}}</span>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form action="{{ route('user.store') }}" method="post" class="row">
        @csrf
        {{-- Name field --}}
        <div class="input-group mb-3 col-sm-12 col-md-6">
            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}"  autofocus
            >
            @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>


        {{-- Email field --}}
        <div class="input-group mb-3 col-sm-12 col-md-6">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}" placeholder="Email"  autofocus
            >
            @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        {{-- Role field --}}
        <div class="input-group mb-3 col-sm-12 col-md-6">
            <select name="rol" class="rol form-control {{ $errors->has('rol') ? 'is-invalid' : '' }}">
                @foreach ($roles as $rol)
                    <option value="{{ $rol->name }}" @if (old('rol') == $rol->id) selected @endif> {{$rol->name}} </option>
                @endforeach
            </select>
            @if($errors->has('rol'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('rol') }}</strong>
                </div>
            @endif
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3 col-sm-12 col-md-6">
            <input type="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="{{ __('adminlte::adminlte.password') }}">
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>

        {{-- Confirm password field --}}
        <div class="input-group col-sm-12 col-md-6">
            <input type="password" name="password_confirmation"
                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                    placeholder="{{ __('adminlte::adminlte.retype_password') }}">
            @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
            @endif
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block col-sm-12 col-md-6 {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            Create user
        </button>
    </form>
@stop
@section('css')
@stop

@section('js')
    <script>
        $('.rol').select2()
    </script>
@stop
