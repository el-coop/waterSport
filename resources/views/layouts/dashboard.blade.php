@extends('layouts.plain')

@section('body')
    <div class="dashboard" v-cloak>
        @include('elcoop:navbar::navbar')
        <main>
            <navbar></navbar>
        </main>
    </div>
@endsection

