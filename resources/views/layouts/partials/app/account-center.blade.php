<li class="nav-item dropdown">
    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="d-flex align-items-center">
            <div class="user-profile-img">
                <img src="{{ auth()->user()->image ? asset('storage/'. auth()->user()->image) : Gravatar::get(auth()->user()->email) }}" class="rounded-circle"
                    width="35" height="35" alt="{{ auth()->user()->fullname }}" />
            </div>
        </div>
    </a>
    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
        <div class="profile-dropdown position-relative" data-simplebar>
            <div class="py-3 px-7 pb-0">
                <h5 class="mb-0 fs-5 fw-semibold">Profil Saya</h5>
            </div>
            <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                <img src="{{ auth()->user()->image ? asset('storage/'. auth()->user()->image) : Gravatar::get(auth()->user()->email) }}" class="rounded-circle"
                    width="80" height="80" alt="{{ auth()->user()->fullname }}" />
                <div class="ms-3">
                    <h5 class="mb-1 fs-3">{{ auth()->user()->fullname }}</h5>
                    <span class="mb-1 d-block text-dark">{{ Auth::user()->getRoles() }}</span>
                    <p class="mb-0 d-flex text-dark align-items-center gap-2">
                        <i class="ti ti-mail fs-4"></i> {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
            <div class="message-body">
                <a href="./page-user-profile.html" class="py-8 px-7 mt-8 d-flex align-items-center">
                    <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                        <img src="{{ asset('dist/images/svgs/icon-account.svg') }}" alt="" width="24" height="24">
                    </span>
                    <div class="w-75 d-inline-block v-middle ps-3">
                        <h6 class="mb-1 bg-hover-primary fw-semibold"> Profilku
                        </h6>
                        <span class="d-block text-dark">Kustomisasi Akun Anda</span>
                    </div>
                </a>
                <a href="./app-email.html" class="py-8 px-7 d-flex align-items-center">
                    <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                        <img src="{{ asset('dist/images/svgs/icon-inbox.svg') }}" alt="" width="24" height="24">
                    </span>
                    <div class="w-75 d-inline-block v-middle ps-3">
                        <h6 class="mb-1 bg-hover-primary fw-semibold">Notifikasi</h6>
                        <span class="d-block text-dark">Lihat Semua Notifikasi</span>
                    </div>
                </a>
                <a href="./app-notes.html" class="py-8 px-7 d-flex align-items-center">
                    <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                        <img src="{{ asset('dist/images/svgs/icon-key.svg') }}" alt="" width="24" height="24">
                    </span>
                    <div class="w-75 d-inline-block v-middle ps-3">
                        <h6 class="mb-1 bg-hover-primary fw-semibold"> Kata Sandi
                        </h6>
                        <span class="d-block text-dark">Ganti Kata Sandi</span>
                    </div>
                </a>
            </div>
            <div class="d-grid py-4 px-7 pt-8">
                <form method="POST" id="logout-form" class="form-ajax" action="{{ route('logout') }}"
                    data-success-message="Sistem akan mengarahkan anda ke halaman autentikasi dalam waktu 5 detik."
                    data-redirect-on-success="{{ route('login') }}">
                    @csrf
                </form>

                <a href="javascript:void(0)"
                    onclick="runModalConfirmWithSubmit('Pastikan semua data sudah disimpan sebelum mengeluarkan sesi kali ini. Semua data yang tidak tersimpan akan terhapus otomatis.', '#logout-form')"
                    class="btn btn-outline-primary">Keluar Sesi</a>
            </div>
        </div>
    </div>
</li>
