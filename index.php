<?php
include 'config/includes.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Portal escrituras</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap"
            rel="stylesheet"
    >

    <!-- Vendor CSS Files -->
    <link href="<?= $base_url; ?>assets/vendor/bootstrap52/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $base_url; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $base_url; ?>assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= $base_url; ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= $base_url; ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="<?= $base_url; ?>assets/vendor/jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet">
    <!-- Variables CSS Files. Uncomment your preferred color scheme -->
    <link href="<?= $base_url; ?>assets/css/variables.css" rel="stylesheet">
    <!-- <link href="assets/css/variables-blue.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-green.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-orange.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-purple.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-red.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-pink.css" rel="stylesheet"> -->

    <link href="<?= $base_url; ?>assets/css/main.css" rel="stylesheet">
    <link href="<?= $base_url; ?>assets/css/styles.css?c=<?= uniqid() ?>" rel="stylesheet">
    <link href="<?= $base_url; ?>assets/vendor/fontawesome/css/all.css" rel="stylesheet">
    <script src="<?= $base_url; ?>assets/vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="<?= $base_url; ?>assets/vendor/jquery-confirm/js/jquery-confirm.min.js"></script>
    <script src="<?= $base_url; ?>assets/vendor/jquery/jquery.validate.min.js"></script>
    <script src="<?= $base_url; ?>assets/vendor/jquery/jquery.mask.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSnblPMOwEdteX5UPYXf7XUtJYcbypx6w&v=weekly&language=pt&region=BR&libraries=places"></script>
    <script>
        $(document).ready(function () {
            $.jMaskGlobals.watchDataMask = true;

            $(".logout").click(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "./pages/actions/actionLogout.php",
                    method: "POST",
                    data: {acao: "logout"},
                    success: function (data) {
                        window.location.href = '<?= $base_url; ?>';
                    }
                })
            });
        });
    </script>
</head>
<body>
<!-- ======= Header ======= -->
<?php include "header.php" ?>
<!-- ======= Header ======= -->


<!-- ======= main ======= -->
<main id="main">
    <?php
    ////////////////
    $rotas = explode('/', $_GET['url'] ?: 'main');
    $rota = $rotas[0];

    if ($rota === 'main') {
        include "main.php";
    } elseif (file_exists("pages/{$rota}.php")) {
        include "pages/{$rota}.php";
    } else {
        include "pages/error404.php";
    }


    ?>
</main>
<!-- ======= main ======= -->

<!-- ======= Footer ======= -->
<?php include "footer.php"; ?>
<!-- ======= Footer ======= -->


<a href="#" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>

<!-- Vendor JS Files -->

<script src="<?= $base_url; ?>assets/vendor/bootstrap52/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_url; ?>assets/vendor/aos/aos.js"></script>
<script src="<?= $base_url; ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="<?= $base_url; ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="<?= $base_url; ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="<?= $base_url; ?>assets/vendor/php-email-form/validate.js"></script>
<script src="<?= $base_url; ?>assets/vendor/fontawesome/js/all.js"></script>

<!-- Template Main JS File -->
<script src="<?= $base_url; ?>assets/js/main.js"></script>
</body>
</html>