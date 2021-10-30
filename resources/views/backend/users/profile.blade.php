<div class="container">
    @if($user)
    <div class="card-body">
        <label for="">avatar:</label>
        <br>
        <img style="width: 150px" src="{{asset('storage/'.$user->avatar)}}" alt="">
        <br>
        <label for="">full name:</label>
        <p>{{$user->full_name}}</p>
        <label for="">phone:</label>
        <p>{{$user->phone}}</p>
        <label for="">email:</label>
        <p>{{$user->email}}</p>
        <label for="">address:</label>
        <p>{{$user->address}}</p>
    </div>
        <div>
            <a class="btn btn-success" href="{{route('users.edit',$user->id)}}">EDIT</a>
        </div>
    @endif
</div>
