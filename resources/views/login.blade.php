<!DOCTYPE html>
<html>

<head>
    <title>Admin Verification</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body style="background-image: url('{{ asset('images/quiz-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            @if (isset($gagal))
                Swal.fire({
                    icon: "error",
                    title: "Password salah!",
                    confirmButtonText: "Coba lagi"
                }).then(() => askPassword());
            @else
                askPassword();
            @endif

        });

        function askPassword() {
            Swal.fire({
                title: "Masukkan Password Admin",
                input: "password",
                inputPlaceholder: "Password",
                allowOutsideClick: false,
                confirmButtonText: "Verifikasi"
            }).then(result => {
                if (result.value !== null) {
                    let form = document.createElement('form');
                    form.method = 'GET'; // GET supaya tidak reload POST ulang
                    form.action = "/admin";

                    let pass = document.createElement('input');
                    pass.type = 'hidden';
                    pass.name = 'pass';
                    pass.value = result.value;

                    form.appendChild(pass);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

</body>

</html>
