$(function(){
    'use strict';

    // Afficher la liste des membres d'un groupe
    function outputMembersList(data){
        $('#members_modal .modal-body').html(data);
    }

    $('.show_members_btn').on('click',function(){

        $.post(
            $(this).attr('href'),
            null,
            outputMembersList,
            'html'
        );
    });

    // Vérification des routes
    function afterCheck(data){

        var menuId = data.menuId;
        var icon = data.icon;
        var msg = data.msg;
        $('*[data-ref='+ menuId +']').html(msg + ' <i class="'+ icon +'"></i>');

    }

    function checkRoutes() {

        var checks = $('.check_route');

        if(checks) {

            checks.each(function(){
                var check = $(this);
                $.post(
                    check.data('href'),
                    null,
                    afterCheck,
                    'json'
                );
            });
        }

    }

    $('.check-routes-btn').on('click',function(){
       checkRoutes();
    });



});