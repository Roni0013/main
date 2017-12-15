<?php

//debug ($query->Customer);


?>

<div class="panel panel-default">
  <div class="panel-heading">Извещение №<?=$query->number ?></div>
  <div class="panel-body">
      <div><?=$query->info ?></div>
      <div><?=$query->aucDate ?></div>
      <div><?=$query->maxPrice ?></div>
      <div><?=$query->customer->Name ?></div>
      <div><?=$query->customer->Address ?></div>
  </div>
</div>
