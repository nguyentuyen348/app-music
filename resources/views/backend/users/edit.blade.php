
<div class="container">
    <div>
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            @if($user)
            <label for="">full name</label>
            <input type="text" name="full_name" value="{{$user->full_name}}">
            <br>
            <label for="">phone</label>
            <input type="text" name="phone" value="{{$user->phone}}">
            <br>
            <label for="">address</label>
            <input type="text" name="address" value="{{$user->address}}">
            <br>
            <label for="">email</label>
            <input type="email" name="email" value="{{$user->email}}">
            <br>
            <label for="">avatar</label>
            <input type="file" name="avatar" value="{{'storage/'.$user->avatar}}">
            <br>
            <img style="width: 150px" src="{{asset('storage/'.$user->avatar)}}" alt="{{asset('storage/'.$user->avatar)}}">
            <br>
            @endif
            <button type="submit">submit</button>
        </form>
    </div>
</div>
