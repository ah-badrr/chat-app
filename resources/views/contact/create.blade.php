@extends('master.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            @php
                $user = DB::table('user')
                    ->where('id', '!=', Auth::user()->id)
                    ->get();
            @endphp
            @foreach ($user as $u)
                @php
                    $ada = DB::table('contact')
                        ->where('maker', '=', Auth::user()->id)
                        ->where('receiver', '=', $u->id)
                        ->get();
                @endphp
                @if (count($ada) == null)
                    <div class="col-2">
                        <div class="card mb-4">
                            <h5 class="card-header text-center">{{ $u->name }}</h5>
                            <!-- Account -->
                            <hr class="my-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-center align-items-sm-center">
                                    <img src="{{ asset('dist') }}/assets/img/avatars/1.png" alt="user-avatar"
                                        class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                                </div>
                            </div>
                            <hr class="my-0">
                            <div class="card-footer text-center">
                                <form id="formAccountSettings" method="POST" action="{{ route('contact.store') }}">
                                    @csrf
                                    <input type="number" name="maker" value="{{ Auth::user()->id }}" hidden>
                                    <input type="number" name="receiver" value="{{ $u->id }}" hidden>
                                    <button type="submit" class="btn btn-primary me-2">Add</button>
                                </form>
                            </div>
                            <!-- /Account -->
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
