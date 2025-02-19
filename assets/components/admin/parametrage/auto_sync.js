$(document).ready(function () {
    $(".block_page").html('Synchronisation programmée à minuit...');

    let syncCount = 0;
    const maxSyncs = 3;

    function getTimeUntilTargetHour(targetHour) {
        const now = new Date();
        const targetTime = new Date();
        targetTime.setHours(targetHour, 0, 0, 0);

        if (now.getTime() > targetTime.getTime()) {
            targetTime.setDate(targetTime.getDate() + 1);
        }

        return targetTime.getTime() - now.getTime();
    }

    setTimeout(() => {
        console.log("Starting synchronization at 5 PM...");
        startSync();
    }, getTimeUntilTargetHour(0));


    async function startSync() {
        if (syncCount >= maxSyncs) {
            console.log("Max synchronizations reached. Stopping...");
            return;
        }

        syncCount++;
        await syncArticles();
        await syncDemandeCab();
        await syncDemandeDet();
        await syncLivraisonCab();
        await syncLivraisonDet();
        await syncLivraisonLot();

        console.log(`Synchronization ${syncCount} completed.`);

        if (syncCount < maxSyncs) {
            console.log("Next synchronization scheduled in 24 hours.");
            setTimeout(startSync, 24 * 60 * 60 * 1000);
        } else {
            console.log("All synchronizations done.");
        }
    }

    async function syncTable(iconClass, route, contentClass) {
        const icon = $(iconClass);
        icon.removeClass("fa-edit").addClass("fa-spinner fa-spin");

        while (true) {
            try {
                const request = await axios.post(Routing.generate(route));
                const response = request.data;

                $(contentClass).text(` (Ajoutée: ${response.countInserted} | Total: ${response.countTotal})`).css('color', 'green');

                if (response.countInserted === 0) {
                    icon.addClass("fa-check").removeClass("fa-spinner fa-spin");
                    break;
                }
            } catch (error) {
                const message = error.response ? error.response.data : error.message;
                $(contentClass).text(`(Erreur: ${message})`).css('color', 'red');
                console.error(`Error in ${route}:`, message);
                await new Promise(resolve => setTimeout(resolve, 5000));
            }
        }
    }

    async function syncArticles() { await syncTable(".syn_articles", "api_article", ".syn_articles_content"); }
    async function syncDemandeCab() { await syncTable(".syn_demandecab", "api_demande_cab", ".syn_demandecab_content"); }
    async function syncDemandeDet() { await syncTable(".syn_demandedet", "api_demande_det", ".syn_demandedet_content"); }
    async function syncLivraisonCab() { await syncTable(".syn_livraisoncab", "api_livraison_cab", ".syn_livraisoncab_content"); }
    async function syncLivraisonDet() { await syncTable(".syn_livraisondet", "api_livraison_det", ".syn_livraisondet_content"); }
    async function syncLivraisonLot() { await syncTable(".syn_livraisonlot", "api_livraison_lot", ".syn_livraisonlot_content"); }
});
