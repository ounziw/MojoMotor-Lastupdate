<?php foreach ($contents as $data) :?>
<?=$before;?>
<?=date($data["date"]);?>
    <a href="<?=$data["url"];?>"><?=$data["title"];?></a> 
<?=$data["description"];?>
<?=$after;?>
<?php endforeach;?>
