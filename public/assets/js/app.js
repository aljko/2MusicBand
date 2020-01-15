$("document").ready(function () {
    $(".hideGallery").hide();
    $("button").on("click", showGallery);
    let $tempGallery = "";
    let $tempPhotoID="";
    let $tempPhotoPath="";
    let $inputHidden;

    function showGallery() {
        if ($tempGallery != "") {
            $("." + $tempGallery).toggle(2000);
        }

        let $gallery = ($(this).attr('id'));

        console.log($gallery);
        $("." + $gallery).toggle(2000);
        $tempGallery = ($(this).attr('id'));
    }
    $(".grid-photo").on("click",showBigImage);
    $(".bigImage").on("click",hideBigImage);

    function showBigImage(){
        $(".hiddenForm"+$tempPhotoID).hide();
        $tempPhotoID=$(this).attr("id");
        $tempPhotoPath=$(this).attr("src");
        console.log($tempPhotoID, $(this).scroll());
        //$(".hiddenForm"+$tempPhotoID).css("top",$(".grid-gallery").position().top+300+"px");
        $(".hiddenForm"+$tempPhotoID).css("top",$(this).position().top+"px");
        $(".hiddenForm"+$tempPhotoID).fadeIn(500);

    }
    function hideBigImage(){
        $(".hiddenForm"+$tempPhotoID).fadeOut(500);
    }

    $("#map").on("click",goTo);

    function goTo(){
        $(location).attr("href","/Concerts/index");
    }

    $(".grid-gallery-image").on("click",showGalleryImage);

    function showGalleryImage(){
        $(".hiddenForm"+$tempPhotoID).hide();
        $tempPhotoID=$(this).attr("id");
        $tempPhotoPath=$(this).attr("src");
        console.log($tempPhotoID, $(this).scroll());
        //$(".hiddenForm"+$tempPhotoID).css("top",$(".grid-gallery").position().top+300+"px");
        $(".hiddenForm"+$tempPhotoID).css("top",$(this).position().top+"px");
        $(".hiddenForm"+$tempPhotoID).fadeIn(500);
    }

    $(".site-article-grid-gallery-img").on("click",showGalleryImage);

    function showGalleryImage(){
        $(".hiddenForm"+$tempPhotoID).hide();
        $tempPhotoID=$(this).attr("id");
        $tempPhotoPath=$(this).attr("src");
        console.log($tempPhotoID, $(this).scroll());
        //$(".hiddenForm"+$tempPhotoID).css("top",$(".grid-gallery").position().top+300+"px");
        $(".hiddenForm"+$tempPhotoID).css("top",$(this).position().top+"px");
        $(".hiddenForm"+$tempPhotoID).fadeIn(500);
    }
    $(".site-article-grid-img").on("click",showGalleryImage);

    function showGalleryImage(){
        $(".hiddenForm"+$tempPhotoID).hide();
        $tempPhotoID=$(this).attr("id");
        $tempPhotoPath=$(this).attr("src");
        console.log($tempPhotoID, $(this).scroll());
        //$(".hiddenForm"+$tempPhotoID).css("top",$(".grid-gallery").position().top+300+"px");
        $(".hiddenForm"+$tempPhotoID).css("top",$(this).position().top+"px");
        $(".hiddenForm"+$tempPhotoID).fadeIn(500);
    }

});