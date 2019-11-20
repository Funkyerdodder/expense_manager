<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="{{ asset('css/vuetify.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('js/vue.min.js') }}"></script>
  <script src="{{ asset('js/vue-resource.min.js') }}"></script>
  <script src="{{ asset('js/apexcharts.min.js') }}"></script>
  <script src="{{ asset('js/vuetify.js') }}"></script>
  <title>Expense Manager</title>
</head>
<body>
  <div id="app" v-cloak>
    <v-app>
      @include('template.navigation')
      <v-content>
        <v-container>
          @yield('content')
        </v-container>
      </v-content>
    </v-app>
  </div>
  @yield('script')
</body>
</html>