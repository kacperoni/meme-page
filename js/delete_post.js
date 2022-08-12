$(document).ready(function(){
    $(".delete_link").on("click",function(){
        var postId = $(this).attr("rel");
        var deleteUrl = "pending.php?delete="+postId;
        $(".delete_post_link").attr("href",deleteUrl);
        $("#exampleModal").modal("show");
    })
});