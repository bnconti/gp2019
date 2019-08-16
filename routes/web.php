<?php

Route::get('/', 'ProyectoController@login');
// Login oauth
Route::get('/login/google', 'Auth\LoginController@redirectToProvider');
Route::get('/inicio', 'Auth\LoginController@handleProviderCallback');
// Login user/pass
Route::post('/login', 'Auth\LoginController@loginWithPassword');
Route::post('/register', 'Auth\RegisterController@create');

Route::get('/logout', 'ProyectoController@logout');
Route::get('/locked', 'ProyectoController@locked');
Route::get('/editUser', 'ProyectoController@editUser')->name('editUser');
Route::get('/reportes', 'ReporteController@index')->middleware('checkRole');
Route::get('/publicaciones', 'PublicacionController@index')->name('publicaciones')->middleware('checkCUIT');

// Rutas para las tablas de datos con Ajax
Route::get('ajax/proyectos', 'ProyectoController@getProyectos')->name('get.proyectos');
Route::get('ajax/tesis', 'TesisTesinaController@get')->name('get.tesis');
Route::get('ajax/trabajos', 'TrabajoEventoController@get')->name('get.trabajos');
Route::get('ajax/articulos', 'ArticuloRevistaController@get')->name('get.articulos');
Route::get('ajax/libros', 'LibroController@get')->name('get.libros');
Route::get('ajax/parteslibro', 'ParteLibroController@get')->name('get.parteslibro');
Route::get('/inicio2', 'ProyectoController@index')->middleware('checkCUIT');
Route::get('/reportes', 'ReporteController@index')->middleware('checkRole');
Route::get('/usuarios', 'UsuarioController@index');
Route::get('ajax/usuarios','UsuarioController@getUsuarios')->name('get.usuarios');

// Reportes
Route::get('/reporteFecha', 'ReporteController@reporteFecha')->middleware('checkRole');
Route::get('/reporteAutor', 'ReporteController@reporteAutor')->middleware('checkRole');
Route::get('/reporteTipo', 'ReporteController@reporteTipo')->middleware('checkRole');

// Rutas para el usuario
Route::patch('/cambiarContra/{usuario}', 'UsuarioController@cambiarContra');
Route::patch('/cambiarEstado/{usuario}', 'UsuarioController@cambiarEstado');

Route::patch('/usuarios/agregarProyecto/{persona}', 'UsuarioController@agregarProyecto');
Route::get('/usuarios/removerProyecto/{persona}/{proyecto}', 'UsuarioController@removerProyecto');
Route::patch('/usuarios/agregarPublicacion/{persona}', 'UsuarioController@agregarPublicacion');
Route::get('/usuarios/removerPublicacion/{persona}/{proyecto}', 'UsuarioController@removerPublicacion');

Route::resource('usuarios','UsuarioController');

// Rutas de los Recursos (contienen el index, create, edit, etc.)
Route::resource('proyectos', 'ProyectoController', ['except' => ['show', 'destroy']])->middleware('checkCUIT');

Route::resource('tesisTesina', 'TesisTesinaController')->middleware('checkCUIT');
Route::resource('trabajoEvento', 'TrabajoEventoController')->middleware('checkCUIT');
Route::resource('articuloRevista', 'ArticuloRevistaController')->middleware('checkCUIT');
Route::resource('libro', 'LibroController')->middleware('checkCUIT');
Route::resource('parteLibro', 'ParteLibroController')->middleware('checkCUIT');

// Rutas para el autocompletado
Route::get('/searchEntidad', 'AutocompleteController@searchEntidad')->name('entidad.search');
Route::get('/searchPersonaNombre', 'AutocompleteController@searchPersonaNombre')->name('personaNombre.search');
Route::get('/searchPersonaApellido', 'AutocompleteController@searchPersonaApellido')->name('personaApellido.search');
Route::get('/searchPersonaCuitCuil', 'AutocompleteController@searchPersonaCuitCuil')->name('personaCuitCuil.search');

// Rutas de validacion de campos
Route::get('/checkTituloProyectoRepetido', 'ProyectoController@checkTituloRepetido')->name('checkTituloProyectoRepetido');
Route::post('/checkTituloProyectoRepetido', 'ProyectoController@checkTituloRepetido')->name('checkTituloProyectoRepetido');

Route::get('/checkTituloPublicacionRepetido', 'PublicacionController@checkTituloRepetido')->name('checkTituloPublicacionRepetido');
Route::post('/checkTituloPublicacionRepetido', 'PublicacionController@checkTituloRepetido')->name('checkTituloPublicacionRepetido');

Route::post('/checkEmailUsado', 'UsuarioController@checkEmailUsado')->name('checkEmailUsado');

// Rutas para reportes
Route::get('/getProyectosTipo/{id}', 'ReporteController@getProyectosTipo');
Route::get('/poblarElementosSegunProyecto/{id}/{seleccionProyecto}', 'ReporteController@poblarElementosSegunProyecto');
Route::get('personaProyectoExtension/{personaid}/{elementoid}','ReporteController@personaProyectoExtension');
Route::get('personaProyectosVarios/{personaid}/{elementoid}','ReporteController@personaProyectosVarios');

Route::get('/poblarElementosSegunPublicacion/{id}/{seleccionPublicacion}', 'ReporteController@poblarElementosSegunPublicacion');
Route::get('personaLibro/{autorid}/{elementoid}','ReporteController@libroPorAutorId');
Route::get('personaArtRevista/{autorid}/{elementoid}','ReporteController@ArticuloRevistaPorAutorId');
Route::get('personaGrado/{autorid}/{elementoid}','ReporteController@GradoPorAutorId');
Route::get('personaCongresos/{autorid}/{elementoid}','ReporteController@CongresosPorAutorId1');

