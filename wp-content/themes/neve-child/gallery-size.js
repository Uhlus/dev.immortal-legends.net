jQuery(document).ready(function ($) {
  const img_amount = $('.wp-block-image').length;
  $('.wp-block-image').each(function () {
    const img = $(this).children('img');
    const width = galleryScale($(img).attr('width'));
    const height = galleryScale($(img).attr('height'));
    console.log(width);
    console.log(height);
    $(this).css('--x', width);
    $(this).css('--y', height);
    // $(this).css('--order', randomIntFromInterval(0, img_amount));
  });

});

function galleryScale(number) {
  return Math.min(5, Math.max(1, Math.floor(number / 200)))
}
function randomIntFromInterval(min, max) { // min and max included 
  return Math.floor(Math.random() * (max - min + 1) + min)
}