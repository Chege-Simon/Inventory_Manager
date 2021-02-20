<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
        <!-- Sweet ALert -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" />

{{--        <script src="sweetalert2/dist/sweetalert2.all.min.js"></script>--}}
{{--        <!-- Include a polyfill for ES6 Promises (optional) for IE11 -->--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>--}}
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ mix('js/dashboard.js') }}" defer></script>
        <script src="https://use.fontawesome.com/19785ef262.js"></script>

    </head>
    <body class="c-app font-sans antialiased">
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
            <div class="c-sidebar-brand">
                <a href="/">
                    <x-jet-application-mark class="c-sidebar-brand-minimized" width="36" />
                    <x-jet-application-mark class="c-sidebar-brand-full" width="36" />
                </a>
            </div>

            <ul class="c-sidebar-nav">
                {{ $sidebar ?? '' }}
                <li class="c-sidebar-nav-item mt-3">
                    <a class="c-sidebar-nav-link" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <i class="fa fa-th-large" style="font-size: 2em" aria-hidden="true"></i>
                        <span class="lead ml-3">Dashboard</span>
                    </a>
                </li>
                <li class="c-sidebar-nav-item mt-3">
                    <a class="c-sidebar-nav-link" href="/materials" :active="request()->routeIs('materials')">
                        <i class="fa fa-industry" style="font-size: 2em" aria-hidden="true"></i>
                        <span class="lead ml-3">Materials</span>
                    </a>
                </li>
                <li class="c-sidebar-nav-item mt-3">
                    <a class="c-sidebar-nav-link" href="/products" :active="request()->routeIs('products')">
                        <i class="fa fa-shopping-cart" style="font-size: 2em" aria-hidden="true"></i>
                        <span class="lead ml-3">Products</span>
                    </a>
                </li>
                <li class="c-sidebar-nav-item mt-3">
                    <a class="c-sidebar-nav-link" href="/sales" :active="request()->routeIs('sales')">
                        <i class="fa fa-money" style="font-size: 2em" aria-hidden="true"></i>
                        <span class="lead ml-3">Sales</span>
                    </a>
                </li>
            </ul>
            <span class="c-sidebar-nav-item mb-5">
                <a class="c-sidebar-nav-link" href="">
                    <i class="fa fa-sign-out text-danger" style="font-size: 2em" aria-hidden="true"></i>
                    <span class="lead ml-3 text-danger">Logout</span>
                </a>
            </span>
            <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
        </div>
        <div class="c-wrapper">
            <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
                <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                    <span class="c-header-toggler-icon"></span>
                </button>

                <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                    <span class="c-header-toggler-icon"></span>
                </button>

                <ul class="c-header-nav d-md-down-none">
                    <li class="c-header-nav-item px-3 btn">
                        <x-jet-nav-link href="/settings" :active="request()->routeIs('settings')">
                            <i class="fa fa-cogs mr-3" aria-hidden="true"></i>
                            {{ __('Settings') }}
                        </x-jet-nav-link>
                    </li>
                </ul>

                <ul class="c-header-nav ml-auto mr-4">
                    <!-- Teams Dropdown -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <x-jet-dropdown id="teamManagementDropdown">
                            <x-slot name="trigger">
                                {{ Auth::user()->currentTeam->name }}

                                <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Team Management -->
                                <h6 class="dropdown-header">
                                    {{ __('Manage Team') }}
                                </h6>

                                <!-- Team Settings -->
                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                    {{ __('Team Settings') }}
                                </x-jet-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                    <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                        {{ __('Create New Team') }}
                                    </x-jet-dropdown-link>
                                @endcan

                                <hr class="dropdown-divider">

                                <!-- Team Switcher -->
                                <h6 class="dropdown-header">
                                    {{ __('Switch Teams') }}
                                </h6>

                                @foreach (Auth::user()->allTeams() as $team)
                                    <x-jet-switchable-team :team="$team" />
                                @endforeach
                            </x-slot>
                        </x-jet-dropdown>
                    @endif

                    <!-- Authentication Links -->
                    @auth
                        <x-jet-dropdown id="navbarDropdown">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <div class="c-avatar">
                                        <img class="c-avatar-img" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </div>
                                @else
                                    {{ Auth::user()->name }}
                                @endif

                                <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </x-slot>

                            <x-slot name="content">
                                <div class="dropdown-header bg-light py-2">
                                    <strong>{{ __('Manage Account') }}</strong>
                                </div>

                                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-jet-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-jet-dropdown-link>
                                @endif

                                <hr class="dropdown-divider">

                                <!-- Authentication -->
                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                                     onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </x-jet-dropdown-link>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    @endauth
                </ul>

                <div class="c-subheader px-3 py-3">
                    <div class="container">
                        {{ $header ?? '' }}
                    </div>
                </div>
            </header>

          <div class="c-body">
            <main class="c-main">

              <div class="container">
                  <div class="row fade-in">
                      <div class="col">
                          {{ $slot }}
                      </div>

                      @if (isset($aside))
                          <div class="col-lg-3">
                              {{ $aside ?? '' }}
                          </div>
                      @endif
                  </div>
              </div>

            </main>

            <footer class="c-footer">
              <div>
                  <a href="https://jetstream.laravel.com/1.x/introduction.html">Jetstream</a> © 2020 Laravel.
              </div>
              <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
            </footer>
          </div>
        </div>

        @stack('modals')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script>
            const SwalModal = (icon, title, html) => {
                Swal.fire({
                    icon,
                    title,
                    html
                })
            }

            const SwalConfirm = (icon, title, html, confirmButtonText, method, params, callback) => {
                Swal.fire({
                    icon,
                    title,
                    html,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText,
                    reverseButtons: true,
                }).then(result => {
                    if (result.value) {
                        return livewire.emit(method, params)
                    }

                    if (callback) {
                        return livewire.emit(callback)
                    }
                })
            }

            const SwalAlert = (icon, title, timeout = 7000) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: timeout,
                    onOpen: toast => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon,
                    title
                })
            }

            document.addEventListener('DOMContentLoaded', () => {
                this.livewire.on('swal:modal', data => {
                    SwalModal(data.type, data.title, data.text)
                })

                this.livewire.on('swal:confirm', data => {
                    SwalConfirm(data.icon, data.title, data.text, data.confirmText, data.method, data.params, data.callback)
                })

                this.livewire.on('swal:alert', data => {
                    SwalAlert(data.type, data.title, data.timeout)
                })
            })
        </script>

        @livewireScripts
        @stack('scripts')
    </body>
</html>
