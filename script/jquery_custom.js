$(document).ready(function() {
// Start

  // Slider for Content
  $('.slider > dl > dt').click(function() {
    if ( $(this).closest('.slider').is('.harmonic') &&  !$(this).next().is(':visible') ) {
      $('.harmonic > dl > dd').slideUp('slow').parent().find('dt').removeClass('show');
    }
    $(this).toggleClass('show').next().slideToggle('slow');
  });

  $('.form form').submit(function() {
    return false;
  });

  $('button#no').click(function() {
    window.location.href='index.php';
  });
  $('button#go').click(function() {
	  window.setTimeout("signorder()", 100);
  });
  $('button#ok').click(function() {
    window.location.href='signform.php';
  });

// Stop
});