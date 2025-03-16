<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('even') }}">Even Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('prime') }}">Prime Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('multable') }}">Multiplication Table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('multiquiz') }}">Multiplication Quiz</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('minitest') }}">Mini Test</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/transcript">Transcript</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('calculator') }}">Calculator</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('gpa-simulator') }}">GPA Simulator</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('products_list')}}">Products</a>
            </li>
        </ul>
    </div>
</nav>
