<div id="content" class="container-xxl">

    <!-- header -->
    <header class="border-bottom shadow-sm">
        <ul>
            <li class="me-2"><a href="/" class="brand">Simple<span>-MVC-</span>Project</a></li>
            <li class="me-auto"><a href="/home">Home</a></li>
             @if(\App\Core\Facades\Auth::check())
                <li><a href="/profile">Profile</a></li>
                <form action="/logout" method="post" id="logoutForm"></form>
                @if(\App\Core\Facades\Gate::allows('admin'))
                    <li><a href="/admin/panel">Admin-Panel</a></li>
                @endif
                <li><a href="/logout" onclick="event.preventDefault();document.getElementById('logoutForm').submit()">Logout</a></li>
            @else
                <li ><a href="/login" >Login</a></li>
                <li><span>|</span></li>
                <li><a href="/signup">SignUp</a></li>
            @endif

        </ul>
    </header>
    <!-- !header -->

</div>