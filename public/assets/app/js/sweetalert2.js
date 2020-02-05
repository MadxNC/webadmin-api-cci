//== Class definition
var SweetAlert2Demo = function() {

    //== Demos
    var initDemos = function() {

        $('.delete_confirmation').click(function(e) {
            var link = $(this).data('href');
            swal({
                title: 'Êtes-vous sûre ?',
                text: 'Cette action est irréversible',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer cet élément!',
                confirmButtonClass: 'btn btn-danger',
                cancelButtonText: 'Annuler'
            }).then(function(result) {
                if (result.value) {
                    window.location.replace(link);
                }
            });
        });

    };

    return {
        //== Init
        init: function() {
            initDemos();
        },
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    'user strict';
    SweetAlert2Demo.init();
});