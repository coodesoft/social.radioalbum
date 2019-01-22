
<?php foreach($artists as $artist) { ?>
  <div class="radio">
    <label>
      <input type="radio" name="artist"  value="<?php echo $artist->id ?>">
      <?php echo $artist->name ?>
    </label>
  </div>
<?php } ?>
