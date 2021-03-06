@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new thread</div>
                    <div class="card-body">
                        <form action="/threads" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id">Choose a channel</label>
                                <select name="channel_id" id="channel_id" class="form-control">
                                    <option value="">Choose one..</option>
                                    @foreach(App\Channel::all() as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Enter title" value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea name="body" id="body" cols="" rows="10" placeholder=""
                                          class="form-control">{{old('body')}}</textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Publish</button>
                        </form>

                        @if(count($errors))
                            <ul class="alert alert-danger mt-4">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
