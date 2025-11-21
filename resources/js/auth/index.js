$(function () {
  const csrfToken = $('meta[name="csrf-token"]').attr('content');

  // Global header Authorization untuk semua AJAX setelah login
  function setAuthHeader(token) {
    if (!token) return;
    $.ajaxSetup({
      headers: {
        'Authorization': 'Bearer ' + token
      }
    });
  }

  // Ambil token dari localStorage saat page load (kalau ada)
  const saved = localStorage.getItem('auth_token');
  if (saved) setAuthHeader(saved);

  // ----- SIGNIN (WEB) -> session + token -----
  $('#signinButton').on('click', function (e) {
    e.preventDefault();

    const payload = {
      email: $('#email').val(),
      password: $('#password').val(),
      remember: $('#remember_me').is(':checked') ? 1 : 0,
      _token: csrfToken,
    };

    $.ajax({
      url: '/signin',
      method: 'POST',
      data: payload,
      xhrFields: { withCredentials: true }, // session cookie untuk web routes
      success: function (res) {
        // simpan token untuk dipakai ke API
        localStorage.setItem('auth_token', res.token);
        setAuthHeader(res.token);

        // redirect ke dashboard (punya session)
        window.location.href = res.redirect || '/dashboard';
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.message || 'Signin failed';
        alert(msg);
      }
    });
  });


   $('#signupForm').on('submit', function(e) {
    e.preventDefault(); // cegah form submit normal

    $.ajax({
        url: "/api/signup", // route API register
        method: "POST",
        data: {
            _token: $('input[name="_token"]').val(),
            name: $('#name').val(),
            user_name: $('#user_name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
        },
        success: function(response) {
            // simpan token di localStorage
            localStorage.setItem("auth_token", response.token);

            // tampilkan toast sukses
            toastr.success("Registrasi berhasil! Silahkan login...");

            // redirect setelah toast hilang (3 detik default)
            setTimeout(function() {
                window.location.href = "/signin";
            }, 3000); // 3000ms = 3 detik
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                // tampilkan error di toast
                let errors = xhr.responseJSON.errors;
                Object.values(errors).forEach(function(err) {
                    toastr.error(err[0]);
                });
            } else {
                toastr.error("Terjadi kesalahan!");
            }
        }
    });
});


  async function getApiUser() {
    try {
      const res = await fetch('/api/user', {
        method: 'GET',
        headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') }
      });
      if (!res.ok) throw new Error('Unauthorized');
      const data = await res.json();
      console.log('API /user:', data);
      return data;
    } catch (e) {
      console.log('Tidak ada user aktif via API');
      return null;
    }
  }

  // Contoh panggil saat page render
  (async () => {
    await getApiUser();
  })();
});
