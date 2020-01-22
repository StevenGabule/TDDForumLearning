@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted: {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div><!-- end of col-md-8 -->
        </div><!-- end of row -->

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div><!-- end of row -->

        @if(auth()->check())
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <form action="{{$thread->path() . '/replies'}}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Leave a comment"
                                      rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div><!-- end of row -->
            @else
            <p class="text-center mt-4">Please <a href="{{ route('login') }}">sign in</a> or <a href="{{ route('register') }}">sign up</a> to participate in this discussion.</p>
        @endif

    </div><!-- end of container -->
@endsection
