/* Media library picker for the video fields in Project details. */
(function ($) {
  $(document).on('click', '.creadigol-pick', function (e) {
    e.preventDefault();
    var target = document.getElementById($(this).data('target'));
    var frame = wp.media({ title: 'Choose a video', library: { type: 'video' }, multiple: false, button: { text: 'Use this video' } });
    frame.on('select', function () {
      var file = frame.state().get('selection').first().toJSON();
      target.value = file.url;
    });
    frame.open();
  });
})(jQuery);
