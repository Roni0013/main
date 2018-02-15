
$('.text-result input').on('click',function(){
   $.ajax({
		url:'/supplier/findsupplier',
		data:{id:this.value},
		type:'POST',
		success: function (res) {
			var data=jQuery.parseJSON(res);
                        //console.log ('<p>'+data[0].orgname);
                        $('.result-item').html(
                            '<p>'+data[0].orgname+'</p>'+
                            '<p>ИНН: '+data[0].inn+'</p>'+
                            '<p>КПП: '+data[0].kpp+'</p>'+
                            '<p>Адрес: '+data[0].address+'</p>'+
                            '<p>Телефон: '+data[0].phone+'</p>'
                                );
		}
	});
});
