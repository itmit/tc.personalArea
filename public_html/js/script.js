$(function(){
    $(".js-destroy-all").on("click", function() {

        if($(".js-destroy-all").prop("checked")){
            $(".js-destroy").prop("checked", "checked");
        }
        else{
            $(".js-destroy").prop("checked", "");
        }

    });
});

$(function(){
    $(".destroy-all-bidsForBuy").on("click", function() {
        console.log('s');
        if($(".destroy-all-bidsForBuy").prop("checked")){
            $(".js-destroy-bidForBuy").prop("checked", "checked");
        }
        else{
            $(".js-destroy-bidForBuy").prop("checked", "");
        }

    });
});