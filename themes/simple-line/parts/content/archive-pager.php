<?php
  $prev_link = get_previous_posts_link('< 前のページへ');
  $next_link = get_next_posts_link('次のページへ >');
  if (isset($prev_link) or isset($next_link)) {
?>
<ul class="pager pager--archive">
<?php
  if (isset($prev_link)) {
?>
<li class="pager__item pager__item--prev" id="prev"><?php echo $prev_link; ?></li>
<?php
  }
  if (isset($next_link)) {
?>
<li class="pager__item pager__item--next" id="next"><?php echo $next_link; ?></li>
<?php
  }
?>
</ul>
<?php
  }
?>