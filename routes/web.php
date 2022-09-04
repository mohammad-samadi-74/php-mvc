<?php

use App\Core\Facades\Router;

Router::get('/','HomeController@home');
Router::get('/home','HomeController@home')->name('home');

Router::get('/login','LoginController@login')->middleware('guest')->name('login');
Router::post('/confirmLogin','LoginController@confirm')->name('confirmLogin');
Router::post('/logout','LoginController@logout')->middleware('auth');
Router::get('/signup','SignupController@signup')->middleware('guest');
Router::post('/confirmSignup','SignupController@confirm')->name('confirmSignup');

//reset password
Router::get('/resetPassword','ResetPasswordController@resetPassword')->middleware('guest');
Router::post('/resetPassword/confirm','ResetPasswordController@resetPasswordConfirm')->middleware('guest');

Router::get('/resetPassword/token','ResetPasswordController@resetPasswordToken')->middleware('guest');
Router::post('/resetPassword/tokenVerify','ResetPasswordController@resetPasswordTokenConfirm')->middleware('guest');

Router::get('/resetPassword/newPassword','ResetPasswordController@newPassword')->middleware('guest');
Router::post('/resetPassword/newPasswordVerify','ResetPasswordController@newPasswordVerify')->middleware('guest');
Router::post('/generateNewToken','ResetPasswordController@newPasswordGenerate')->middleware('guest');




Router::get('/profile','ProfileController@profile')->middleware('auth');

//admin panel
Router::get('/admin/panel','AdminController@adminPanel')->middleware('auth');

