<h1>Login Successfull</h1>

<h2>
   Hi,  {{Auth::user()->email}}
</h2>

<a href="{{url('getUserData')}}">Click here to view user detail</a>

<h3>
    <a href="{{route('logout')}}">logout</a>
</h3>

