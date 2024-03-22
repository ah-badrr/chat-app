@extends('master.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-chat card">
            <div class="row g-0">

                <!-- Chat History -->
                <div class="col app-chat-history">
                    <div class="chat-history-wrapper">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex overflow-hidden align-items-center">
                                        <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2"
                                            data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                                        <div class="flex-shrink-0 avatar">
                                            <img src="{{ asset('dist') }}/assets/img/avatars/1.png" alt="Avatar"
                                                class="rounded-circle">
                                        </div>
                                        <div class="chat-contact-info flex-grow-1 ms-3">
                                            <h6 class="m-0">{{ $group->nama_group }}</h6>
                                            <small class="user-status text-muted">NextJS developer</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                                        <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                                        <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="chat-header-actions"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="chat-header-actions">
                                                <a class="dropdown-item" href="javascript:void(0);">View Contact</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Mute Notifications</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Block Contact</a>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#clearChat">Clear Chat</button>
                                                <a class="dropdown-item" href="javascript:void(0);">Report</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body chat-body"
                                style="background:#F5F5F9;height: 28rem; overflow:auto !important; padding:2rem 2rem;">
                                <ul class="list-unstyled chat-history mb-0">
                                    @foreach ($chat as $c)
                                        @php
                                            $hide = DB::table('hide')
                                                ->where('user_id', '=', Auth::user()->id)
                                                ->where('chat_id', '=', $c->id)
                                                ->get();
                                        @endphp
                                        @if (count($hide) == null)
                                            <li class="d-flex mb-3 {{ $c->from == Auth::user()->id ? 'justify-content-end' : '' }} "
                                                style="width:100% !important">
                                                @if ($c->from != Auth::user()->id)
                                                    <div class="user-avatar flex-shrink-0 me-3">
                                                        <div class="avatar avatar-sm">
                                                            <img src="{{ asset('dist') }}/assets/img/avatars/1.png"
                                                                alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="card position-relative text-wrap {{ $c->from == Auth::user()->id ? 'bg-primary text-white text-end' : 'bg-white' }} shadow-sm p-0 mb-0"
                                                    style="text-wrap: wrap !important; width: max-content; max-width: 70%; border-radius: 10px 0 10px 10px;"
                                                    type="button"id="chat-header-actions" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <div class="card-header py-0 px-2 pt-1 small">
                                                        <small>{{ $c->suser->name }}</small>
                                                    </div>
                                                    <div class="card-body py-0 px-2">{{ $c->messages }}</div>
                                                    <div
                                                        class="card-footer px-2 {{ $c->from == Auth::user()->id ? 'text-start' : 'text-end' }} py-0 pb-1 small">
                                                        <small>{{ $c->created_at->isoFormat('HH:mm') }}</small>
                                                    </div>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="chat-header-actions">

                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#deleteMe{{ $c->id }}">
                                                        <i class="fas fa-right-from-bracket mr-2"></i>Delete for me
                                                    </button>
                                                    @if ($c->from == Auth::user()->id)
                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#deleteAll{{ $c->id }}">
                                                            <i class="fas fa-right-from-bracket mr-2"></i>Delete for all
                                                        </button>

                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#basicModal{{ $c->id }}">
                                                            <i class="fas fa-edit mr-2"></i>Edit
                                                        </button>
                                                    @endif
                                                </div>
                                                @if ($c->from == Auth::user()->id)
                                                    <div class="user-avatar flex-shrink-0 ms-3">
                                                        <div class="avatar avatar-sm">
                                                            <img src="{{ asset('dist') }}/assets/img/avatars/1.png"
                                                                alt="Avatar" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                @endif

                                            </li>
                                        @endif
                                        <div class="modal fade" id="basicModal{{ $c->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="{{ route('chat.update', $c->id) }}" method="post"
                                                    class="modal-content">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel1">Edit
                                                                Messages
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea class="form-control" name="message" id="" cols="30" rows="3">{{ $c->messages }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deleteAll{{ $c->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <form action="{{ route('chat.destroy', $c->id) }}" method="post"
                                                    class="modal-content">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel1">Yakin akan
                                                                hapus untuk semua??
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Delete for
                                                                all</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deleteMe{{ $c->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <form action="{{ route('hide.store', $c->id) }}" method="post"
                                                    class="modal-content">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel1">Yakin akan
                                                                hapus untuk anda??
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Delete for
                                                                me</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                                <div class="modal fade" id="clearChat" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <form action="{{ route('chat.clearg', $group->id) }}" method="post"
                                            class="modal-content">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel1">Yakin akan
                                                        bersihkan semua chat??
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Clear
                                                        chat</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border-top">
                                <form action="{{ route('chat.storeG', $id) }}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="message" placeholder="Type Message ..."
                                            class="form-control">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Chat History -->
            </div>
        </div>
    </div>
@endsection
