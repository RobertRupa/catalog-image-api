$(document).ready(function() {
    var uploaderDropzone = Dropzone.forElement(".dropzone");
    uploaderDropzone.options.url = "/uploader/upload";
    uploaderDropzone.on("addedfile", function(response) {
        var acceptedFiles = uploaderDropzone.getAcceptedFiles();
        acceptedFiles = $.grep(acceptedFiles, function(file, index) {
            if (file.name === response.name) {
                console.log("already exist: repleacing");
                uploaderDropzone.removeFile(file);
                return false;
            }

            return true;
        });

    });

    $('.dropzone').submit(function(event) {
        //event.preventDefault();
        //$(this).attr('action', '/uploader/save');
        let fileList = [];
        var acceptedFiles = uploaderDropzone.getAcceptedFiles();

        $.each(acceptedFiles, function(index, file) {
            fileList.push({ fileName: file.name });
        });
        $('.files-to-upload').val(JSON.stringify(fileList));
    });
});