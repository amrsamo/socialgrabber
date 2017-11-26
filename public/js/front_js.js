$('.mythumbnail').click(function(){
	    $('.modal-body').empty();
	    var title = $(this).attr("title");
	    // alert(title);
	    // return;
	    $('.modal-title').html('Title');
	    var html = $("#"+title).html();
	    $(".modal-body").append(html);
	    // $("#"+title).appendTo('.modal-body');
	    $('#myModal').modal({show:true});
	});
