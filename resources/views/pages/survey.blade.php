@extends('layouts.main')
<head>
<script src="https://www.google.com/recaptcha/api.js?render=6LdQ9wcqAAAAAPCnB-ngKq2XFLd8SfvwTRfnMZqJ"></script>

</head>
@section('content')
    <div class="container-fluid py-4">
        <div id="survey-component">
            <survey-component></survey-component>
        </div>
    </div>
@endsection