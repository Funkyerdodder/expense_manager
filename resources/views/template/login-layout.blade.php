<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="{{ asset('css/vuetify.min.css') }}" rel="stylesheet">
  <script src="{{ asset('js/vue.min.js') }}"></script>
  <script src="{{ asset('js/vue-resource.min.js') }}"></script>
  <script src="{{ asset('js/vuetify.js') }}"></script>
</head>
<body>
  {{-- <div id="app" v-cloak>
    <v-app>
      <v-content>
        <v-container>
          @yield('content')
        </v-container>
      </v-content>
    </v-app>
  </div> --}}
  @yield('content')

</body>
</html>