@extends('layouts.profilefront')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="name">
                                    {{ str_limit($post->name, 80) }}
                                </div>
                                <div class="hobby mx-auto">
                                    {{ str_limit($post->hobby, 300) }}
                                </div>
                                <div class="introduction mx-auto">
                                    {{ str_limit($post->introduction, 600) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection