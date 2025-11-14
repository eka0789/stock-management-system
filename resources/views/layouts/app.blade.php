<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} — @yield('title')</title>

    <!-- Bootstrap 5 -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <!-- AdminLTE CSS -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body { font-family: 'Roboto', sans-serif; }
        .brand-link { font-size: 1.2rem; font-weight: 600; letter-spacing: 0.5px; }
        .content-wrapper { min-height: 90vh; background-color: #f4f6f9; }
        .alert { animation: slideDown .4s ease; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('partials.navbar')
    @include('partials.sidebar')

    <div class="content-wrapper p-4">

        {{-- ===== GLOBAL ALERT BOOTSTRAP (PUTIH) ===== --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3">
                <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3">
                <i class="fas fa-exclamation-circle me-2"></i> Terjadi kesalahan:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ========== PAGE CONTENT ========== --}}
        @yield('content')

    </div>

    @include('partials.footer')

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

<script>
/* ===========================================
   GLOBAL SWEETALERT DELETE CONFIRMATION
=========================================== */
$(document).on('click', '.btn-delete', function(e){
    e.preventDefault(); 

    let form = $(this).closest('form'); 

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

/* ===========================================
   AUTO-HIDE BOOTSTRAP ALERT
=========================================== */
setTimeout(() => {
    $('.alert').fadeOut('slow');
}, 4000);

/* ===========================================
   SWEETALERT FLASH MESSAGE GLOBAL
=========================================== */
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}',
    timer: 1800,
    showConfirmButton: false
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session("error") }}'
});
@endif

</script>

</body>
</html>
