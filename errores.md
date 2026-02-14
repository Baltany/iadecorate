# carrito
# Illuminate\Database\QueryException - Internal Server Error

SQLSTATE[42S02]: Base table or view not found: 1146 Table 'iadecorate_backend.carrito' doesn't exist (Connection: mariadb, Host: 127.0.0.1, Port: 3306, Database: iadecorate_backend, SQL: select * from `carrito` where `usuario_id` = 1)

PHP 8.4.16
Laravel 12.50.0
localhost:8000

## Stack Trace

0 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
1 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:794
2 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:411
3 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3389
4 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3374
5 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3964
6 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3373
7 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:902
8 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:884
9 - app/Http/Controllers/CarritoController.php:19
10 - vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:46
11 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:265
12 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:211
13 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:822
14 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
15 - vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php:50
16 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
17 - vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php:63
18 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
19 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php:87
20 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
21 - vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php:48
22 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
23 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:120
24 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:63
25 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
26 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php:36
27 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
28 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php:74
29 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
30 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
31 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:821
32 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:800
33 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:764
34 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:753
35 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:200
36 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
37 - vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php:19
38 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
39 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
40 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php:31
41 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
42 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
43 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php:51
44 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
45 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php:27
46 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
47 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php:109
48 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
49 - vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php:61
50 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
51 - vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php:58
52 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
53 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php:22
54 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
55 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php:26
56 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
57 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
58 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:175
59 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:144
60 - vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1220
61 - public/index.php:20
62 - vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php:23

## Request

GET /carrito

## Headers

* **host**: localhost:8000
* **connection**: keep-alive
* **sec-ch-ua**: "Not:A-Brand";v="99", "Google Chrome";v="145", "Chromium";v="145"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "Linux"
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **referer**: http://localhost:8000/perfil
* **accept-encoding**: gzip, deflate, br, zstd
* **accept-language**: en-GB,en-US;q=0.9,en;q=0.8,es;q=0.7
* **cookie**: kairos_cookies_aceptadas=si; kairos_primera_visita=no; kairos_cookies_decididas=solo_obligatorias; g_state={"i_l":0,"i_ll":1771007353419,"i_b":"pDaTDizAo/fJ++g7iGi+8J5K1N6SDBUa14mY88RG7rY","i_e":{"enable_itp_optimization":0}}; XSRF-TOKEN=eyJpdiI6IkhyanEveGRVM3ZCckhDTDhlR1lMbHc9PSIsInZhbHVlIjoiZ29GazBaTzNLR2tycDliR0YwWUtkS3cyRnZISFhkY1RTVGJvdEloRktGYWFHcjhvWkowWVczaVA1bzByWkx6YjVldmJ0NXYzTUwrY3BjWTJnQUtKYVpvV2RTd2ZaMitoZk5IVHh5WllCdi9LdHJWOVJwTUdkWE55RnFFdFN4MnYiLCJtYWMiOiI0NTJiY2U2YTU4MGJhOTg1ZmUzN2E0NzJiZDFkZmM2OTA5NzU3OGMxZDkwMmFkZTk0M2NjYTlmYTFhMmIyMDQyIiwidGFnIjoiIn0%3D; iadecorate-backend-session=eyJpdiI6IjJldDFhWUtPTXhyKzU2UnBvcDE0Ync9PSIsInZhbHVlIjoicjYrZXo3YmNCWjc2Z244c2tmYldwVlgwSTZSNnN5bkx2dXUvSXFiY3dRWFNmZUtXTjNTWHJWaVFUTXMwcERlNmRHQ0xPM05FMVpLdGlXUE5La1JlZXdCbmJscFA1azVYZjdIblpVaW5OZ3o0ZnhGdERkR05FSHk1dzE2TkY1ZHEiLCJtYWMiOiJmMzVkOTc2NTUyZDUwNGQ2OTEwYWMzMzM0Yjg3MDUwNDY2ZGUwN2QzNmE0ZGM5MzYxYjU0ZmU2ZTNhNjdkZDFhIiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\CarritoController@index
route name: carrito
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* mariadb - select * from `sessions` where `id` = 'Da7PmnkIXRMVMEifCdfltYOeDiaPSzWX4Yhekz0v' limit 1 (0.8 ms)
* mariadb - select * from `users` where `id` = 1 limit 1 (0.25 ms)

# perfil
el perfil no se ve como lo tengo yo en mis plantillas

# pedidos
# Illuminate\Database\QueryException - Internal Server Error

SQLSTATE[42S22]: Column not found: 1054 Unknown column 'usuario_id' in 'where clause' (Connection: mariadb, Host: 127.0.0.1, Port: 3306, Database: iadecorate_backend, SQL: select * from `pedidos` where `usuario_id` = 1 order by `created_at` desc)

PHP 8.4.16
Laravel 12.50.0
localhost:8000

## Stack Trace

0 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
1 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:794
2 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:411
3 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3389
4 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3374
5 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3964
6 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3373
7 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:902
8 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:884
9 - app/Http/Controllers/PedidoController.php:21
10 - vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:46
11 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:265
12 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:211
13 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:822
14 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
15 - vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php:50
16 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
17 - vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php:63
18 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
19 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php:87
20 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
21 - vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php:48
22 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
23 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:120
24 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:63
25 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
26 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php:36
27 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
28 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php:74
29 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
30 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
31 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:821
32 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:800
33 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:764
34 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:753
35 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:200
36 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
37 - vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php:19
38 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
39 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
40 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php:31
41 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
42 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
43 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php:51
44 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
45 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php:27
46 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
47 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php:109
48 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
49 - vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php:61
50 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
51 - vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php:58
52 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
53 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php:22
54 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
55 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php:26
56 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
57 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
58 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:175
59 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:144
60 - vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1220
61 - public/index.php:20
62 - vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php:23

## Request

GET /pedidos

## Headers

* **host**: localhost:8000
* **connection**: keep-alive
* **cache-control**: max-age=0
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **sec-ch-ua**: "Not:A-Brand";v="99", "Google Chrome";v="145", "Chromium";v="145"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "Linux"
* **referer**: http://localhost:8000/login
* **accept-encoding**: gzip, deflate, br, zstd
* **accept-language**: en-GB,en-US;q=0.9,en;q=0.8,es;q=0.7
* **cookie**: kairos_cookies_aceptadas=si; kairos_primera_visita=no; kairos_cookies_decididas=solo_obligatorias; g_state={"i_l":0,"i_ll":1771007353419,"i_b":"pDaTDizAo/fJ++g7iGi+8J5K1N6SDBUa14mY88RG7rY","i_e":{"enable_itp_optimization":0}}; XSRF-TOKEN=eyJpdiI6IlFucnl4eGMwZklpQjlIakgrRmRYdWc9PSIsInZhbHVlIjoidER6V2lkTEw5YmRNTTVXS0lNUDgvQkxXT0k5Y3kwakVIbXNvck93L2tjcjRNTnRaQjdPSG5IeTRidEVmWkJyMWFMdS95bTdoQjVhbHNLSm1PdTJkdWlJOHhBSXBLUUltNjN3OUZnWWhMS3c0a05NUitlcUY5QWpjQk5oOGF4cEQiLCJtYWMiOiJiYWNlM2EwYmVlMDNmZTQ5MDc5YTgzMWEyZWEwNjc1ZTE2MzNkNTYxMmExNjBiYzNmNDhkMmM3NWUwZGExMjAzIiwidGFnIjoiIn0%3D; iadecorate-backend-session=eyJpdiI6Im1nMmg5em5pM3Z0VXdUSXU3bkhUOXc9PSIsInZhbHVlIjoiY09tSUtnV1AzeFA2d2lQay8zMmJHYU1Wdm5iK3hTdW9uVFNpMHYrTGd1c3lQMUd0YzdPMUw2M3NLcWhuajZiZmJlNGo1ZmZNU0FVeWc0d1dySm1GcW9xbGFYSXVNZFh2bEo4ZGtTSy9XRFd1R2M1MHdOdTRJeW1ZaEtrSU4rSG4iLCJtYWMiOiIxZjFmMDMzNWU5NjY0Mzg1YTViNWVlNTM3MjliNjVmM2Q0NzAwNGQwYjlhMjI4OTMxMDU4MDllOWI5NGQ2YWEwIiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\PedidoController@index
route name: pedidos
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* mariadb - select * from `sessions` where `id` = 'tw2JRK2frHmzbyGdg7LyWiPiVk2sMoItYrAg78P9' limit 1 (1.85 ms)
* mariadb - select * from `users` where `id` = 1 limit 1 (0.44 ms)

# catalogo
cuando yo pincho en un producto,no me lleva a la pagina de detalles,creo que no has hecho esa pagina...
ademas se tienen que mostrar los productos que yo tenga en mi bbdd

# entorno
# InvalidArgumentException - Internal Server Error

View [entorno] not found.

PHP 8.4.16
Laravel 12.50.0
localhost:8000

## Stack Trace

0 - vendor/laravel/framework/src/Illuminate/View/FileViewFinder.php:138
1 - vendor/laravel/framework/src/Illuminate/View/FileViewFinder.php:78
2 - vendor/laravel/framework/src/Illuminate/View/Factory.php:150
3 - vendor/laravel/framework/src/Illuminate/Foundation/helpers.php:1101
4 - routes/web.php:65
5 - vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php:39
6 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:243
7 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:214
8 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:822
9 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
10 - vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php:50
11 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
12 - vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php:63
13 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
14 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php:87
15 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
16 - vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php:48
17 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
18 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:120
19 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:63
20 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
21 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php:36
22 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
23 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php:74
24 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
25 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
26 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:821
27 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:800
28 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:764
29 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:753
30 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:200
31 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
32 - vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php:19
33 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
34 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
35 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php:31
36 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
37 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
38 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php:51
39 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
40 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php:27
41 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
42 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php:109
43 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
44 - vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php:61
45 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
46 - vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php:58
47 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
48 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php:22
49 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
50 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php:26
51 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
52 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
53 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:175
54 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:144
55 - vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1220
56 - public/index.php:20
57 - vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php:23

## Request

GET /entorno

## Headers

* **host**: localhost:8000
* **connection**: keep-alive
* **sec-ch-ua**: "Not:A-Brand";v="99", "Google Chrome";v="145", "Chromium";v="145"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "Linux"
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **referer**: http://localhost:8000/catalogo
* **accept-encoding**: gzip, deflate, br, zstd
* **accept-language**: en-GB,en-US;q=0.9,en;q=0.8,es;q=0.7
* **cookie**: kairos_cookies_aceptadas=si; kairos_primera_visita=no; kairos_cookies_decididas=solo_obligatorias; g_state={"i_l":0,"i_ll":1771007353419,"i_b":"pDaTDizAo/fJ++g7iGi+8J5K1N6SDBUa14mY88RG7rY","i_e":{"enable_itp_optimization":0}}; XSRF-TOKEN=eyJpdiI6IkJJNFR1OElWalREQXRpdkRlUWhwUWc9PSIsInZhbHVlIjoiWTNhcEdtNmZ0RCsrWDBIR1lENVNvZ3J1U1hzVER1QW5XdlpVTFBOVUVIWld0S3RZalRuY3RVRFJEdklxcEVRamtpY2pRZTUvY0RVOXVXbGZRbElsVWxGWHNjY0dYdlNqU0ljY2poTTZCY2ovVEppcDh4WFgxUWd0U2xReFNWT1kiLCJtYWMiOiIwODVmNDc2ZWEyYzMzMzY0MzNiYjJhYTRjYWFlMmQwMjYwODdmMmU3NjZiYTg2NzQzNzY3ODIxNTlkN2FjZGE4IiwidGFnIjoiIn0%3D; iadecorate-backend-session=eyJpdiI6ImxZd0ZFalpTL3BQeG9FMkNEa3FCNVE9PSIsInZhbHVlIjoiTEVTU2xsdWNQUWwxZUJ0OGJSNW1XWXZWbjVZbkRGU0VwU0VDV1dvNi8rUStXRVFvZktYYkZWV0REMmVJakNlTE82Z09oVGRtSFM0T1k2WlB3TEs5SEw1eGdaZmZoZFowYVUyamM5QmFNazhvL0xld0lvazFXQktPVWRBdGZvNXMiLCJtYWMiOiI0ODU1ZmE4ZWRiODRhYWZhYmM2ZWMxZGNlMjZkYTZhMjZhY2Y0OWY0N2UyMDc3OGVlMjk0YWM5Y2I0MThhMDU2IiwidGFnIjoiIn0%3D

## Route Context

controller: Closure
route name: entorno
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* mariadb - select * from `sessions` where `id` = 'tw2JRK2frHmzbyGdg7LyWiPiVk2sMoItYrAg78P9' limit 1 (1.86 ms)
* mariadb - select * from `users` where `id` = 1 limit 1 (1.11 ms)

# info
esta pagina no se ve como los estilos que yo tengo,es decir no se ve como yo pido.

# mensajeria
# Illuminate\Database\QueryException - Internal Server Error

SQLSTATE[42S22]: Column not found: 1054 Unknown column 'usuario_id' in 'where clause' (Connection: mariadb, Host: 127.0.0.1, Port: 3306, Database: iadecorate_backend, SQL: select * from `mensajes` where `usuario_id` = 1 or `destinatario_id` = 1 order by `created_at` asc)

PHP 8.4.16
Laravel 12.50.0
localhost:8000

## Stack Trace

0 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
1 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:794
2 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:411
3 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3389
4 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3374
5 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3964
6 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3373
7 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:902
8 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:884
9 - app/Http/Controllers/MensajeController.php:20
10 - vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:46
11 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:265
12 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:211
13 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:822
14 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
15 - vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php:50
16 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
17 - vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php:63
18 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
19 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php:87
20 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
21 - vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php:48
22 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
23 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:120
24 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:63
25 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
26 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php:36
27 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
28 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php:74
29 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
30 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
31 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:821
32 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:800
33 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:764
34 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:753
35 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:200
36 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
37 - vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php:19
38 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
39 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
40 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php:31
41 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
42 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
43 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php:51
44 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
45 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php:27
46 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
47 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php:109
48 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
49 - vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php:61
50 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
51 - vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php:58
52 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
53 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php:22
54 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
55 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php:26
56 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
57 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
58 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:175
59 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:144
60 - vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1220
61 - public/index.php:20
62 - vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php:23

## Request

GET /mensajeria

## Headers

* **host**: localhost:8000
* **connection**: keep-alive
* **sec-ch-ua**: "Not:A-Brand";v="99", "Google Chrome";v="145", "Chromium";v="145"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "Linux"
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **referer**: http://localhost:8000/info
* **accept-encoding**: gzip, deflate, br, zstd
* **accept-language**: en-GB,en-US;q=0.9,en;q=0.8,es;q=0.7
* **cookie**: kairos_cookies_aceptadas=si; kairos_primera_visita=no; kairos_cookies_decididas=solo_obligatorias; g_state={"i_l":0,"i_ll":1771007353419,"i_b":"pDaTDizAo/fJ++g7iGi+8J5K1N6SDBUa14mY88RG7rY","i_e":{"enable_itp_optimization":0}}; XSRF-TOKEN=eyJpdiI6IlRQZGU2SnlUdG9kQzJINjBjQmtOcWc9PSIsInZhbHVlIjoiOFVQWU40bVZMRjBEaXhaeVUvdDdibHJZNW9ab0RQN3RrV2U0cDZEZGNkV251cWJGRzU2WUpvVzNpV21EZjZ6RVI5SFNibVhwTzUvYXFmRXgweWVQRFZ2eHc2UmJxKzFBZDNQelFjUUV4bUo0Szk0dVRxZm04VTFocGRUaXBNZ3YiLCJtYWMiOiI0YjQ2NzQ3OGUzNzJiZjQwYjY0NTJlN2RjNjQ1MzAzMDA2NWQwYmI3YTAwOWY0NDlkYzgyM2M1MWJkMDE2MzUyIiwidGFnIjoiIn0%3D; iadecorate-backend-session=eyJpdiI6IndCZzdHeStlYkVvckZFa3lPUW1IZ3c9PSIsInZhbHVlIjoiaXdBZXNNWlNTYmhVOWFGSlpCYkNPRGsvZG5LS284K3FhR0wxNmh6RTJUUUxwMGIzTXY3dDBQNnVsQXJFeVVjbjMyRDNqYTRoditMalErcjQ3M0lNTlpqTW9FYVcvc0NWU2s1RUhqa2JwblRDbnd4cUxyeDRTR1pIc1MvZGR1VnIiLCJtYWMiOiIxYmFiNTRlZGE2NGMxODUzZTZhYjhkYTMyZTNmM2NjMjZiNWRlNmEyNmM0YjdhMWQyZDA1MjJiN2YxNTIyYTQ0IiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\MensajeController@index
route name: mensajeria
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* mariadb - select * from `sessions` where `id` = 'tw2JRK2frHmzbyGdg7LyWiPiVk2sMoItYrAg78P9' limit 1 (1.62 ms)
* mariadb - select * from `users` where `id` = 1 limit 1 (0.62 ms)

# incidencias
# Illuminate\Database\QueryException - Internal Server Error

SQLSTATE[42S22]: Column not found: 1054 Unknown column 'usuario_id' in 'where clause' (Connection: mariadb, Host: 127.0.0.1, Port: 3306, Database: iadecorate_backend, SQL: select * from `incidencias` where `usuario_id` = 1 order by `created_at` desc)

PHP 8.4.16
Laravel 12.50.0
localhost:8000

## Stack Trace

0 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:838
1 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:794
2 - vendor/laravel/framework/src/Illuminate/Database/Connection.php:411
3 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3389
4 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3374
5 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3964
6 - vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:3373
7 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:902
8 - vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:884
9 - app/Http/Controllers/IncidenciaController.php:18
10 - vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:46
11 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:265
12 - vendor/laravel/framework/src/Illuminate/Routing/Route.php:211
13 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:822
14 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
15 - vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php:50
16 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
17 - vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php:63
18 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
19 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php:87
20 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
21 - vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php:48
22 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
23 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:120
24 - vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php:63
25 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
26 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php:36
27 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
28 - vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php:74
29 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
30 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
31 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:821
32 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:800
33 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:764
34 - vendor/laravel/framework/src/Illuminate/Routing/Router.php:753
35 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:200
36 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:180
37 - vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php:19
38 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
39 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
40 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php:31
41 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
42 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php:21
43 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php:51
44 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
45 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php:27
46 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
47 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php:109
48 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
49 - vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php:61
50 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
51 - vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php:58
52 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
53 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php:22
54 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
55 - vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php:26
56 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:219
57 - vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:137
58 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:175
59 - vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:144
60 - vendor/laravel/framework/src/Illuminate/Foundation/Application.php:1220
61 - public/index.php:20
62 - vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php:23

## Request

GET /incidencias

## Headers

* **host**: localhost:8000
* **connection**: keep-alive
* **sec-ch-ua**: "Not:A-Brand";v="99", "Google Chrome";v="145", "Chromium";v="145"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "Linux"
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **referer**: http://localhost:8000/info
* **accept-encoding**: gzip, deflate, br, zstd
* **accept-language**: en-GB,en-US;q=0.9,en;q=0.8,es;q=0.7
* **cookie**: kairos_cookies_aceptadas=si; kairos_primera_visita=no; kairos_cookies_decididas=solo_obligatorias; g_state={"i_l":0,"i_ll":1771007353419,"i_b":"pDaTDizAo/fJ++g7iGi+8J5K1N6SDBUa14mY88RG7rY","i_e":{"enable_itp_optimization":0}}; XSRF-TOKEN=eyJpdiI6IlhHaFpsTEs0M0dDc0ZncGQ5MjJFOVE9PSIsInZhbHVlIjoiTDVOQ20yVS92NTE4Q081Q1lYUTlBUnozcjI4TG5oM3VVMWRBWTJDbHFrT1AvaGw3RmcvTEhzckJjNURxdlM4d29pWGZvSnExdXpRUENiVzUvT1IvcG0xNEhTZm4vdnVZVEZhc3A5UXh2WXE2am10eis0QldlbW5HMjJ0TzFrTXgiLCJtYWMiOiI3MWQ2NGFhNTU0MzQ4YTJiNTE3MTBkZGIzYzNkZjAyZDE3YWFkZDZlNjBhMDk1ZDZkZWY0N2VmODg0NjdlOGM1IiwidGFnIjoiIn0%3D; iadecorate-backend-session=eyJpdiI6ImJmWDRleElPM2Ntem9Yd2NCMm9lbkE9PSIsInZhbHVlIjoiL3B5REt4QytFL1BYQitiUlF3RjJrZVZhdjVDcXFaV0JDdUpPSDhlVHJsRFFxRENQak5mQ1hIUHE1dWRBSndwS3BmK0xockM0US85R3llUUlrbHpLL1JyQ2VralA2blY0SVY1YkliTUNSU3IwSzdtMnVaRnE1SFBhYW1abldEYWoiLCJtYWMiOiIzYjYxY2JjMjM5NjdlMWFiM2I5MzdlYzlmY2NiOGNmZjQ2MTAwYjgzMzY2MjczYWZlYjlmNTFhMzk5M2QxYzQ3IiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\IncidenciaController@index
route name: incidencias
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* mariadb - select * from `sessions` where `id` = 'tw2JRK2frHmzbyGdg7LyWiPiVk2sMoItYrAg78P9' limit 1 (2.36 ms)
* mariadb - select * from `users` where `id` = 1 limit 1 (0.92 ms)

