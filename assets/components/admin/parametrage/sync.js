
$(document).ready(function () {
    $(".block_page").html('Synchronisation')

    $("body .synchronisation_data").on("click", async function (e) {
        e.preventDefault();
        syncArticles()
        $('.synchronisation_data').addClass('disabled')
    });

    const syncArticles = async () => {
        const icon = $(".syn_articles");
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");
        try {
            const request = await axios.post(Routing.generate('api_article'));
            const response = request.data;
            $('.syn_articles_content').text(' (Ajoutée: ' + response.countInserted  + '| Total: ' + response.countTotal + ')').css('color', 'green')
            if(response.countInserted != 0){
                syncArticles()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                syncDemandeCab()
            }
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
            if(response.countInserted != 0){
                syncDemandeCab()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                syncDemandeDet()
            }
        } catch (error) {
            const message = error.response;
            $('.syn_demandecab_content').text('(' + message + ')').css('color', 'red')
        }
    }

    const syncDemandeDet = async () => {
        const icon = $(".syn_demandedet");
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");
        try {
            const request = await axios.post(Routing.generate('api_demande_det'));
            const response = request.data;
            $('.syn_demandedet_content').text(' (Ajoutée: ' + response.countInserted  + '| Total: ' + response.countTotal + ')').css('color', 'green')
            if(response.countInserted != 0){
                syncDemandeDet()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                syncLivraisonCab()
            }
        } catch (error) {
            const message = error.response;
            $('.syn_demandedet_content').text('(' + message + ')').css('color', 'red')
        }
    }

    const syncLivraisonCab = async () => {
        const icon = $(".syn_livraisoncab");
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");
        try {
            const request = await axios.post(Routing.generate('api_livraison_cab'));
            const response = request.data;
            $('.syn_livraisoncab_content').text(' (Ajoutée: ' + response.countInserted  + '| Total: ' + response.countTotal + ')').css('color', 'green')
            if(response.countInserted != 0){
                syncLivraisonCab()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                syncLivraisonDet()
            }
        } catch (error) {
            const message = error.response;
            $('.syn_livraisoncab_content').text('(' + message + ')').css('color', 'red')
        }
    }

    const syncLivraisonDet = async () => {
        const icon = $(".syn_livraisondet");
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");
        try {
            const request = await axios.post(Routing.generate('api_livraison_det'));
            const response = request.data;
            $('.syn_livraisondet_content').text(' (Ajoutée: ' + response.countInserted  + '| Total: ' + response.countTotal + ')').css('color', 'green')
            if(response.countInserted != 0){
                syncLivraisonDet()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                syncLivraisonLot()
            }
        } catch (error) {
            const message = error.response;
            $('.syn_livraisondet_content').text('(' + message + ')').css('color', 'red')
        }
    }

    const syncLivraisonLot = async () => {
        const icon = $(".syn_livraisonlot");
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");
        try {
            const request = await axios.post(Routing.generate('api_livraison_lot'));
            const response = request.data;
            $('.syn_livraisonlot_content').text(' (Ajoutée: ' + response.countInserted  + '| Total: ' + response.countTotal + ')').css('color', 'green')
            if(response.countInserted != 0){
                syncLivraisonLot()
            }else{
                icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                return;
            }
        } catch (error) {
            const message = error.response;
            $('.syn_livraisonlot_content').text('(' + message + ')').css('color', 'red')
        }
    }


})
