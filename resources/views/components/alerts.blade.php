
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: "success",
                title: "Good job!",
                text: "{{ session('success') }}",
                confirmButtonText: 'OK',
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "{{ session('error') }}",
                confirmButtonText: 'OK',
            });
        });
    </script>
    @endif