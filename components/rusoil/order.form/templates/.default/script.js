$(function(){
addRow()
checkDeleteBtn()
$('.btn-secondary').on('click', function(e) {
    e.preventDefault()
    let validate = true
    let required_inputs = $('input[required]')
    required_inputs.each(function(){
        console.log($(this).val())
        if($(this).val().length < 1) {
            validate = false
            $(this).siblings('div.invalid-feedback').css('display', 'block')
        }
    })
    if(validate) {
        $('.answer').empty()
        $('div[data-example="yes"]').find('input, select').each(function(){
            $(this).attr('disabled', true)
        })
        var fd = new FormData(document.getElementById("order-form"));
        $.ajax({
            url: "/local/components/rusoil/order.form/ajax.php",
            type: "POST",
            contentType: false,
            processData: false,
            data: fd,
            success: function(data){
                $('div[data-example="yes"]').find('input, select').each(function(){
                    $(this).removeAttr('disabled')
                })
                $('#order-form').trigger("reset");
                $('.answer').append(data)
                debugger
                $('div[data-example="no"]').each(function(){
                    $(this).remove()
                })
                addRow()
            }
        });
    }
})
$('input[required]').on('change, input', function(){
    if($(this).val().length >= 1) {
        $(this).siblings('div.invalid-feedback').css('display', 'none')
    } else {
        $(this).siblings('div.invalid-feedback').css('display', 'block')
    }
})
function initBtns() {
    $('.btn-primary').off()
    $('.btn-primary').click(function(){
        if($(this).val() == '+') {
            addRow()
        } else {
            deleteRow($(this))
        }
    })
}
function addRow() {
        let row = $('div[data-example="yes"]')
            .clone()
            .attr('data-example', 'no')
            .removeAttr('hidden')
        $('#rows').append(row)
        initBtns()
        checkDeleteBtn()
}
function deleteRow(element) {
        element.parents('div.form-row').remove()
        checkDeleteBtn()
}
function checkDeleteBtn() {
    let rows = $('div[data-example="no"]')
    if(rows.length > 1) {
        $('input[value="-"]').each(function(){
            $(this).removeAttr('disabled')
        })
    } else {
        $('input[value="-"]').attr('disabled', true)
    }

}
});