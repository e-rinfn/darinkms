<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Scroll</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            transition: background-color 0.3s ease; /* Animasi perubahan warna */
        }

        section {
            height: 100vh; /* Setiap section memiliki tinggi layar penuh */
            padding-top: 80px; /* Berikan jarak untuk menghindari navbar */
        }

        .navbar {
            background-color: #EC1928 !important; /* Merah untuk navbar */
            border-radius: 15px; /* Tepian melengkung */
            margin: 10px 15px; /* Beri jarak di sekeliling navbar */
            padding: 10px 20px; /* Padding dalam navbar */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan */
            transition: all 0.3s ease; /* Animasi perubahan */
        }

        .nav-link {
            padding: 10px 15px;
            border-radius: 5px; /* Menambahkan tepian melengkung */
            background-color: #EC1928; /* Merah */
            color: white; /* Warna teks putih */
            transition: background-color 0.3s ease; /* Animasi transisi */
        }

        .nav-link:hover {
            background-color: #d11c2d; /* Warna merah lebih gelap saat hover */
        }

        .nav-link.active-btn {
            background-color: #d11c2d; /* Merah gelap untuk tombol aktif */
        }

        #section1 {
            background-color: #EC1928; /* Merah */
        }

        #section2 {
            background-color: #341EBB; /* Biru */
        }

        #section3 {
            background-color: #28A745; /* Hijau */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#section1" id="link-section1">Section 1</a></li>
                    <li class="nav-item"><a class="nav-link" href="#section2" id="link-section2">Section 2</a></li>
                    <li class="nav-item"><a class="nav-link" href="#section3" id="link-section3">Section 3</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sections -->
    <section id="section1">
        <div class="container">
            <h1 class="text-white">Section 1</h1>
        </div>
    </section>
    <section id="section2">
        <div class="container">
            <h1 class="text-white">Section 2</h1>
        </div>
    </section>
    <section id="section3">
        <div class="container">
            <h1 class="text-white">Section 3</h1>
        </div>
    </section>

    <!-- Script untuk mengubah background tombol navigasi -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll("section");
            const navLinks = document.querySelectorAll(".nav-link");
            
            const updateActiveButtonBackground = () => {
                let currentSection = null;

                // Loop untuk menentukan section mana yang saat ini terlihat
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - window.innerHeight / 2; // Mempertimbangkan posisi di tengah layar
                    const sectionBottom = sectionTop + section.offsetHeight;

                    if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                        currentSection = section;
                    }
                });

                // Ubah warna background tombol navigasi berdasarkan section aktif
                navLinks.forEach(link => {
                    link.classList.remove("active-btn"); // Hapus kelas aktif
                    link.style.backgroundColor = "#EC1928"; // Reset ke merah
                });

                if (currentSection) {
                    const activeLink = document.querySelector(`[href="#${currentSection.id}"]`);
                    if (activeLink) {
                        activeLink.classList.add("active-btn"); // Tambahkan kelas aktif
                    }
                }
            };

            // Panggil fungsi saat halaman di-scroll
            window.addEventListener("scroll", updateActiveButtonBackground);

            // Panggil sekali untuk memastikan tampilan awal sesuai
            updateActiveButtonBackground();
        });
    </script>

    <!-- Link Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
