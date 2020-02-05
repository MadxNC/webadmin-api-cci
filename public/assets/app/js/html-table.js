'use strict';
//== Class definition

var DatatableHtmlTableDemo = function() {
	//== Private functions

	// demo initializer
	var demo = function() {

		var users_datatable = $('#listing_users_table').mDatatable({

            saveState: {
                cookie: false,
                webstorage: false
            },
			search: {
				input: $('#generalSearch'),
			},
			columns : [{
				field:'id',
				type:'number'
			},{
				field:'username',
				type:'string'
			},{
				field:'roles',
				type:'string'
			},{
                field:'isActive',
                sortable: false
            },{
                field:'edit',
                sortable: false
            },{
                field:'change_password',
                sortable: false
            },{
                field:'delete',
                sortable: false
            }]


		});

		var groupes_datatable = $('#listing_groupe_table').mDatatable({
            saveState: {
                cookie: false,
                webstorage: false
            },
			search: {
				input: $('#generalSearch'),
			},
			columns : [{
				field:'id',
				type:'number'
			},{
				field:'name',
				type:'string'
			},{
				field:'role',
				type:'string'
			},{
                field:'isActive',
                sortable: false
            },{
                field:'options',
                sortable: false
            },{
                field:'delete',
                sortable: false
            }]


		});

		var menus_datatable = $('#listing_menus_table').mDatatable({
            saveState: {
                cookie: false,
                webstorage: false
            },
			search: {
				input: $('#generalSearch'),
			},
			columns : [{
				field:'id',
				type:'number'
			},{
				field:'name',
				type:'string'
			},{
				field:'route',
				type:'string'
			},{
                field:'isActive',
                sortable: false
            },{
                field:'edit',
                sortable: false
            },{
                field:'delete',
                sortable: false
            }]

		});

	};

	return {
		//== Public functions
		init: function() {
			// init demo
			demo();
		},
	};
}();

jQuery(document).ready(function() {
	DatatableHtmlTableDemo.init();
});