<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    <title>{{env('APP_NAME')}}</title>

    <style>
        .gradient-color {
            background-color: #e9bcb7;
            background-image: linear-gradient(315deg, #e9bcb7 0%, #29524a 74%);
        }
    </style>
</head>

<body class="bg-gradient-to-r from-cyan-500 to-blue-500" >
        <div id="app" class="w-full my-20">
            <router-view></router-view>
        </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
