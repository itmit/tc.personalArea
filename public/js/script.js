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