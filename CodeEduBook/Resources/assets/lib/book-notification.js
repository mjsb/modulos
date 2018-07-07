module.exports = {
    init(){
        if(window.Laravel.userId !== null){
            window.Echo.private('CodeEduUser.Models.User.' + window.Laravel.userId)
                .notification(function(notification) {
                    console.log(notification);
                    window.$.notify({message: 'O livro '+ notification.livro.title+ ' foi exportado!'},{type: 'success'});
                })
        }
    }
}