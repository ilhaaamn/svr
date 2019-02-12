@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">
@stop

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/models')}}">Bike Models</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Display</a>
        </li>
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <h4>Report Detail</h4>
            <h6>Branch: {{ $reports->branches->name }}</h6>
            <h6>Submitted by: {{ $reports->users->name }}</h6>
            <h6>On: {{ \Carbon\Carbon::parse($reports->record_date)->format('M d, Y H:i:s') }}</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Models</th>
                        <th scope="col">Display Qty</th>
                        <th scope="col">Talker</th>
                        <th scope="col">Flayer</th>
                        <th scope="col">Streamer</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports->details as $detail)
                        <tr>
                            <td scope="row">{{$detail->code_model}}</td>
                            <td>{{ $detail->dsp_qty }}</td>
                            <td>{{ $detail->talker }}</td>
                            <td>{{ $detail->flayer }}</td>
                            <td>{{ $detail->streamer }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <h4 class="mt-3">Document Photos</h4>
            <div class="row">
                @foreach($reports->documents as $document)
                    <div class="col-md-3">
                        <a href="{{ asset('/images/'.$document->pic_path) }}"
                           data-lightbox="document">
                            <img class="img-thumbnail"
                                 src="{{ asset('/images/'.$document->pic_path) }}"
                                 alt="File {{ asset('/images/'.$document->pic_path) }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <script src="{{ asset('js/lightbox.min.js') }}"></script>
@endsection