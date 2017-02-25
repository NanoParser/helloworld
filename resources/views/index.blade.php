@extends('layouts.main')

@section('content')
    @foreach($nodes as $node)
        <div class="row row-margin-bottom">
            <div class="col-md-5 no-padding lib-item" data-category="view">
                <div class="lib-panel">
                    <div class="row box-shadow">
                        <div class="col-md-6">
                            <img class="lib-img-show" src="{{ $node['img'] }}">
                        </div>
                        <div class="col-md-6">
                            <div class="lib-row lib-header">
                                <span style="color:brown">{{ $node['title'] }}</span>
                                <div class="lib-header-seperator"></div>
                            </div>
                            <div class="lib-row lib-desc">
                                <span style="color:black">{{ $node['body'] }}</span>
                                <br>
                                <span style="color:greenyellow">{{ $node['domain'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection