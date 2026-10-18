<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    
<!-- Topbar Search -->
<div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input
            type="text"
            id="academicSearch"
            class="form-control bg-light border-0 small"
            placeholder="Cari data akademik..."
            aria-label="Cari data akademik"
            autocomplete="off">

        <div class="input-group-append">
            <button class="btn btn-primary" type="button" id="academicSearchButton">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>

    <div id="academicSearchResults"
         class="list-group shadow"
         style="display:none; position:absolute; z-index:1050; min-width:280px; max-width:100%;">
    </div>
</div>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

       
<!-- Search Dropdown untuk layar kecil -->
<li class="nav-item dropdown no-arrow d-sm-none">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="searchDropdown"
       role="button"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right p-3 shadow"
         aria-labelledby="searchDropdown"
         style="width:280px;">
        <div class="input-group">
            <input
                type="text"
                id="academicSearchMobile"
                class="form-control bg-light border-0 small"
                placeholder="Cari data akademik..."
                autocomplete="off">

            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="academicSearchMobileButton">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>

        <div id="academicSearchMobileResults" class="list-group mt-2"></div>
    </div>
</li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small font-weight-bold">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </span>
                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=4e73df&color=ffffff">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile ({{ Auth::user()->email ?? '' }})
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger font-weight-bold" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    Keluar / Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pages = [
        { name: 'Data Siswa', keywords: ['siswa', 'murid', 'nis'], url: @json(route('siswa.index')) },
        { name: 'Data Guru', keywords: ['guru', 'pengajar', 'nip'], url: @json(route('guru.index')) },
        { name: 'Data Kelas', keywords: ['kelas', 'rombel'], url: @json(route('kelas.index')) },
        { name: 'Data Mata Pelajaran', keywords: ['mata pelajaran', 'mapel', 'pelajaran'], url: @json(route('mapel.index')) },
        { name: 'Nilai Siswa', keywords: ['nilai', 'rapor', 'ujian'], url: @json(route('nilai.index')) },
        { name: 'Dashboard Akademik', keywords: ['dashboard', 'beranda', 'utama'], url: @json(route('dashboard')) }
    ];

    function setupSearch(inputId, buttonId, resultsId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        const results = document.getElementById(resultsId);

        if (!input || !button || !results) return;

        function search() {
            const query = input.value.trim().toLowerCase();
            results.innerHTML = '';
            results.style.display = 'none';

            if (!query) return;

            const matches = pages.filter(function (page) {
                return page.name.toLowerCase().includes(query) ||
                    page.keywords.some(function (keyword) {
                        return keyword.includes(query) || query.includes(keyword);
                    });
            });

            if (matches.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'list-group-item small text-muted';
                empty.textContent = 'Halaman tidak ditemukan.';
                results.appendChild(empty);
            } else {
                matches.forEach(function (page) {
                    const link = document.createElement('a');
                    link.className = 'list-group-item list-group-item-action small';
                    link.href = page.url;
                    link.textContent = page.name;
                    results.appendChild(link);
                });
            }

            results.style.display = 'block';
        }

        button.addEventListener('click', search);

        input.addEventListener('input', search);

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                search();

                const firstResult = results.querySelector('a');
                if (firstResult) window.location.href = firstResult.href;
            }

            if (event.key === 'Escape') {
                results.style.display = 'none';
            }
        });

        document.addEventListener('click', function (event) {
            if (!input.contains(event.target) &&
                !button.contains(event.target) &&
                !results.contains(event.target)) {
                results.style.display = 'none';
            }
        });
    }

    setupSearch('academicSearch', 'academicSearchButton', 'academicSearchResults');
    setupSearch('academicSearchMobile', 'academicSearchMobileButton', 'academicSearchMobileResults');
});
</script>

<!-- End of Topbar -->