# Laravel Api

## Install Laravel  
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
    



## Milestone 2
   Create in folder `page`
   
   ```
   - Home.vue
   - About.vue
   - Products.vue
   - Product.vue 
   ```

   Install Vue Router 3
    `npm install vue-router@3`
   Modify `front.js`
   import Vue Router and pages 
   create e new instance of `VueRouter` with routes for
   ```
   Home 
   About
   Contacts
   Products
   Product
   ```

   Pass this instance to Vue


   Modify `App.vue`
   Delete Main and insert
   `<router-view></router-view>` 
   this is a VueRouter component that will render the route.

   Modify `Header.vue`
   replace tags a with `router-link` component
  
  ```JS
    menuItems: [
                {
                    label: 'Home',
                    routeName: 'home'
                },
                {
                    label: 'Products',
                    routeName: 'products'
                },
                {
                    label: 'Chi Siamo',
                    routeName: 'about'
                },
                {
                    label: 'Contatti',
                    routeName: 'contacts'
                }
            ]
  ```

  Modify `Main` add 
  `props:['cards']`

  We'll pass props from different pages
  Our buttons emit an event to parent component
 
  `$emit('changePage', vs);`
  
  in parent add event to instance of main
  ```HTML
  <Main @changePage="changePage($event)"></Main>
  ```


## Milestone 3 - Add Middleware Api 

  https://laravel.com/docs/7.x/middleware#introduction
  ## Create a new Middleware

  `php artisan make:middleware ApiAuth`

  Register this Middleware in `app/Http/Kernel.php`
  ```PHP
  'api.auth' => \App\Http\Middleware\ApiAuth::class,
  ```

  Add Middleware to Api.php
  ```PHP
  Route::post('v1/contacts/', 'Api\ContactController@sendMessage')->middleware('api.auth');
  ```

  Add in `config/app.php`
 
  ```PHP
    'apiKey' => env('API_KEY', 'jhy65rfghjuio'),
  ```

  Add in `.env` your token
  `API_KEY=jhgf678iklp987t`



  In Middleware `ApiAuth` add in function Handle

  ```PHP
   if ($request->header("Authorization") != "Bearer " . config('app.apiKey')) {
                "success" => false,
                "error" => "Bad Authorization"
            ]);
        }
  return $next($request);
  ```
  
### Upload a file with VueJs 
    1. Create `Api\ContactController`
  
    https://laravel.com/docs/7.x/requests#storing-uploaded-files

    We store a file in folder uploads
    ```PHP
      $path = $request->file->store('uploads');
    ```

    2. Create `pages/Contacts.vue`
    Add a form with `enctype="multipart/form-data"` and add an input type file

    We send the data to our `ContactController` with `Axios`

    ```JS
     sendForm() {
        const formData = new FormData();
        formData.append('file', this.form.file[0]);
      
        const headers = { 
          'Content-Type': 'multipart/form-data', 
          'Authorization': 'Bearer jhgf678iklp987t' 
        };

        const url = "http://127.0.0.1:8000/api/v1/contacts/";
        
        Axios.post(url, formData, { headers })
          .then((result) => {
            console.log(result.data, result.status );  // HTTP status //  // binary representation of the file
          })
        .catch(error => console.log(error));
      }
    ```
    
   https://developer.mozilla.org/en-US/docs/Web/API/FormData/Using_FormData_Objects

## Refactoring
  Create a Loading Component

  ```JS
    <template>
      <div class="d-flex justify-content-center align-items-center">
        <font-awesome-icon icon="fa-solid fa-spinner" size="2xl"  spin fixed-width/>
      </div>
    </template>

    <script>
    import { library } from '@fortawesome/fontawesome-svg-core'

    /* import specific icons */
    import { faSpinner } from '@fortawesome/free-solid-svg-icons'

    /* import font awesome icon component */
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

    /* add icons to the library */
    library.add(faSpinner)
    export default {
        name: "Loeading",
        components: {
          FontAwesomeIcon
        }, 
    }
    </script>
  ```

  And use it in `Home.vue`, we should view the component while the content is loading.