<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ env('APP_NAME') ?? $title }}
    </title>

    <link href="{{ asset('admin/dist/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/dist/assets/img/favicon.png') }}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{--  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  --}}

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>

    {{--  Map  --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.css"
        crossorigin="" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/MarkerCluster.Default.css"
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.1/leaflet.markercluster.js"
        crossorigin=""></script>


    {{-- <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "e51edfd8-1c78-41fa-b7eb-347b04c2b64a",
            });
        });
    </script> --}}

    <style>
        .select2-container--default .select2-selection--single {
            background-color: transparent !important;
            border: 0px !important;
            border-radius: 0px !important;
            width: 100%;
        }



        .select2-container .select2-selection--single .select2-selection__rendered {
            /* display: block !important; */
            position: relative;
            width: 100% !important;
            padding: 0.875rem 1.125rem !important;
            font-size: 0.875rem !important;
            font-weight: 400 !important;
            line-height: 2 !important;
            color: #69707a !important;
            background-color: #fff !important;
            background-clip: padding-box !important;
            border: 1px solid #c5ccd6 !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            border-radius: 0.35rem !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;

            /* display: block;
        width: 100%;
        padding: 0.875rem 3.375rem 0.875rem 1.125rem;
        -moz-padding-start: calc(1.125rem - 3px);
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1;
        color: #69707a;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23363d47' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1.125rem center;
        background-size: 16px 12px;
        border: 1px solid #c5ccd6;
        border-radius: 0.35rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        -webkit-appearance: none;
            -moz-appearance: none;
                appearance: none; */
        }

        .select2-container--default .select2-selection--multiple {
            /* display: block !important; */
            position: relative;
            width: 100% !important;
            padding: 0.875rem 1.125rem !important;
            font-size: 0.875rem !important;
            font-weight: 400 !important;
            line-height: 2 !important;
            color: #69707a !important;
            background-color: #fff !important;
            background-clip: padding-box !important;
            border: 1px solid #c5ccd6 !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            border-radius: 0.35rem !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
        }
    </style>

</head>


