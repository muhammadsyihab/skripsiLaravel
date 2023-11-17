

@extends('layouts.vue.template')

@section('content')
    {{-- <div id="layoutSidenav_content">
        <style>
            .scrollbarCustom::-webkit-scrollbar-track
            {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                border-radius: 10px;
                background-color: #F5F5F5;
            }
        
            .scrollbarCustom::-webkit-scrollbar
            {
                width: 7px;
                background-color: #F5F5F5;
            }
        
            .scrollbarCustom::-webkit-scrollbar-thumb
            {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                background-color: #555;
            }

            .headCustom {
                padding: 0rem;
                font-size: 0.75rem;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .accordionCustom {
                background-color: #eee;
                color: #444;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
                transition: 0.4s;
            }

            .activeCustom, .accordionCustom:hover {
                background-color: #ccc; 
            }

            .panelCustom {
                padding: 0 18px;
                display: none;
                background-color: white;
                overflow: hidden;
            }

            .badgeCustomPrimary {
                background-color: #0DCAF0;
                color: white;
                padding: 2px 4px;
                text-align: center;
                border-radius: 7px;
            }

            .badgeCustomSecondary {
                background-color: #6900C7;
                color: white;
                padding: 2px 4px;
                text-align: center;
                border-radius: 7px;
            }

            .badgeCustomWarning {
                background-color: #FFC107;
                color: white;
                padding: 2px 4px;
                text-align: center;
                border-radius: 7px;
            }

            
        </style>
        <main>
            <div id="contentVue">
            </div>
        </main>
    </div> --}}
    <router-view />


@endsection
