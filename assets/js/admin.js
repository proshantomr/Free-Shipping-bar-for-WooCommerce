jQuery(document).ready(function($) {
    // Initialize the color picker
    $('.fsb-color-field').wpColorPicker();

    function updatePreview() {
        var text = $('input[name="fsb_text_field"]').val();
        var textColor = $('input[name="fsb_text_color"]').val();
        var font = $('select[name="fsb_font_family"]').val();
        var bgColor = $('input[name="fsb_background_color"]').val();
        var fontSize = $('input[name="fsb_font_size"]').val();
        var icon = $('select[name="fsb_icon"]').val();
        var textAlign = $('select[name="fsb_text_alignment"]').val();
        var isTransparent = $('input[name="fsb_background_transparent"]').is(':checked');
        var barHeight = $('input[name="fsb_bar_height"]').val();
        var barWidth = $('input[name="fsb_bar_width"]').val();

        $('#fsb-preview').css({
            'background-color': isTransparent ? 'transparent' : bgColor,
            'background-image': 'none', // Remove background image
            'height': barHeight + 'px',
            'width': barWidth + '%'
        });

        $('#fsb-preview-text').css({
            'color': textColor,
            'font-family': font,
            'font-size': fontSize + 'px',
            'text-align': textAlign
        });

        $('#fsb-preview-text').html('<span class="dashicons ' + icon + '"></span> ' + text);
    }

    // Bind events
    $('input[name="fsb_text_field"]').on('input', updatePreview);
    $('input[name="fsb_text_color"]').on('input change', updatePreview);
    $('select[name="fsb_font_family"]').on('change', updatePreview);
    $('input[name="fsb_background_color"]').on('input change', updatePreview);
    $('input[name="fsb_font_size"]').on('input', updatePreview);
    $('select[name="fsb_icon"]').on('change', updatePreview);
    $('input[name="fsb_background_transparent"]').on('change', updatePreview);
    $('select[name="fsb_text_alignment"]').on('change', updatePreview);
    $('input[name="fsb_bar_height"]').on('input', updatePreview);
    $('input[name="fsb_bar_width"]').on('input', updatePreview);

    updatePreview();
});




document.addEventListener('DOMContentLoaded', function() {
    var closeButton = document.getElementById('fsb-close-btn');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            var bar = document.getElementById('fsb-bar');
            if (bar) {
                bar.style.display = 'none';
            }
        });
    }
});

