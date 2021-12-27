<html>
    <head>
        <title>About</title>
    </head>
    
    <h1>About page</h1>

    <a href="{{ url('/') }}">Home</a> |
    <a href="{{ URL::to('/about') }}">About</a> |
    <a href="{{ route('contact') }}">Contact</a> |

</html>