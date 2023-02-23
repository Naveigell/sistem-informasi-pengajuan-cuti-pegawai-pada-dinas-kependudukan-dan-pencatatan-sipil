
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('page-title', 'Sistem Informasi')</title>

    @include('layouts.employee.style')
    @stack('stack-style')
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        @include('layouts.employee.header')
        @include('layouts.employee.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>@yield('content-title', '')</h1>
                </div>
                <div class="section-body">
                    @yield('content-body')
                </div>
            </section>
        </div>
    </div>
    @yield('content-modal', '')
</div>

@include('layouts.employee.script')
@stack('stack-script')
</body>
</html>
