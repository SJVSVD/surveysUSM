@extends('layouts.main')
<head>
    <script src="https://www.google.com/recaptcha/api.js?render=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></script>

</head>
@section('content')
    <div class="container-fluid py-4">
        <div id="survey-component">
            <survey-component></survey-component>
        </div>
    </div>
@endsection