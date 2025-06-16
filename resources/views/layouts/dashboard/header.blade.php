<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="dropdown navbar-nav ms-auto">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name d-flex align-items-center justify-content-center text-center me-3">
                                <h6 class="mb-0 text-gray-600">{{ auth()->user()->name}}</h6>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{asset('assets/static/images/faces/1.jpg')}}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">{{ auth()->user()->name}}</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" onclick="destroy()"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                        <script>
                            function destroy() {
                               $.ajax({
                                   url: '{{ route('logout') }}',
                                   type: 'POST',
                                   data: {
                                       _token: '{{ csrf_token() }}'
                                   },
                                   success: function () {
                                       window.location.href = '{{ route('login') }}';
                                   }
                               });
                            }
                        </script>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
