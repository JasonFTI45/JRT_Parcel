<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>JRT Parcel</title>

    <!-- Fonts -->
    <link href="{{ asset('css/styles_2.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <!-- Styles -->
</head>

<body>
    <div class="container-lp">

        <!-- Kondisi Button ketika sudah melakukan Login dan Tidak Login -->

        <!-- NAVBAR START -->

        @if (Route::has('login'))
        <div class="container-navbar">
            <div>
                @auth
                <a href="{{ url('/dashboard') }}" class="btn-1 bolder">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="btn-1 bolder">Login</a>
                @endauth
            </div>
            <h2 class="head-lp">JRT Courier Management System</h2>
            <img src="{{ asset('assets/logo.png') }}" alt="" height="60" width="114.5">
        </div>
        @endif

        <!-- NAVBAR END -->


        <!-- CONTENT START -->

        <div class="container-content">
            <div class="content-lp">
                <div class="img-lp">
                    <img src="{{ asset('assets/delivery.jpg') }}" alt="" height="450" width="700" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                </div>
                <div class="desc-lp">
                    <h1>Welcome to Courier Management System</h1>
                    <p class="py-4">Our platform streamlines your delivery operations, making it easy to manage, track, and optimize your courier services. From real-time tracking to automated dispatching, our system ensures timely and accurate deliveries, enhancing your operational efficiency and customer satisfaction.</p>
                    <div class="marquee">

                        <!-- MARQUEE START -->

                        <div class="marquee-content">
                            <?php
                            $logos = array(
                                'assets/lion.png',
                                'assets/sriwijaya.png',
                                'assets/garuda.png',
                                'assets/citilink.png',
                                'assets/airasia.png',
                                'assets/pelita.png',
                            );

                            foreach ($logos as $logo) {
                                echo "<div class='marquee-item'>";
                                echo "<img src='" . asset($logo) . "' alt='Airline Logo'>";
                                echo "</div>";
                            }
                            ?>
                        </div>

                        <!-- MARQUEE END -->

                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT END -->

    </div>
</body>

</html>