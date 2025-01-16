
$(document).ready(function () {
    $(".block_page").html('Synchronisation')

    $("body .synchronisation_data").on("click", async function (e) {
        e.preventDefault();
        syncArticles()
        // $('.synchronisation_data').addClass('disabled')

    });

    const syncArticles = async () => {
        const icon = $(".syn_articles");
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");
        try {
            const request = await axios.post(Routing.generate('api_article'));
            const response = request.data;
            $('.syn_articles_content').text(' (Ajoutée: ' + response.countInserted  + '| Total: ' + response.countTotal + ')').css('color', 'green')
            // console.log(response.countInserted);
            // return;
            if(response.countInserted != 0){
                syncArticles()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                return;
            }
            // syncFormation()
        } catch (error) {
            const message = error.response;
            $('.syn_articles_content').text('(' + message + ')').css('color', 'red')
        }

    }

    const syncDemandeCab = async () => {
        const icon = $(".syn_demandecab");
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");
        try {
            const request = await axios.post(Routing.generate('api_demande_cab'));
            const response = request.data;
            $('.syn_demandecab_content').text(' (Ajoutée: ' + response.countInserted  + '| Total: ' + response.countTotal + ')').css('color', 'green')
            // console.log(response.countInserted);
            // return;
            if(response.countInserted != 0){
                syncArticles()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                return;
            }
            // syncFormation()
        } catch (error) {
            const message = error.response;
            $('.syn_demandecab_content').text('(' + message + ')').css('color', 'red')
        }

    }


})
