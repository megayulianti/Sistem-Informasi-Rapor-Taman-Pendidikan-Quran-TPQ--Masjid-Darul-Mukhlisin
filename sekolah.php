<!DOCTYPE html>
<!--
Template name: Nova
Template author: FreeBootstrap.net
Author website: https://freebootstrap.net/
License: https://freebootstrap.net/license
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Sistem Informasi Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin Berbasis Web</title>
     
    <!-- ======= Google Font =======-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet">
    <!-- End Google Font-->
    
    <!-- ======= Styles =======-->
    <link href="assets/vendors/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendors/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/vendors/glightbox/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendors/aos/aos.css" rel="stylesheet">
    <!-- End Styles-->
    
    <!-- ======= Theme Style =======-->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- End Theme Style-->
    
    <!-- ======= Apply theme =======-->
    <script>
      // Apply the theme as early as possible to avoid flicker
      (function() {
      const storedTheme = localStorage.getItem('theme') || 'light';
      document.documentElement.setAttribute('data-bs-theme', storedTheme);
      })();
    </script>
  </head>
  <body>
    
    
    <!-- ======= Site Wrap =======-->
    <div class="site-wrap">
      
      
      <!-- ======= Header =======-->
      <header class="fbs__net-navbar navbar navbar-expand-lg dark" aria-label="freebootstrap.net navbar">
        <div class="container d-flex align-items-center justify-content-between">
          
          
          <!-- Start Logo-->
          <a class="navbar-brand w-auto" href="index.php">
            TPQ
          </a>

          <!-- End Logo-->
          
          <!-- Start offcanvas-->
          <div class="offcanvas offcanvas-start w-75" id="fbs__net-navbars" tabindex="-1" aria-labelledby="fbs__net-navbarsLabel">
            
            
            <div class="offcanvas-header">
              <div class="offcanvas-header-logo">
                <!-- If you use a text logo, uncomment this if it is commented-->
                
                <!-- h5#fbs__net-navbarsLabel.offcanvas-title Vertex-->
                
                <!-- If you plan to use an image logo, uncomment this if it is commented-->
                <a class="logo-link" id="fbs__net-navbarsLabel" href="index.php">
                  
                  
                  <!-- logo dark--><img class="logo dark img-fluid" src="assets/images/logo-dark.svg" alt="FreeBootstrap.net image placeholder"> 
                  
                  <!-- logo light--><img class="logo light img-fluid" src="assets/images/logo-light.svg" alt="FreeBootstrap.net image placeholder"></a>
                
              </div>
              <button class="btn-close btn-close-black" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body align-items-lg-center">
              
              
              <ul class="navbar-nav nav me-auto ps-lg-5 mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link scroll-link active" aria-current="page" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#about">About</a></li>
                </li>
          
              </ul>
              
            </div>
          </div>
          <!-- End offcanvas-->
          
          <div class="ms-auto w-auto">
            
            
            <div class="header-social d-flex align-items-center gap-1"><a class="btn btn-primary py-2" href="log/login.php">LOGIN</a>
              
              <button class="fbs__net-navbar-toggler justify-content-center align-items-center ms-auto" data-bs-toggle="offcanvas" data-bs-target="#fbs__net-navbars" aria-controls="fbs__net-navbars" aria-label="Toggle navigation" aria-expanded="false">
                <svg class="fbs__net-icon-menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="21" x2="3" y1="6" y2="6"></line>
                  <line x1="15" x2="3" y1="12" y2="12"></line>
                  <line x1="17" x2="3" y1="18" y2="18"></line>
                </svg>
                <svg class="fbs__net-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
              
            </div>
            
          </div>
        </div>
      </header>
      <!-- End Header-->
      
      <!-- ======= Main =======-->
      <main>
        
        
        <!-- ======= Hero =======-->
        <section class="hero__v6 section" id="home">
          <div class="container">
            <div class="row">
              <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="row">
                  <div class="col-lg-11">
                    <h1 class="hero-title mb-3" data-aos="fade-up" data-aos-delay="100">Sistem Informasi Taman Pendidikan Quran(TPQ) Masjid Darul Mukhlisin</h1>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="hero-img"><img class="img-card img-fluid"  data-aos="fade-down" data-aos-delay="600"><img class="img-main img-fluid rounded-4" src="assets/images/gambar1.png" alt="Hero Image" data-aos="fade-in" data-aos-delay="500"></div>
              </div>
            </div>
          </div>
          <!-- End Hero-->
        </section>
        <!-- End Hero-->
        
        <!-- ======= About =======-->
        <section class="about__v4 section" id="about">
          <div class="container">
            <div class="row">
              <div class="col-md-6 order-md-2">
                <div class="row justify-content-end">
                  <div class="col-md-11 mb-4 mb-md-0"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">About us</span>
                    <h2 class="mb-4" data-aos="fade-up" data-aos-delay="100">Sistem Informasi Taman Pendidikan Quran(TPQ) Masjid Darul Mukhlisin </h2>
                    <div data-aos="fade-up" data-aos-delay="200">
                      <p>Sistem Informasi Taman Pendidikan Quran (TPQ) Masjid Darul Mukhlisin berbasis web dirancang untuk mempermudah pengelolaan data santri, jadwal kegiatan, nilai, dan administrasi TPQ. Sistem ini membantu pengurus dalam mencatat dan mengakses informasi dengan lebih cepat, efisien, serta mendukung transparansi dan akuntabilitas dalam manajemen TPQ.</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6"> 
                <div class="img-wrap position-relative"><img class="img-fluid rounded-4" src="assets/images/gambar2.png" alt="FreeBootstrap.net image placeholder" data-aos="fade-up" data-aos-delay="0">
                 
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End About-->
        
        <!-- ======= Footer =======-->
        <footer class="footer pt-5 pb-5">
          <div class="container">
            <div class="row mb-5 pb-4">
            </div>
            <div class="row justify-content-between mb-5 g-xl-5">
              <div class="col-md-4 mb-5 mb-lg-0">
                <h3 class="mb-3">Masjid Darul Mukhlisin</h3>
                <p class="mb-4">Sistem Informasi Taman Pendidikan Quran
(TPQ) Masjid Darul Mukhlisin Berbasis Web.</p>
              </div>
              <div class="col-md-7">
                <div class="row g-2">
                  <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <h3 class="mb-3">TPQ</h3>
                    <ul class="list-unstyled">
                      <li><a href="index.php">Beranda</a></li>
                      <li><a href="#about">About</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row credits pt-3">
              <div class="col-xl-8 text-center text-xl-start mb-3 mb-xl-0">
                <!--
                Note:
                =>>> Please keep all the footer links intact. <<<=
                =>>> You can only remove the links if you buy the pro version. <<<=
                =>>> Buy the pro version, which includes a functional PHP/AJAX contact form and many additional features.: https://freebootstrap.net/template/vertex-pro-bootstrap-website-template-for-portfolio/ <<<=
                --> 
                &copy;
                <script>document.write(new Date().getFullYear());</script> 
                 All rights reserved. Designed with <i class=""></i> by <a href="https://freebootstrap.net">Masjid Darul Mukhlisin</a>
              </div>
            </div>
          </div>
        </footer>
        <!-- End Footer-->
        
      </main>
    </div>
    
    <!-- ======= Back to Top =======-->
    <button id="back-to-top"><i class="bi bi-arrow-up-short"></i></button>
    <!-- End Back to top-->
    
    <!-- ======= Javascripts =======-->
    <script src="assets/vendors/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/gsap/gsap.min.js"></script>
    <script src="assets/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendors/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/vendors/glightbox/glightbox.min.js"></script>
    <script src="assets/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendors/aos/aos.js"></script>
    <script src="assets/vendors/purecounter/purecounter.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/send_email.js"></script>
    <!-- End JavaScripts-->
  </body>
</html>