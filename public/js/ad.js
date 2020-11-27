$('#add-image').click(function() {
//je recupere le numero des futures champs que je vais creer
    //const index = $('#ad_images div.form-group').length;
    const index = +$('#widgets-counter').val();
    console.log(index);

    //je recupere le prototype des entrées
    const tmpl= $('#ad_images').data('prototype').replace(/__name__/g,index);
    // j'injecte ce code au sein de la div ad_images
    $('#ad_images').append(tmpl);
    $('#widgets-counter').val(index +1)

// je gère le button supprimer
    handleDeleteButtons();
});
function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function () {
        const target= this.dataset.target;

        $(target).remove();

    });
}
function updateCounter(){
    const count= +$('#ad_images div.form-group').length;

    $('#widgets-counter').val(count);
}
updateCounter();
handleDeleteButtons()