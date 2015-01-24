<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(array('before' => 'is.mobile'), function() {
  Route::get('/', function() {
    return View::make('main');
  });

  Route::get('/api/search/{query}', 'SearchController@getSearch');
  Route::get('/api/hot', 'SearchController@getHot');
  Route::get('/api/course/{id}/evaluation', 'EvaluationController@getEvaluations');
  Route::get('/api/course/{id}', 'EvaluationController@getInfo');
  Route::get('/api/course/{id}/basic', 'EvaluationController@getBasic');

  Route::get('/api/course/{id}/vote', 'EvaluationController@postVote');
  Route::post('/api/course/{id}/evaluation', array('before' => 'csrf', 'uses' => 'EvaluationController@postEvaluate'));

  Route::post('/api/stat', array('before' => 'csrf', 'uses' => 'EvaluationController@postStat'));
});