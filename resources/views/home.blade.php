@extends('layouts.app')

@section('content')
    <div style="background-image: url({{ asset('storage/bg-01.jpg') }}); background-repeat: round"
        class="position-absolute w-100 h-100 " id="bg1"></div>
        <div style="background-color:brown;display: none"
        class="position-absolute w-100 h-100 " id="bg2"></div>
    <div class="p-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center" id="normal" style="display: block">
                            <h2 class="text-secondary">
                                Heart Attack Monitoring
                            </h2>
                        </div>
                        <div class="text-center" id="warning"  style="display: none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="red"
                                class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                <path
                                    d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z" />
                                <path
                                    d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z" />
                            </svg>

                            <p class="login100-form-title p-b-53" style="font-size: 18px;">
                                PERINGATAN! <br> {{ auth()->user()->name }} TERKENA SERANGAN JANTUNG !!!
                            </p>
                        </div>

                        <div class="card m-b-2 mx-auto col-md-6 mt-4 text-white">
                            <div class="card-body" id="bpmContainer">
                                <h4 style="font-size: 15px;" id="bpm">

                                </h4>
                            </div>
                        </div>
                        <div class="card m-b-2 mx-auto bg-danger mt-4 text-white" id="mapContainer" style="display: none">
                            <div class="card-body">
                                <h4 style="font-size: 15px;">
                                    Lokasi
                                </h4>
                                <div class="container" id="mapid"></div>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script>
        var bg1 = document.getElementById("bg1");
        var bg2 = document.getElementById("bg2");
        var x = document.getElementById("demo");
        var bpm = document.getElementById("bpm");
        var warning = document.getElementById("warning");
        var normal = document.getElementById("normal");
        var bpmContainer = document.getElementById("bpmContainer");
        var mapContainer = document.getElementById('mapContainer');
        var id = {!! json_encode(auth()->user()->id) !!}
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);

        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        function sendData(lat, lon) {
            $.post("api/loc", {
                lat: lat,
                lon: lon,
                user_id: id
            });
        }

        function getData() {
            $.get("api/getData/" + id, function(data, status) {
                console.log(data)
                bpm.innerHTML = data.bpm +" BPM";
                if (data.bpm > 150 || data.bpm < 60) {
                    warning.style.display = 'block';
                    normal.style.display = 'none';
                    bpmContainer.style.backgroundColor = 'red'
                    mapContainer.style.display = 'block'
                    bg1.style.display = 'none'
                    bg2.style.display = 'block'
                } else {
                    warning.style.display = 'none';
                    normal.style.display = 'block';
                    bpmContainer.style.backgroundColor = '#1CC2E1'
                    mapContainer.style.display = 'none'
                    bg1.style.display = 'block'
                    bg2.style.display = 'none'
                }
            });
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            setInterval(function() {
                sendData(lat, lon)
            }, 5000);
            setInterval(function() {
                getData()
            }, 2000);
            var mapCenter = [lat, lon];

            var map = L.map('mapid').setView(mapCenter, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker = L.marker(mapCenter).addTo(map);

            marker.setLatLng([lat, lon])
                .bindPopup({!! json_encode(auth()->user()->name) !!})
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
