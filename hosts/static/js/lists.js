jQuery(function($) {
	var oTable = $('#listsTable').dataTable({
		"oLanguage": {
			//"sUrl": "media/language/de_DE.txt"， //语言包 文件格式和上面一样
			"sSearch": "搜索:",
			"sLengthMenu": "每页显示 _MENU_ 条",
			"sZeroRecords": "Nothing found - 没有数据",
			"sInfo": "当前显示  _START_ ~  _END_ 条, 共  _TOTAL_ 条",
			"sInfoEmpty": "显示0条记录",
			"oPaginate": {
				"sPrevious": " 上一页 ",
				"sNext":     " 下一页 ",
				"sFirst":    " 首页 ",
				"sLast":     " 末页 ",
			}
		},
		"bStateSave": true,	//保存状态到cookie
		"bLengthChange": true,	//是否启用设置每页显示记录数
		"iDisplayLength": 15,	//默认每页显示的记录数
		// "sScrollY": 200,//竖向滚动条 tbody区域的高度
		"bAutoWidth": true, //列的宽度会根据table的宽度自适应
		"aLengthMenu": [15, 20, 30, 50],  //设置每页显示记录的下拉菜单
		"bSort": true, //是否使用排序
		//"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": AjaxUrl,
		"sServerMethod": "POST",
		"aoColumns": listsField,
		"aoColumnDefs": [
		    {
		        "mRender": function ( data, type, row ) {
		            return '<label><input type="checkbox" value="'+ row[0] +'" name="checkAll" class="ace" /></label>';
		        },
		        "aTargets": [ 0 ]
		    }
		],
        "fnServerParams": function(aoData) {
        },
        "oTableTools": {
            "sRowSelect": "multi",
            "aButtons": [
               // { "sExtends": "editor_edit",   "editor": editor },
                //{ "sExtends": "editor_remove", "editor": editor }
            ]
        }
	});
	
	
	$('table th input:checkbox').on('click' , function(){
		var that = this;
		$(this).closest('table').find('tr > td:first-child input:checkbox')
		.each(function(){
			this.checked = that.checked;
			$(this).closest('tr').toggleClass('selected');
		});
			
	});


	$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
	function tooltip_placement(context, source) {
		var $source = $(source);
		var $parent = $source.closest('table')
		var off1 = $parent.offset();
		var w1 = $parent.width();

		var off2 = $source.offset();
		var w2 = $source.width();

		if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
		return 'left';
	}
});