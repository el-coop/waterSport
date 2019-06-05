@extends('layouts.plain')

@section('body')
    <div class="dashboard" v-cloak>
        @include('elcoop:navbar::navbar')
        <main>
            <navbar class="is-dark">@component('components.logout')
                @endcomponent
            </navbar>
            <div class="container is-fluid">
                @yield('content')
            </div>
        </main>
    </div>
@endsection

