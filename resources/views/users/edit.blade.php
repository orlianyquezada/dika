@extends('adminlte::page')
@section('title', 'Admin - editar usuarios')
@section('content_header')
    <h1>Edit users</h1>
@stop
@section('content')
    @if(Session::has('message')) <div class="callout callout-success"><p>{{Session::get('message')}}</p></div> @endif
    <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" class="row">
        {{ csrf_field() }}
        @method('put')
        <input type="hidden" name="user_valid" value="{{$user->id}}">
        {{-- Name field --}}
        <div class="input-group mb-3 col-sm-12 col-md-6">
            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    value="{{ $user->name }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>
            @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>

        {{-- Name field --}}
        <div class="input-group mb-3 col-sm-12 col-md-6">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
            value="{{ $user->email }}" placeholder="Email"  autofocus
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
                    <option value="{{ $rol->name }}" @if ($user->hasRole($rol->name)) selected @endif> {{$rol->name}} </option>
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
            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('adminlte::adminlte.password') }}">
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>

        {{-- Confirm password field --}}
        <div class="input-group col-sm-12 col-md-6">
            <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="{{ __('adminlte::adminlte.retype_password') }}">
            @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
            @endif
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block col-sm-12 col-md-6 {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            Update
        </button>
    </form>
@stop
@section('css')
@stop
@section('js')
    <script>
        $('document').ready(function(){
            $('.rol').select2()
        })
    </script>
@stop
