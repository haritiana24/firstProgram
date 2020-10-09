@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Publer quelque chose</h1>
        <hr>
        <form action="{{route('topics.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Le titre</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                @error('title')
                <div class="invalid-feedback">
                    {{$errors->first('title')}}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">Votre sujet </label>
                <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror"> </textarea>
                @error('content')
                <div class="invalid-feedback">
                    {{$errors->first('content')}}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Paratager</button>
        </form>
    </div>
@endsection
