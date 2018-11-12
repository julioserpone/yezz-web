<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*------------------------------------ NUEVAS RUTAS, NUEVOS DESARROLLOS -----------------------------*/

//RUTAS PUBLICAS
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('faqs/{language?}' , ['as' => 'faqs',  'uses' => 'AppController@faqs']);
Route::get('manuals/{language}'   , ['as' => 'manuals',  'uses' => 'AppController@manuals']);

Route::get('products/catalog/{language?}', ['as' => 'products.catalogs', 'uses' => 'AppController@showCatalog']);
Route::get('products/{model}/{language?}', ['as' => 'products.showProduct', 'uses' => 'AppController@showProduct']);
Route::get('products/compare/{language?}' , ['as' => 'products.compare',   'uses' => 'AppController@compare']);
Route::get('products/search' , ['as' => 'product.search',   'uses' => 'AppController@searchProduct']);
Route::get('products/autocomplete' , ['as' => 'product.autocomplete',   'uses' => 'AppController@productAutocomplete']);

//RUTAS PUBLICAS CON AUTHORIZATION
//Centros de servicio autorizado
Route::group(['roles' => ['sysadmin','workshop'], 'middleware' => ['auth','roles']], function () {
	Route::get('authorized-service-centers/{language?}' , ['as' => 'authorized-service-centers',  'uses' => 'SoftwareController@authorizedService']);
	Route::get('authorized-service-centers/download/{id}' , ['as' => 'download.software',  'uses' => 'SoftwareController@download']);
});

Route::auth();

Route::group(['prefix' => 'admin', 'roles' => ['sysadmin'], 'middleware' => ['auth','roles']], function () {

	Route::get('/', ['as' => 'admin', 'uses' => 'HomeController@admin']);
	Route::get('/home', ['as' => 'admin.home', 'uses' => 'HomeController@index']);

	//Categories
	Route::resource('categories', 'CategoryController');
	Route::get('categories/active/{id}', ['as' => 'categories.active', 'uses' => 'CategoryController@active']);
	Route::get('categories/destroy/{id}', ['as' => 'categories.destroy', 'uses' => 'CategoryController@destroy']);
	Route::post('categories/delete/{id}', ['as' => 'categories.delete', 'uses' => 'CategoryController@delete']);

	//Banners
	Route::resource('banners', 'BannerController');
	Route::get('banners/active/{id}', ['as' => 'banners.active', 'uses' => 'BannerController@active']);
	Route::get('banners/destroy/{id}', ['as' => 'banners.destroy', 'uses' => 'BannerController@destroy']);
	Route::post('banners/delete/{id}', ['as' => 'banners.delete', 'uses' => 'BannerController@delete']);

	//Users
	Route::resource('users', 'UserController');
	Route::get('users/active/{id}', ['as' => 'users.active', 'uses' => 'UserController@active']);
	Route::get('users/destroy/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);
	Route::post('users/delete/{id}', ['as' => 'users.delete', 'uses' => 'UserController@delete']);

	//Banners
	Route::resource('softwares', 'SoftwareController');
	Route::get('softwares/active/{id}', ['as' => 'softwares.active', 'uses' => 'SoftwareController@active']);
	Route::get('softwares/destroy/{id}', ['as' => 'softwares.destroy', 'uses' => 'SoftwareController@destroy']);
	Route::post('softwares/delete/{id}', ['as' => 'softwares.delete', 'uses' => 'SoftwareController@delete']);

	//FAQs
	Route::get('faqs', ['as' => 'api.pub.faqs', 'uses' => 'FaqController@index']);
	Route::get('faqs/view', ['as' => 'admin.faqs.view', 'uses' => 'FaqController@view']);
	Route::post('faqs/store', ['as' => 'admin.faqs.store', 'uses' => 'FaqController@store']);
	Route::put('faqs/{ext_id}/update', ['as' => 'admin.faqs.update', 'uses' => 'FaqController@update']);
	Route::post('faqs/{ext_id}/delete', ['as' => 'admin.faqs.destroy', 'uses' => 'FaqController@destroy']);
	Route::post('faqs/{ext_id}/remove', ['as' => 'admin.faqs.remove', 'uses' => 'FaqController@remove']);
	Route::post('faqs/{ext_id}/restore', ['as' => 'admin.faqs.restore', 'uses' => 'FaqController@restore']);

	//Journal
	Route::get('journal', ['as' => 'admin.journal', 'uses' => 'JournalController@index']);
	Route::get('journal/edit/{ext_id}', ['as' => 'admin.journal.edit', 'uses' => 'JournalController@edit']);
	Route::post('journal/store', ['as' => 'admin.journal.store', 'uses' => 'JournalController@store']);
	Route::put('journal/update/{ext_id}', ['as' => 'admin.journal.update', 'uses' => 'JournalController@update']);
	Route::post('journal/destroy/{ext_id}', ['as' => 'admin.journal.destroy', 'uses' => 'JournalController@destroy']);

	//Product
	Route::get('products/view',    ['as' => 'admin.products.view',   'uses' => 'ProductController@view']);
	Route::get('products/create',  ['as' => 'admin.products.create', 'uses' => 'ProductController@create']);
	Route::get('products/{ext_id}/edit',  ['as' => 'admin.products.edit',  'uses' => 'ProductController@edit']);
	Route::put('products/{ext_id}',['as' => 'admin.products.update', 'uses' => 'ProductController@update']);
	Route::post('products/store',  ['as' => 'admin.products.store',  'uses' => 'ProductController@store']);
	Route::post('products/{ext_id}/delete',  ['as' => 'admin.products.destroy', 'uses' => 'ProductController@destroy']);
	Route::post('products/{ext_id}/remove',  ['as' => 'admin.products.remove',  'uses' => 'ProductController@remove']);
	Route::post('products/{ext_id}/restore', ['as' => 'admin.products.restore', 'uses' => 'ProductController@restore']);
	Route::get('productcountry/delete/{product}/{ext_id}', ['as' => 'admin.products.deleteCountry', 'uses' => 'ProductController@deleteCountry']);
	Route::post('productcountry/add/{ext_id}', ['as' => 'admin.products.addCountry', 'uses' => 'ProductController@addCountry']);
	Route::get('product/deletesgen/{ext_id}', ['as' => 'admin.products.deletesgen', 'uses' => 'ProductController@deleteSgEn']);
	Route::get('product/deletesges/{ext_id}', ['as' => 'admin.products.deletesges', 'uses' => 'ProductController@deleteSgEs']);
	Route::get('product/deletemanual/{ext_id}', ['as' => 'admin.products.deletemanual', 'uses' => 'ProductController@deleteManual']);

	//Sellers
	Route::get('sellers', ['as' => 'admin.sellers', 'uses' => 'SellerController@index']);
	Route::post('seller/store', ['as' => 'admin.seller.store', 'uses' => 'SellerController@store']);
	Route::put('seller/update/{ext_id}', ['as' => 'admin.seller.update', 'uses' => 'SellerController@update']);
	Route::get('seller/edit/{ext_id}', ['as' => 'admin.seller.edit', 'uses' => 'SellerController@edit']);
	Route::get('seller/create', ['as' => 'admin.seller.create', 'uses' => 'SellerController@create']);
	Route::post('seller/delete/{ext_id}', ['as' => 'admin.seller.delete','uses' => 'SellerController@destroy']);

	//Services Providers
	Route::get('serviceproviders', ['as' => 'admin.serviceproviders', 'uses' => 'ServiceProviderController@index']);
	Route::get('serviceproviders/edit/{ext_id}', ['as' => 'admin.serviceproviders.edit', 'uses' => 'ServiceProviderController@edit']);
	Route::post('serviceproviders/store', ['as' => 'admin.serviceproviders.store', 'uses' => 'ServiceProviderController@store']);
	Route::put('serviceproviders/update/{ext_id}', ['as' => 'admin.serviceproviders.update', 'uses' => 'ServiceProviderController@update']);
	Route::get('serviceproviders/create', ['as' => 'admin.serviceproviders.create', 'uses' => 'ServiceProviderController@create']);
	Route::post('serviceproviders/delete/{ext_id}', ['as' => 'admin.serviceproviders.delete', 'uses' => 'ServiceProviderController@destroy']);

});

//A ESTE GRUPO FALTA AGREGARLE EL PREFIJO ADMIN
Route::group(['roles' => ['sysadmin'], 'middleware' => ['auth','roles']], function () {

	//Regions
	Route::get('regions',        ['as' => 'regions', 'uses' => 'RegionController@index']);
	Route::get('regions/view',   ['as' => 'regions.view', 'uses' => 'RegionController@view']);
	Route::get('regions/create', ['as' => 'regions.create', 'uses' => 'RegionController@create']);
	Route::get('regions/{code}/edit', ['as' => 'regions.edit', 'uses' => 'RegionController@edit']);
	Route::get('regions/{code}', ['as' => 'regions.show', 'uses' => 'RegionController@show']);
	Route::put('regions/{code}', ['as' => 'regions.update', 'uses' => 'RegionController@update']);
	Route::post('regions',       ['as' => 'regions.store', 'uses' => 'RegionController@store']);
	Route::post('regions/{code}/delete', ['as' => 'region.destroy', 'uses' => 'RegionController@destroy']);
	Route::post('regions/{code}/restore', ['as' => 'region.restore', 'uses' => 'RegionController@restore']);
	Route::post('regions/{code}/remove', ['as' => 'regions.remove', 'uses' => 'RegionController@remove']);

	//Countries
	Route::get('countries/{name}/edit', ['as' => 'countries.edit', 'uses' => 'CountryController@edit']);
	Route::put('countries/{code}/update', ['as' => 'countries.update', 'uses' => 'CountryController@update']);
	Route::post('countries/{code}/delete', ['as' => 'countries.destroy', 'uses' => 'CountryController@destroy']);
	Route::get('countries/list', ['as' => 'countries.index', 'uses' => 'CountryController@index']);
	Route::get('countries/view', ['as' => 'countries.view', 'uses' => 'CountryController@view']);
	Route::post('countries/store', ['as' => 'countries.store', 'uses' => 'CountryController@store']);
	Route::post('countries/{code}/remove', ['as' => 'countries.remove', 'uses' => 'CountryController@remove']);
	Route::post('countries/{code}/restore', ['as' => 'countries.restore', 'uses' => 'CountryController@restore']);

	//Categories
	Route::get('ytcategories/view',     ['as' => 'ytcategories.view',   'uses'  => 'YtCategoryController@view']);
	Route::get('ytcategories/create',   ['as' => 'ytcategories.create', 'uses'  => 'YtCategoryController@create']);
	Route::get('ytcategories/{ext_id}/edit', ['as' => 'ytcategories.edit',   'uses'  => 'YtCategoryController@edit']);
	Route::put('ytcategories/{ext_id}', ['as' => 'ytcategories.update', 'uses'  => 'YtCategoryController@update']);
	Route::post('ytcategories/{ext_id}/delete',  ['as' => 'ytcategories.destroy', 'uses'  => 'YtCategoryController@destroy']);
	Route::post('ytcategories/{ext_id}/remove',  ['as' => 'ytcategories.remove',  'uses'  => 'YtCategoryController@remove']);
	Route::post('ytcategories/{ext_id}/restore', ['as' => 'ytcategories.restore', 'uses'  => 'YtCategoryController@restore']);
	Route::post('ytcategories/store',   ['as' => 'ytcategories.store',  'uses' => 'YtCategoryController@store']);

	//Themes
	Route::get('ytthemes/view',              ['as' => 'ytthemes.view',   'uses'  => 'YtThemeController@view']);
	Route::get('ytthemes/create',            ['as' => 'ytthemes.create', 'uses'  => 'YtThemeController@create']);
	Route::get('ytthemes/{ext_id}/edit',     ['as' => 'ytthemes.edit',   'uses'  => 'YtThemeController@edit']);
	Route::put('ytthemes/{ext_id}',          ['as' => 'ytthemes.update', 'uses'  => 'YtThemeController@update']);
	Route::post('ytthemes/{ext_id}/delete',  ['as' => 'ytthemes.destroy','uses'  => 'YtThemeController@destroy']);
	Route::post('ytthemes/{ext_id}/remove',  ['as' => 'ytthemes.remove', 'uses'  => 'YtThemeController@remove']);
	Route::post('ytthemes/{ext_id}/restore', ['as' => 'ytthemes.restore','uses'  => 'YtThemeController@restore']);
	Route::post('ytthemes/store',            ['as' => 'ytthemes.store',  'uses'  => 'YtThemeController@store']);
	Route::post('ytthemes/comment/{ext_id}/delete',  ['as' => 'ytthemes.comment.delete',  'uses'  => 'YtThemeController@deleteComment']);
	Route::post('ytthemes/comment/{ext_id}/restore', ['as' => 'ytthemes.comment.restore',  'uses' => 'YtThemeController@restoreComment']);
});

//RUTAS ORIGINALES
Route::get('admin/faqs/search', ['as' => 'api.pub.faqs.search', 'uses' => 'FaqController@search']);
Route::get('api/pub/faqs/{ext_id}', ['as' => 'api.pub.faqs.show', 'uses' => 'FaqController@show']);
Route::post('api/pub/faqs/create', ['as' => 'api.pub.faqs.create', 'uses' => 'FaqController@create']);

/*Language*/
Route::get('api/pub/languages', ['as' => 'api.pub.languages', 'uses' => 'LanguageController@index']);
Route::get('api/pub/languages/{code}', ['as' => 'api.pub.languages.show', 'uses' => 'LanguageController@show']);
Route::put('api/pub/languages/{code}', ['as' => 'api.pub.languages.update', 'uses' => 'LanguageController@update']);
Route::post('api/pub/languages/create', ['as' => 'api.pub.languages.create', 'uses' => 'LanguageController@create']);
Route::delete('api/pub/languages/{code}', ['as' => 'api.pub.languages.destroy', 'uses' => 'LanguageController@destroy']);

/*Country*/
Route::post('api/pub/countries/create', ['as' => 'api.pub.countries.create', 'uses' => 'CountryController@create']);
Route::get('api/pub/countries/{code}', ['as' => 'api.pub.countries.show', 'uses' => 'CountryController@show']);

Route::post('api/pub/products/{ext_id}/country/{country}', ['as' => 'api.pub.products.productCountry', 'uses' => 'ProductController@productCountry']);
Route::get('api/pub/products/{code}', ['as' => 'api.pub.products.show', 'uses' => 'ProductController@show']);
Route::delete('api/pub/products/{ext_id}/country/{country}', ['as' => 'api.pub.products.deleteProductCountry', 'uses' => 'ProductController@deleteProductCountry']);
Route::get('api/pub/products', ['as' => 'api.pub.products.index', 'uses' => 'ProductController@index']);

/*Specification*/
Route::get('specifications/edit', ['as' => 'specifications.edit', 'uses' => 'SpecificationController@edit']);
Route::put('specifications/{ext_id}/update', ['as' => 'specifications.update', 'uses' => 'SpecificationController@update']);
Route::post('specifications/store',          ['as' => 'specifications.store',  'uses' => 'SpecificationController@store']);
Route::post('specifications/{ext_id}/remove',         ['as' => 'specifications.remove',  'uses' => 'SpecificationController@remove']);

/*Highlights*/
Route::get('highlights',        ['as' => 'highlights.index', 'uses' => 'HighlightController@index']);
Route::post('highlights/store', ['as' => 'highlights.store', 'uses' => 'HighlightController@store']);
Route::put('highlights/{ext_id}/update', ['as' => 'highlights.update', 'uses' => 'HighlightController@update']);
Route::post('highlights/{ext_id}/delete', ['as' => 'highlights.delete', 'uses' => 'HighlightController@destroy']);
Route::post('highlights/{ext_id}/remove', ['as' => 'highlights.remove', 'uses' => 'HighlightController@remove']);
Route::post('highlights/{ext_id}/restore',['as' => 'highlights.restore', 'uses' => 'HighlightController@restore']);

/*YezzTalk*/
Route::get('api/yt/themestatus', ['as' => 'api.pub.themestatus.index', 'uses' => 'YtThemeStatusController@index']);

/* Question Status*/
Route::get('api/yt/questionstatus', ['as' => 'api.pub.questionstatus.index', 'uses' => 'YtQuestionstatusController@index']);

/* Questions*/
Route::get('api/yt/questions', ['as' => 'api.pub.questions.index', 'uses' => 'YtQuestionController@index']);
Route::get('api/yt/questions/{ext_id}', ['as' => 'api.pub.questions.show', 'uses' => 'YtQuestionController@show']);
Route::put('api/yt/questions/{ext_id}', ['as' => 'api.pub.questions.update', 'uses' => 'YtQuestionController@update']);
Route::post('api/yt/questions/create', ['as' => 'api.pub.questions.create', 'uses' => 'YtQuestionController@create']);
Route::delete('api/yt/questions/{ext_id}', ['as' => 'api.pub.questions.destroy', 'uses' => 'YtQuestionController@destroy']);

/* Answers*/
Route::get('api/yt/answers', ['as' => 'api.pub.answers.index', 'uses' => 'YtAnswerController@index']);
Route::get('api/yt/answers/{ext_id}', ['as' => 'api.pub.answers.show', 'uses' => 'YtAnswerController@show']);
Route::put('api/yt/answers/{ext_id}', ['as' => 'api.pub.answers.update', 'uses' => 'YtAnswerController@update']);
Route::patch('api/yt/answers/{ext_id}/rate', ['as' => 'api.pub.answers.rate', 'uses' => 'YtAnswerController@rate']);
Route::patch('api/yt/answers/{ext_id}/report', ['as' => 'api.pub.answers.report', 'uses' => 'YtAnswerController@report']);
Route::post('api/yt/answers/create', ['as' => 'api.pub.answers.create', 'uses' => 'YtAnswerController@create']);
Route::delete('api/yt/answers/{ext_id}', ['as' => 'api.pub.answers.destroy', 'uses' => 'YtAnswerController@destroy']);

/*Labels*/
Route::get('api/yt/labels', ['as' => 'api.pub.labels.index', 'uses' => 'LabelController@index']);

Route::get('/userList', ['as' => 'userList', 'uses' => 'UserController@index']);

/*Public*/
Route::get('/',        ['as' => 'app', 'uses' => 'AppController@view']);
Route::get('/es', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/pt', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/fr', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en-ca', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/fr-ca', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en-us', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-us', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);

Route::get('/es-co', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-cr', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-sv', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-ec', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-gt', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-mx', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-ni', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-pa', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-pe', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-uy', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-ve', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);

Route::get('/en-bg', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/es-es', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/fr-fr', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en-it', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/pt-pt', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en-ro', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/fr-ch', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en-gb', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);

Route::get('/en-cr', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/fr-ma', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en-ni', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/en-ae', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);
Route::get('/pt-br', ['as' => 'app.lang', 'uses' => 'AppController@viewLang']);

Route::get('yezztalk/{langcountry}'    ,['as' => 'yezztalk.lang',          'uses' => 'YezztalkController@view']);
Route::get('yezztalk'                  ,['as' => 'yezztalk',               'uses' => 'YezztalkController@yezztalk']);
Route::get('yezztalk/theme/{ext_id}'   ,['as' => 'yezztalk.theme',         'uses' => 'YezztalkController@theme']);
Route::get('yezztalk/category/{ext_id}',['as' => 'yezztalk.category',      'uses' => 'YezztalkController@category']);
Route::post('yezztalk/comment/store'   ,['as' => 'yezztalk.comment.store', 'uses' => 'YtThemeController@storeComment']);
Route::post('yezztalk/comment/like/{ext_id}'   ,['as' => 'yezztalk.comment.like', 'uses' => 'YtThemeController@postCommentLike']);
Route::post('yezztalk/comment/dislike/{ext_id}',['as' => 'yezztalk.comment.dislike', 'uses' => 'YtThemeController@postCommentDislike']);
Route::post('yezztalk/theme/like/{ext_id}'     ,['as' => 'yezztalk.theme.like',   'uses' => 'YtThemeController@postThemeLike']);
Route::post('yezztalk/theme/dislike/{ext_id}' ,['as' => 'yezztalk.theme.dislike', 'uses' => 'YtThemeController@postThemeDislike']);

                                                
Route::get('contact' , ['as' => 'contact',  'uses' => 'AppController@contacts']);
Route::get('contact/{langcountry}' , ['as' => 'contact',  'uses' => 'AppController@contact']);
Route::get('contact/{section}/{form}/{language?}' , ['as' => 'contact.form',  'uses' => 'AppController@contactForm']);
Route::post('contact/mail' , ['as' => 'contact.mail',  'uses' => 'AppController@sendContactMail']);

Route::get('api/product/{ext_id}' , ['as' => 'api.product',  'uses' => 'AppController@apiProduct']);

Route::get('service-providers', ['as' => 'service-providers.view',  'uses' => 'AppController@service_provider']);
Route::get('service-providers/{langcountry}', ['as' => 'service-providers.view',  'uses' => 'AppController@service_providers']);

 /*Login*/
Route::post('user/login',    ['as' => 'user.login', 'uses' => 'AppController@authenticate']);
Route::post('user/register', ['as' => 'user.login', 'uses' => 'AppController@register']);
Route::get('user/confirm/{token}', ['as' => 'user.register.confirm', 'uses' => 'AppController@confirm']);
Route::get('user/reconfirm/{email}', ['as' => 'user.register.reconfirm', 'uses' => 'AppController@reconfirm']);

Route::post('user/reset', ['as' => 'user.reset', 'uses' => 'SendMailController@resetPassword']);

/*support*/
Route::get('support', ['as' => 'support',  'uses' => 'AppController@support']);
Route::get('support/{langcountry}', ['as' => 'support',  'uses' => 'AppController@supports']);

/*Sellers*/
Route::get('sellers', ['as' => 'sellers',  'uses' => 'AppController@sellers_location']);
Route::get('sellers/{langcountry}', ['as' => 'sellers.index',  'uses' => 'AppController@sellers']);
Route::get('sellers/{country_code}/list', ['as' => 'sellers.list',  'uses' => 'AppController@sellerList']);

/**/
Route::get('/unsolicited-idea-submission-policy/{language?}', ['as' => 'unsolicited',  'uses' => 'AppController@unsolicited']);

Route::get('privacy/{language?}', ['as' => 'privacy',  'uses' => 'AppController@privacy']);

Route::post('/subscribe', ['as' => 'public.subscribe',  'uses' => 'AppController@subscribe']);


/*Warranty*/
Route::get('/warranty-policy/{langcountry}', ['as' => 'warranty-policy',  'uses' => 'AppController@warranty_policy']);

/*Repair Program*/
Route::get('/support/exchange-repair-extension-programs/programs/en', ['as' => 'repair-program',  'uses' => 'AppController@repairProgram']);



Route::get('/validate', ['as' => 'appvalidate',  'uses' => 'AppController@validatepage']);


Route::get('/campaign/mail/img/{img_name}', ['as' => 'appvalidate',  'uses' => 'AppController@showEmailImage']);
