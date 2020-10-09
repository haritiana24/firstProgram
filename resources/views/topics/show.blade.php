@extends('layouts.app')
@section('extra-js')
    <script>
        function toggleReplyComment(id)
        {
            let element = document.getElementById("replyComment" + id)
            element.classList.toggle('d-none')
        }
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$topic->title}}</h5>
                <p>{{$topic->content}}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small> Posté le {{$topic->created_at->format('d/m/Y  à H:m')}}</small>
                    <span class="badge badge-primary">{{$topic->user->name}}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    @can('update', $topic)
                    <a href="{{route('topics.edit', $topic)}}" class="btn btn-warning">Modifer ma publication</a>
                    @endcan
                    @can('delete', $topic)
                    <form action="{{route('topics.destroy', $topic)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        <hr>
        <h5>Commentaire</h5>
        @forelse($topic->comments as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    {{$comment->content}}
                    <div class="d-flex justify-content-between align-items-center">
                        <small> Posté le {{$comment->created_at->format('d/m/Y')}}</small>
                        <span class="badge badge-primary">{{$comment->user->name}}</span>
                    </div>
                </div>
            </div>
        @foreach($comment->comments as $commentReply)
                <div class="card mb-2 ml-5">
                    <div class="card-body">
                        {{$commentReply->content}}
                        <div class="d-flex justify-content-between align-items-center">
                            <small> Posté le {{$commentReply->created_at->format('d/m/Y')}}</small>
                            <span class="badge badge-primary">{{$commentReply->user->name}}</span>
                        </div>
                    </div>
                </div>
        @endforeach
        @auth
            <button class="btn btn-info mb-3"  onclick="toggleReplyComment({{$comment->id}})">Répondre</button>
            <form action="{{route('comments.storeReply', $comment)}}" method="post" class="ml-5 d-none" id="replyComment{{$comment->id}}">
                @csrf
                <div class="form-group">
                    <label for="replyComment">Ma réponse</label>
                    <textarea name="replyComment" id="replyComment" rows="5" class="form-control @error('replyComment') is-invalid @enderror"></textarea>
                    @error('replyComment')
                    <div class="invalid-feedback">{{$errors->first('replyComment')}}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">Répondre à ce commentaire</button>
            </form>
        @endauth
        @empty
            <div class="alert alert-info">
                Aucun commentaire pour ce publication
            </div>
        @endforelse
        <form action="{{route('comments.store', $topic)}}" method="post" class="mt-3">
            @csrf
           <div class="form-group">
               <label for="content">Votre commentaire</label>
               <textarea type="text" name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror"></textarea>
               @error('content')
               <div class="invalid-feedback">
                   {{$errors->first('content')}}
               </div>
               @enderror
           </div>
            <button type="submit" class="btn btn-primary">Sommetre mon commentaire</button>
        </form>
    </div>
@endsection
