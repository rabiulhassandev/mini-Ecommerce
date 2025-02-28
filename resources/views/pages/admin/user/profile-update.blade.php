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

    <x-card class="container bg-white">
        <div class="row" style="padding: 20px 0">
            <div class="col-sm-12">
                <form enctype="multipart/form-data"
                    action="{{ route('admin.user.profile.update') }}"
                    method="POST" class=" needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class=" row">

                        <div class="form-group col-md-6">
                            <label for="name" class="font-black">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name"
                                value="{{ $data->name }}" required>
                            @error('name')
                            <p class="text-danger pt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="font-black">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" value="{{ $data->email }}" required readonly>
                            @error('email')
                            <p class="text-danger pt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone" class="font-black">Phone No</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your phone no" value="{{ $data->phone }}" required>
                            @error('phone')
                            <p class="text-danger pt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="birth" class="font-black">Date Of Birth</label>
                            <input type="date" class="form-control" name="birth" id="birth" placeholder="Enter your birth" value="{{ $data->birth }}" required>
                            @error('birth')
                            <p class="text-danger pt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address" class="font-black">Address</label>
                            <textarea name="address" id="address" class="form-control" cols="30" rows="3" placeholder="Enter your address">{{ $data->address }}</textarea>
                            @error('address')
                            <p class="text-danger pt-2">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="col-12 pt-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="facebook" class="font-black">Facebook Link</label>
                                    <input type="url" class="form-control" name="facebook" id="facebook" placeholder="https://www.facebook.com/username" value="{{ $data->facebook }}" required>
                                    @error('facebook')
                                    <p class="text-danger pt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="twitter" class="font-black">Twitter Link</label>
                                    <input type="url" class="form-control" name="twitter" id="twitter" placeholder="https://twitter.com/username" value="{{ $data->twitter }}" required>
                                    @error('twitter')
                                    <p class="text-danger pt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="whatsapp" class="font-black">WhatsApp No</label>
                                    <input type="text" class="form-control" name="whatsapp" id="whatsapp" placeholder="enter your whatsapp number" value="{{ $data->whatsapp }}" required>
                                    @error('whatsapp')
                                    <p class="text-danger pt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 ">
                            <div class="form-group py-1">
                                <button type="submit" class="btn btn-primary btn-round">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-card>
</x-app-layout>
