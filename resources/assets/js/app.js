/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
base_url = window.location.origin; //variable global base_url
require('./bootstrap'); //require bootstrap
require( 'datatables.net-bs4' ); //require datatables

// require File JS
require('./page/home.js');

// Access File js by pathname
$(function() {
  switch (window.location.pathname) {
    case '/home' : home.start(); break; // access file js home
    default:
  }
})
