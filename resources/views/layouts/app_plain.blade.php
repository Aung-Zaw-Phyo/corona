<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Corona</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/bootstrap.css') }}" />
    <!-- font awesome style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('extra_css')

</head>
<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('frontend/assets/js/bootstrap.js') }}"></script>
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    @yield('script')

    <script>
  
        $(document).ready(function () {
            let token = document.querySelector('meta[name=csrf-token]')
            if(token) {
                $.ajaxSetup({
                    headers: { 
                        'X-CSRF-TOKEN': token.content
                    }
                });
            }else {
                console.error('Token not found!');
            }
            

            var firebaseConfig = {
                apiKey: "AIzaSyCzAPl3yxJkIwLh6zByZDh--TaaKQOm9ew", 
                authDomain: "laravelfcm-b29ba.firebaseapp.com",
                databaseURL: "https://XXXX.firebaseio.com",
                projectId: "laravelfcm-b29ba",
                storageBucket: "laravelfcm-b29ba.appspot.com",
                messagingSenderId: "4333973945",
                appId: "1:4333973945:web:775e456ac4358cb8554668",                                                                                                      
                measurementId: "G-44YTE2STYX"
            };
            
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();
        
            function initFirebaseMessagingRegistration() {
                    messaging
                    .requestPermission()
                    .then(function () {
                        return messaging.getToken()
                    })
                    .then(function(token) {
                        document.getElementById("device_token_input").setAttribute("value", token)
                    }).catch(function (err) {
                        console.log('User Chat Token Error'+ err);
                    });
            }  

            initFirebaseMessagingRegistration()

            $('#register').on('submit', function (e) {
                initFirebaseMessagingRegistration()
            })
            
            messaging.onMessage(function(payload) {
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });
        })
       
    </script>

</body>
</html>