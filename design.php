<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RandomNote</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="javascript.js"></script>
</head>
<body>
    <div class="main_wrap">
        <div class="content_wrap">
            <?php 
                if(isset($content))
                    echo $content;
            ?>
            
            <?php if(isset($note_output))
            {
            ?>
            
            <h2 id="title"></h2>
            <div id="content" style="min-height: 30px;"></div>
            <button type="button" class="btn btn-info" id="next" style="margin-top: 12px;">Next</button>
            <button type="button" class="btn btn-default" id="exit" style="margin-top: 12px; float:right;">Exit</button>
            <script>
                index = 0;
            
                function shuffleArray(array) {
                    for (var i = array.length - 1; i > 0; i--) {
                        var j = Math.floor(Math.random() * (i + 1));
                        var temp = array[i];
                        array[i] = array[j];
                        array[j] = temp;
                    }
                    return array;
                }
                
                function doNext(){
                    $("#title").text(data[index].title);
                    $("#content").html(data[index].content);
                    
                    index++;
                    if(index == data.length)
                        index = 0;
                }
                
                function init(){
                    data = <?php echo json_encode($note_output); ?>;
                
                    data = shuffleArray(data);
                    
                    for(var i = 0; i < data.length; i++){
                        console.log(data[i].title);
                    }
                    
                    $("#next").click(doNext);
                    $("#exit").click(function(){
                        window.location.href = 'http://umkkd9317f21.moritzgoeckel.koding.io/RandomNote/';
                    });
                    
                    doNext();
                }
                
                init();
                
            </script>
            
            <?php 
            }
            ?>
        </div>
    </div>
</body>
</html>