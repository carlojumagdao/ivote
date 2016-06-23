<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('master');
});

// Dashboard //
Route::get('/dashboard', array(
	'uses' => 'dashboardController@index',
	'as' => 'dashboard.index'
));

// Member Form //
Route::get('/memberform', function () {
    return view('Members.form');
});
Route::post('memberform/save', array(
	'uses' => 'formController@save',
	'as' => 'form.save'
));
Route::get('memberform/render', array(
	'uses' => 'formController@render',
	'as' => 'form.render'
));
// Member Form //

// Member //
Route::get('/member', array(
	'uses' => 'formController@index',
	'as' => 'member.index'
));
Route::get('member/create', array(
	'uses' => 'formController@create',
	'as' => 'member.create'
));
Route::post('member/add', array(
	'uses' => 'formController@add',
	'as' => 'member.add'
));
Route::get('member/edit/{id}', array(
	'uses' => 'formController@edit',
	'as' => 'member.edit'
));
Route::post('member/edit/update', array(
	'uses' => 'formController@update',
	'as' => 'member.update'
));
Route::post('member/delete', array(
	'uses' => 'formController@delete',
	'as' => 'member.delete'
));
// Member //

// General Setting //
Route::get('/settings/general', function () {
    return view('Settings.general');
});
Route::get('/settings/general', array(
	'uses' => 'gensetController@index',
	'as' => 'genset.index'
));
Route::post('/settings/general/save', array(
	'uses' => 'gensetController@save',
	'as' => 'genset.save'
));
// General Setting //


// Security Questions //
Route::get('/settings/security', array(
	'uses' => 'securityController@index',
	'as' => 'security.index'
));
Route::post('/settings/security/add', array(
	'uses' => 'securityController@add',
	'as' => 'security.add'
));
Route::post('/settings/security/update', array(
	'uses' => 'securityController@update',
	'as' => 'security.update'
));
Route::post('/settings/security/delete', array(
	'uses' => 'securityController@delete',
	'as' => 'security.delete'
));
// Security Questions //


// Party Affiliation //
Route::get('/settings/party', array(
	'uses' => 'partyController@index',
	'as' => 'party.index'
));
Route::post('/settings/party/add', array(
	'uses' => 'partyController@add',
	'as' => 'party.add'
));
Route::post('/settings/party/update', array(
	'uses' => 'partyController@update',
	'as' => 'party.update'
));
Route::post('/settings/party/delete', array(
	'uses' => 'partyController@delete',
	'as' => 'party.delete'
));
// Party Affiliation //


// Position //
Route::get('/position', array(
	'uses' => 'positionController@index',
	'as' => 'position.index'
));
Route::get('/position/create', array(
	'uses' => 'positionController@create',
	'as' => 'position.create'
));
Route::post('/position/add', array(
	'uses' => 'positionController@add',
	'as' => 'position.add'
));
// Position //