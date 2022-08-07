@extends('layouts.app')

@section('content')
    <div style="background-image: url({{ asset('storage/bg-01.jpg') }}); background-repeat: no-repeat" class="position-absolute w-100 h-100 "></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="text-center">

                            <p class="login100-form-title p-b-53" style="font-size: 18px;">
                            <h4>Hasil Monitoring</h4>
                            User Budi
                            </p>
                        </div>

                        <div class="card m-b-2 mx-auto col-md-6 bg-info mt-4 text-white">
                            <div class="card-body">
                                <h4 style="font-size: 15px;">
                                    Denyut Nadi {{ $data->bpm }}
                                </h4>
                            </div>

                        </div>
                        <div class="text-center mt-2">
                            <button class="btn btn-outline-info w-50 shadow">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <style>
        #mapid {
            min-height: 500px;
        }
    </style>
@endsection

@push('scripts')
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script>
        var x = document.getElementById("demo");

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        function showPosition(position) {
            lat = position.coords.latitude;
            lon = position.coords.longitude;
            var mapCenter = [lat, lon];

            var map = L.map('mapid').setView(mapCenter, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker = L.marker(mapCenter).addTo(map);

            marker.setLatLng([lat, lon])
                .bindPopup("User A")
                .openPopup();

            var updateMarkerByInputs = function() {
                return updateMarker($('#latitude').val(), $('#longitude').val());
            }
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }
    </script>
    <!-- Leaflet JavaScript -->
    <!-- Make sure you put this AFTER Leaflet's CSS -->
@endpush
