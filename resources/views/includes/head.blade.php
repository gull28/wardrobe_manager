<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    {{-- <link href="{{ asset('/app.css') }}" rel="stylesheet"> --}}

    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    @vite(['public/app.css', 'resources/scss/app.scss'])

    <!-- Scripts -->
    {{-- <link rel="stylesheet" href="{{ URL::asset('/app.js') }}" /> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

</head>
