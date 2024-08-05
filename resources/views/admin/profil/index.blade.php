@extends('layouts.index')

@section('title')
Profil
@endsection

@section('content')


<div class="w-full px-6 mx-auto">
    <div class="relative flex items-center p-0 mt-6 overflow-hidden bg-center bg-cover min-h-75 rounded-2xl" style="background-image: url('../assets/logo.svg'); background-position-y: 50%">
        <span class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-t from-white to-red-700 opacity-60"></span>
    </div>
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
                <div class="text-base ease-soft-in-out h-18.5 w-18.5 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                    <img src="{{ asset('assets/mv-logo.png')}}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl" />
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1">{{ Auth::user()->username }}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm">{{ Auth::user()->bagian }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="w-full px-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full rounded-2xl px-3 mt-6">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white rounded-2xl">
                    <h6 class="mb-1">Akun Saya</h6>
                    <hr class="h-px mt-0 bg-transparent top-2 bg-gradient-to-r from-transparent via-black/40 to-transparent" />
                    <div class="flex-auto">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg leading-normal text-sm mx-4">
                            <li class="relative block px-4 pt-0 pl-0 leading-normal bg-white border-0 rounded-t-lg text-sm text-inherit"><strong class="text-slate-700">Nama:</strong> {{ Auth::user()->username }}</li>
                            <li class="relative block px-4 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit"><strong class="text-slate-700">Bagian:</strong> {{ Auth::user()->bagian }}</li>
                            <li class="relative block px-4 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit mb-6"><strong class="text-slate-700">Akses:</strong> {{ Auth::user()->hak_akses }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
