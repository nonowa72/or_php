$(function(){

	$(window).load(function(){
		$("#wrapper").fadeOut(0);
		$("#wrapper").fadeIn(500);

        $("#listBox>li").each(function(i){
                $(this)
                .css({"left":"800px"})
        });    

		slideList();
	});


    $("#categoryList").children().click(function(){

		if($(this).text()!="ALL"){
			$("#listBox>li").css({"display":"none"});
            $("."+$(this).text()).each(function(i){
                $(this).css({"display":"block"});
                $(this)
                .delay(i*100)
                .css({"opacity":"0"})
                .animate({"left":"0px","opacity":"1"},850,'easeOutCubic');
        
            });  
		}
		else{
              $("#listBox>li").each(function(i){
                $(this).css({"display":"block"});
                $(this)
                .delay(i*100)
                .css({"opacity":"0"})
                .animate({"left":"0px","opacity":"1"},850,'easeOutCubic');
            
                });   
            }

	});

    $(".dustCheck").click(
        function(){

            if($(this).attr("checked")!="checked"){
                $(this).parent().find(".dustBox").css({"background-image":"url(./img/dustBox2.png)"});
                $(this).attr("checked", true);
              }
            else{
                $(this).parent().find(".dustBox").css({"background-image":"url(./img/dustBox.png)"});
                $(this).attr("checked", false);
            }
        }
    );

});


function slideList(){

    $("#listBox>li").each(function(i){
			$(this)
			.delay(i*100)
			.css({"opacity":"0"})
            .animate({"left":"0px","opacity":"1"},850,'easeOutCubic');

	});    
}

