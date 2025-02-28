<x-app-layout>
    <x-slot name="breadcrumb">
        <x-admin.breadcrumb>
            @foreach (config('theme.cdata.breadcrumb') as $i )
            <x-admin.bread-item href="{{ $i['link'] }}" class="{{ $i['link']?'':'active' }}">
                {{ $i['name'] }}
            </x-admin.bread-item>
            @endforeach
            <x-slot name="title">
                {{ config('theme.cdata.title') }}
            </x-slot>
        </x-admin.breadcrumb>
    </x-slot>

    <div class="container px-0">
        <div name="title">
            <div class="d-sm-flex justify-content-end">
                <div class="">
                    @can('user_create')
                    @if (config('theme.cdata.add'))
                    <a href="{{ config('theme.cdata.add') }}"
                        class="btn btn-primary btn-rounded waves-effect waves-light">
                        <i class="bx bx-plus"></i> Add New
                    </a>
                    @endif
                    @endcan


                    @if (config('theme.cdata.back'))
                    <a href="{{ config('theme.cdata.back') }}"
                        class="btn btn-info btn-rounded waves-effect waves-light">
                        <i class="bx bx-share"></i> Back
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-md-12 mx-auto">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ $user->profile_photo_url }}" alt="user profile image" class="rounded-circle border-success profile-img">
                                    <div class="mt-3">
                                        <h4>{{ $user->name }}</h4>
                                        <p class="text-secondary mb-0">{{ get_user_role($user)->name }}</p>
                                        <p class="text-secondary mb-2">{{ $user->email }}</p>
                                        <a href="{{ route('admin.user.profile.settings') }}" class="btn btn-primary btn-round">
                                            <i class="zmdi zmdi-edit"></i> Settings Update
                                        </a>
                                        <a href="{{ route('admin.user.profile.edit') }}" class="btn btn-success btn-round">
                                            <i class="zmdi zmdi-edit"></i> Profile Update
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 shadow">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class="bx bxl-facebook text-primary"></i> Facebook</h6>
                                    <small class="text-secondary"><b>{{ $user->facebook }}</b></small>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class="bx bxl-twitter text-info"></i> Twitter</h6>
                                    <small class="text-secondary"><b>{{ $user->twitter }}</b></small>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><i class="bx bxl-whatsapp text-success"></i> WhatsApp</h6>
                                    <small class="text-secondary"><b>{{ $user->whatsapp }}</b></small>
                                </li>
                            </ul>
                        </div>


                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3 shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $user->name }}
                                    </div>
                                </div>
                                {{-- <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Username</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $user->username }}
                                    </div>
                                </div> --}}
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $user->phone }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $user->address }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Date Of Birth</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $user->birth }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Account Status</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $user->status->name }}
                                    </div>
                                </div>
                                <hr>


                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Account Created</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('extra-scripts')
        <style>
            .profile-img{
                width: 120px;
                height: 120px;
                border: 2px solid;
            }
        </style>
    @endpush

</x-app-layout>
