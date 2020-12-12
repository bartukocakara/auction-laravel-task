$('#formTable').on('click', '.form-delete', function(e){
    e.preventDefault();
    var $form = $('#delete');
    $('#confirm').modal({ backdrop: 'static', keyboard: true })
        .on('click', '#delete-btn', function(){
            $form.submit();
        });
});
