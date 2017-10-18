<?php
/*
	Template Name: Page Home
*/
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


get_header();

// the_content();
/*note small device, les images doivent disparaitre sauf le slider*/

?>

<div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">le slider</div>
    </div>
 </div>

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12 hidden-xs hidden-sm" style= "background-image:url('http://localhost/Sites%20WEB/rams/wordpress/wp-content/uploads/2017/10/Openpit-e1508327885652.jpg');background-repeat:no-repeat; height:10em">la punchline grand</div>
      <div class="col-xs-12 hidden-md hidden-lg">la punchline petite</div>
    </div>
 </div>

<div class="container-fluid">
    <div class="row" style="height:10em">
        <div class="col-md-6 hidden-xs hidden-sm">image</div>
        <div class="col-xs-12 col-md-6">Industry</div>
    </div>
        <div class="row" style="height:10em">
        <div class="col-md-6">Capabilities</div>
        <div class="col-md-6 hidden-xs hidden-sm">image</div>
    </div>
        <div class="row" style="height:10em">
        <div class="col-md-6 hidden-xs hidden-sm">Image</div>
        <div class="col-md-6">Career</div>
    </div>
 </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">la section exemples</div>
            <div class="row" style="padding:5em">
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
              </div>
        <div class="col-lg-12 hidden-xs hidden-sm">la sous section exemple</div>
            <div class="row" style="padding:5em">
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
                <div class="col-lg-4">4 colonnes</div>
            </div>
    </div>
 </div>

<?php get_footer() ?>