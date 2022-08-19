jQuery(document).ready(function ($) {

    var mediaUploader;

    $('#upload-button').click(function (e) {
        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function () {
            attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#image-url').val(attachment.url);
            document.getElementById("image-preview-event").src = attachment.url;
        });

        // Open the uploader dialog
        mediaUploader.open();
    });

});

/*upload 2*/

jQuery(document).ready(function ($) {
    var mediaUploader;

    $('#upload-button2').click(function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#image-url2').val(attachment.url);
            document.getElementById("image-preview-instructor").src = attachment.url;
        });
        mediaUploader.open();
    });

});

/*upload EDIT 1*/

jQuery(document).ready(function ($) {
    var mediaUploader;

    $('#upload-button3').click(function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#image-url3').val(attachment.url);
            document.getElementById("image-preview-event-edit").src = attachment.url;
        });

        mediaUploader.open();
    });

});

/*upload EDIT 2*/

jQuery(document).ready(function ($) {
    var mediaUploader;

    $('#upload-button4').click(function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#image-url4').val(attachment.url);
            document.getElementById("image-preview-instructor-edit").src = attachment.url;
        });

        mediaUploader.open();
    });

});

