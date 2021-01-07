<script type="text/javascript">
       
    tinymce.init({
        selector: "textarea",
        height: 500,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true,

        external_filemanager_path: "{{url('assets/responsive_filemanager/filemanager')}}/",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {
            "responsivefilemanager": "{{url('assets/responsive_filemanager/tinymce/plugins/responsivefilemanager/plugin.min.js')}}",
            "filemanager": "{{url('assets/responsive_filemanager/filemanager/plugin.min.js')}}"
        },
    });

</script>