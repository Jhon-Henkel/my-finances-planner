<nav>
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="offcanvas" title="Menu" href="" data-bs-target="#sidebar" aria-controls="sidebar">
                <i class="fa-solid fa-bars"></i>
            </a>
        </li>
        <li class="nav-item">
            {{-- todo criar rota e tela para configurações --}}
            <a class="nav-link active" aria-current="page" href="#" title="Configurações">
                <i class="fa-solid fa-gear"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('logout')}}" title="Logout">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </li>
    </ul>
</nav>