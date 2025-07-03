<!-- <div class="fixed top-4 right-4 z-50 space-y-3 w-80">
    {{-- Success Message --}}
    @if(session('success'))
    <div class="flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm animate-fade-in-up">
        <div class="text-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
        <button class="ml-auto text-green-500 hover:text-green-700" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
    <div class="flex items-center p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm animate-fade-in-up">
        <div class="text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
        <button class="ml-auto text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif
</div>

<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style> -->



<!-- Include SweetAlert CSS and JS
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        swal({
            icon: "success",
            title: "Success!",
            text: "{{ session('success') }}",
            confirmButtonText: 'OK',
        });
        // Swal.fire({
        //     icon: 'success',
        //     title: 'Success!',
        //     text: "{{ session('success') }}",
        //     confirmButtonText: 'OK',
        //     customClass: {
        //         popup: 'swal2-popup',
        //         confirmButton: 'swal2-confirm'
        //     }
        // });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        swal({
            icon: "error",
            title: "Error!",
            text: "{{ session('error') }}",
            confirmButtonText: 'OK',
        });
    });
</script>
@endif

