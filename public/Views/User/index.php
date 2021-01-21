<?php foreach($Users as $key => $value){?>
    
    <div style="border: solid 3px black; margin: 5px; padding: 5px;"> 
        <?php echo "<a href='".WEBROOT."User/page/".$value['id']."'><h1>Username : ".$value['username']."</h1></a>"; ?> 
        <?php echo "<h2>User mail : ".$value['mail']."</h2>"; ?>    
        <input type='submit' value='Delete ?' formmethod="post" formaction="<?php echo WEBROOT."User/delete/".$value['id'];?>">
    </div>
<?php }?>
