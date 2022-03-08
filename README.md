# Api

1. Install Laravel  
  - Remove fzaninotto/faker and install Fakerphp
    `composer require fakerphp/faker`
    ` composer remove fzaninotto/faker`
  - Auth Vue Scaffolding 
    `composer require laravel/ui:^2.4`
    ` php artisan ui vue --auth  `
  - Update Boostrap
    Modify Package.json
    ```JS 
    "devDependencies": {
          "axios": "^0.19",
          "bootstrap": "^5.1.0",
    ```
  - Modify `webpack.mix.js`

    ```JS
    mix.js('resources/js/admin.js', 'public/js')
    .js('resources/js/front.js', 'public/js')
    .js('node_modules/popper.js/dist/popper.js', 'public/js').sourceMaps()
    .sass('resources/sass/app.scss', 'public/css');
    ```
  - Duplicate app.js and rename the files in:
    `admin.js` `front.js`

     `admin.js` leave only 
     ```JS
     require('./bootstrap');

     ```
    `front.js` Vue Require and load Component Example
     ```JS
      require('./bootstrap');

      window.Vue = require('vue');

      const app = new Vue({
          el: '#app',
      });

     ```

  - Create Scaffolding for Vue
    ```
      --resources
      --components
        --Header.vue
        --Main.vue
      --views
        App.vue
    ```

  - Modify `front.js` 
    ```JS
    import App from './views/App';

    const app = new Vue({
        el: '#app',
        render: h => h(App),
    });
    ```
  - In `layouts/app.blade.php` remove `script app.js`

  - Create in `resources/views` folder `guest` and create `home.blade.php` extends `layouts/app.blade.php` 
    In this file add  `div#app` and script `front.js`
    ```HTML
        <script src="{{ asset('js/front.js') }}" defer></script>
    ```
  - Add in `Main.Vue` an "Hello Word"

  - Create Guest's Routes
    At the and of the file `web.php` add a route with a variable parameter and a regular expression that allow the slash as a placeholder. 
    This route able us to add Vue Router in the future.

    https://laravel.com/docs/7.x/routing#parameters-optional-parameters
    https://laravel.com/docs/7.x/routing#parameters-regular-expression-constraints
    https://laravel.com/docs/7.x/routing#parameters-encoded-forward-slashes

    ```PHP
    Route::get("{any?}", function () {
      return view("guest.home");
    })->where("any", ".*");
    ```

    - Add a navbar in Header.Vue and import in App.vue
      Create a folder img in resources and add a logo
      Import in Vue with 
      `require("../../img/bag-shopping-solid.svg"),`
      laravel.mix generate a folder `images` in `public`
      in the generated html we'll have
      `/images/bag-shopping-solid.svg?7caef6685167fa68243b13113a66a780`

    - Modify Navbars in app.blade.php and home.blade.php
    