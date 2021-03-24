$(function(){
	var pageID = <?php echo $pageID;  ?>;

$('.like-btn').click(function(){
	$('.dislike-btn').removeClass('dislike-h');
    	$(this).addClass('like-h');
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:'act=like&pageID='+pageID,
                success: function(){
                }
            });
        });
$('.dislike-btn').click(function(){
    $('.like-btn').removeClass('like-h');
         $(this).addClass('dislike-h');
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:'act=dislike&pageID='+pageID,
                success: function(){
                }
            });
        });
$('.share-btn').click(function(){
            $('.share-cnt').toggle();
        });
    });
