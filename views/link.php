<?php foreach ($contents as $data) :?>
<?=$before;?>
<?=date('M jS, Y',$data["date"]);?>
    <a href="<?=$data["url"];?>"><?=$data["title"];?></a> 
<?=$data["description"];?>
<?=$after;?>
<?php endforeach;?>
