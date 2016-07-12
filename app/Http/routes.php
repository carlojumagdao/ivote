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



Route::get('/admin', function () {
   if(Auth::check()){return Redirect::to('dashboard');}
    return view('auth/login');
});


Route::group(['middleware' => 'auth'], function(){
	
	Route::get('/dashboard', array(
		'uses' => 'dashboardController@index',
		'as' => 'dashboard.index'
	));

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

	Route::post('member/email', array(
    'uses' => 'MailController@send',
    'as' => 'member.email'
	));
	Route::post('member/send', array(
		'uses' => 'formController@send',
		'as' => 'member.send'
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
    
    // UI Setting //
    Route::get('/settings/UI', function(){
		return view('Settings.UI');
    });
    Route::post('/settings/UI/skin', array(
		'uses' => 'UIController@skin',
		'as' => 'UI.skin'
	));
	
	Route::get('/getPDF',
		'PDFController@getPDF');
	/*Route::get('/settings/pdfile',function(){
		'uses' => 'PDFController@PDFunct',
		'as' => 'settings.pdfile'
	});*/
    // UI Setting //


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
    Route::post('/settings/party/', array(
        'uses' => 'partyController@editpage',
        'as' => 'party.edit'
    ));
    Route::post('/settings/party/add', array(
        'uses' => 'partyController@add',
        'as' => 'party.add'
    ));
    Route::post('/settings/party/edit', array(
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
	Route::get('/position/edit/{id}', array(
		'uses' => 'positionController@edit',
		'as' => 'position.edit'
	));
	Route::post('/position/add', array(
		'uses' => 'positionController@add',
		'as' => 'position.add'
	));
	Route::post('/position/update', array(
		'uses' => 'positionController@update',
		'as' => 'position.update'
	));
	// Position //

	// Survey //
	Route::get('/survey', array(
		'uses' => 'surveyController@index',
		'as' => 'survey.index'
	));
	Route::post('survey/save', array(
		'uses' => 'surveyController@save',
		'as' => 'survey.save'
	));
	Route::get('survey/render', array(
		'uses' => 'surveyController@render',
		'as' => 'survey.render'
	));
	Route::get('survey/view', array(
		'uses' => 'surveyController@view',
		'as' => 'survey.view'
	));
	// Survey //


	

    // Candidates //
    Route::get('/candidates', array(
		'uses' => 'candidateController@index',
		'as' => 'candidate.index'
	));
    Route::get('/candidates/add', array(
		'uses' => 'candidateController@add',
		'as' => 'candidate.add'
	));
    Route::post('/candidates/add', array(
		'uses' => 'candidateController@newCandidate',
		'as' => 'candidate.newCandidate'
	));
    Route::post('/candidates/delete', array(
		'uses' => 'candidateController@delete',
		'as' => 'candidate.delete'
	));
    Route::post('/candidates/', array(
		'uses' => 'candidateController@editpage',
		'as' => 'candidate.edit'
	));
    Route::post('/candidates/edit', array(
		'uses' => 'candidateController@update',
		'as' => 'candidate.update'
	));
    
    // Candidates //

    //user//
	Route::get('/user', array(
		'uses' => 'userController@index',
		'as' => 'user.index'
	));
	Route::get('user/create', array(
		'uses' => 'userController@create',
		'as' => 'user.create'	
	));
	Route::post('user/add', array(
		'uses' => 'userController@add',
		'as' => 'user.add'
	));
	Route::post('user/delete', array(
		'uses' => 'userController@delete',
		'as' => 'user.delete'
	));
	Route::get('user/profile', array(
		'uses' => 'userController@profile',
		'as' => 'user.profile'
	));
	Route::post('user/updatePassword', array(
		'uses' => 'userController@updatePassword',
		'as' => 'user.updatePassword'
	));	
	Route::post('user/updateProfile', array(
		'uses' => 'userController@updateProfile',
		'as' => 'user.updateProfile'
	));		
	Route::post('user/update', array(
		'uses' => 'userController@update',
		'as' => 'user.update'
	));	
	Route::get('user/edit', array(
		'uses' => 'userController@edit',
		'as' => 'user.edit'
	));
	
	//user//
});

// Candidate Page//

Route::get('/candidates/page', array(
	'uses' => 'candidateController@page',
	'as' => 'candidate.page'
));

// Candidate Page//




// Member Form //


// Authentication Admin //
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// Authentication Admin//

// Registration Admin//
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
// Registration Admin//

//Log In User//
Route::get('/', array(
	'uses' => 'responseController@LogInUser',
	'as' => 'LogInUser'
));

//Log In User//


//Countdown//
Route::get('/Countdown', array(
	'uses' => 'CountdownController@Count',
	'as' => 'Countdown'
));
//Countdown//

Route::group(['middleware' => 'userlog'], function(){
    
    
    Route::post('/', array(
        'uses' => 'responseController@Validation',
	   'as' => 'Validate'
    ));

	Route::post('/survey/answer', array(
		'uses' => 'responseController@survey',
		'as' => 'surveyanswer'
	));
    // Voting route
    Route::get('/vote', array(
		'uses' => 'votingController@page',
		'as' => 'voting.page'
	));
    Route::post('/vote', array(
		'uses' => 'votingController@cast',
		'as' => 'voting.cast'
	));
    //Voting Route
    

});

Route::post('/survey/add', array(
	'uses' => 'responseController@postsurvey',
	'as' => 'survey.postsurvey'
));
//Log In User//
